<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    /**
     * Menampilkan daftar semua berita dengan filter Wilayah (RW) dan Status Validasi.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $rw = $request->query('rw');
        $search = $request->query('search');

        $query = Post::with(['category', 'user', 'validator'])
            ->whereHas('category', function($q) {
                $q->whereNotIn('name', ['Prestasi', 'Pengumuman']);
            })
            ->latest();

        // Filter Pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Filter Status Validasi
        if ($status && in_array($status, ['pending', 'published', 'rejected'])) {
            $query->where('status', $status);
        }

        // Filter Wilayah RW
        if ($request->filled('rw')) {
            if ($rw === 'umum') {
                $query->whereNull('rw');
            } elseif (is_numeric($rw) && (int)$rw >= 1 && (int)$rw <= 10) {
                $query->where('rw', (int)$rw);
            }
        }

        // Jika bukan superadmin dan pengguna adalah akun RW, beri kemudahan melihat berita wilayahnya
        $user = auth()->user();

        $posts = $query->paginate(15)->withQueryString();

        // Hitung statistik status untuk tab navigasi
        $baseCount = Post::whereHas('category', function($q) {
            $q->whereNotIn('name', ['Prestasi', 'Pengumuman']);
        });

        if ($request->filled('rw')) {
            if ($rw === 'umum') {
                $baseCount->whereNull('rw');
            } elseif (is_numeric($rw)) {
                $baseCount->where('rw', (int)$rw);
            }
        }

        $stats = [
            'all'       => (clone $baseCount)->count(),
            'pending'   => (clone $baseCount)->where('status', 'pending')->count(),
            'published' => (clone $baseCount)->where('status', 'published')->count(),
            'rejected'  => (clone $baseCount)->where('status', 'rejected')->count(),
        ];

        return view('dashboard.posts.index', [
            'posts'      => $posts,
            'selectedRw' => $rw,
            'status'     => $status,
            'search'     => $search,
            'stats'      => $stats,
        ]);
    }

    /**
     * Menampilkan form untuk membuat berita baru.
     */
    public function create()
    {
        $categories = Category::whereNotIn('name', ['Prestasi', 'Pengumuman'])->get();

        return view('dashboard.posts.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Menyimpan berita baru ke database.
     * Jika dibuat oleh akun RW/PKK -> status 'pending' (menunggu validasi Super Admin).
     * Jika dibuat oleh Super Admin -> status 'published' (langsung tayang).
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'        => 'required|string|max:255|unique:posts',
            'title_en'     => 'nullable|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'rw'           => 'nullable|integer|between:1,10',
            'image'        => 'nullable|image|file|max:5120',
            'excerpt'      => 'required|string',
            'excerpt_en'   => 'nullable|string',
            'content'      => 'required|string',
            'content_en'   => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug($validatedData['title']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('post-images', $filename, 'public');
            $validatedData['image'] = $imagePath;
        }

        $validatedData['slug']    = Str::slug($validatedData['title'], '-');
        $validatedData['user_id'] = auth()->id();

        // Otomatis kaitkan wilayah jika login sebagai RW
        if (auth()->user()->isRw()) {
            $validatedData['rw'] = auth()->user()->rw;
        } else {
            $validatedData['rw'] = $request->filled('rw') ? (int)$request->rw : null;
        }

        // Generate slug_en dari title_en
        if (!empty($validatedData['title_en'])) {
            $validatedData['slug_en'] = Str::slug($validatedData['title_en'], '-');
        }

        // Normalisasi field bahasa Inggris
        $this->normalizeLanguageFields($validatedData);

        // LOGIKA VALIDASI:
        // Super Admin -> langsung published
        // Akun RW / PKK / Lainnya -> status pending (menunggu validasi Super Admin)
        if (auth()->user()->isSuperAdmin()) {
            $validatedData['status']       = 'published';
            $validatedData['published_at'] = $validatedData['published_at'] ?? now();
            $validatedData['validated_by'] = auth()->id();
            $validatedData['validated_at'] = now();
            $message = 'Berita baru berhasil dibuat dan langsung dipublikasikan ke website portal desa!';
        } else {
            $validatedData['status']       = 'pending';
            $validatedData['published_at'] = null; // Belum tayang sampai disetujui Super Admin
            $validatedData['validated_by'] = null;
            $validatedData['validated_at'] = null;
            $message = 'Berita berhasil dikirim! Menunggu pemeriksaan & validasi Super Admin sebelum tayang di portal publik.';
        }

        Post::create($validatedData);

        return redirect()->route('posts.index')->with('success', $message);
    }

    /**
     * Menampilkan form untuk mengedit berita.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::whereNotIn('name', ['Prestasi', 'Pengumuman'])->get();

        return view('dashboard.posts.edit', [
            'post'       => $post,
            'categories' => $categories
        ]);
    }

    /**
     * Mengupdate data berita di database.
     * Jika diedit oleh non-superadmin, status kembali menjadi 'pending' untuk diverifikasi ulang.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validatedData = $request->validate([
            'title' => [
                'required', 'string', 'max:255',
                Rule::unique('posts')->ignore($post->id),
            ],
            'title_en'     => 'nullable|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'rw'           => 'nullable|integer|between:1,10',
            'image'        => 'nullable|image|file|max:5120',
            'excerpt'      => 'required|string',
            'excerpt_en'   => 'nullable|string',
            'content'      => 'required|string',
            'content_en'   => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            if ($request->oldImage) {
                Storage::disk('public')->delete($request->oldImage);
            }
            $file = $request->file('image');
            $filename = Str::slug($validatedData['title']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('post-images', $filename, 'public');
            $validatedData['image'] = $imagePath;
        }

        $validatedData['slug'] = Str::slug($validatedData['title'], '-');

        // Update RW
        if (auth()->user()->isRw()) {
            $validatedData['rw'] = auth()->user()->rw;
        } else {
            $validatedData['rw'] = $request->filled('rw') ? (int)$request->rw : null;
        }

        // Slug English
        if (!empty($validatedData['title_en'])) {
            if ($validatedData['title_en'] !== $post->title_en) {
                $validatedData['slug_en'] = Str::slug($validatedData['title_en'], '-');
            }
        } else {
            $validatedData['slug_en'] = null;
        }

        // Normalisasi field bahasa Inggris
        $this->normalizeLanguageFields($validatedData);

        // Logika Status saat Update:
        if (auth()->user()->isSuperAdmin()) {
            // Super Admin dapat langsung mempertahankan status published
            $validatedData['published_at'] = $validatedData['published_at'] ?? $post->published_at ?? now();
            $message = 'Berita berhasil diperbarui!';
        } else {
            // Jika akun non-superadmin (RW/PKK) merevisi berita, status kembali ke 'pending' agar dicek ulang
            $validatedData['status']         = 'pending';
            $validatedData['published_at']   = null;
            $validatedData['rejection_note'] = null;
            $message = 'Perubahan berita berhasil disimpan dan kembali masuk ke antrean validasi Super Admin.';
        }

        $post->update($validatedData);

        return redirect()->route('posts.index')->with('success', $message);
    }

    /**
     * (KHUSUS SUPER ADMIN)
     * Setujui & Publikasikan berita ke portal website.
     */
    public function approve(Post $post)
    {
        Gate::authorize('isSuperAdmin');

        $post->update([
            'status'         => 'published',
            'published_at'   => now(),
            'validated_by'   => auth()->id(),
            'validated_at'   => now(),
            'rejection_note' => null,
        ]);

        return back()->with('success', "Berita \"{$post->title}\" berhasil disetujui dan telah tayang di website publik!");
    }

    /**
     * (KHUSUS SUPER ADMIN)
     * Tolak berita dengan catatan revisi untuk pembuat berita.
     */
    public function reject(Request $request, Post $post)
    {
        Gate::authorize('isSuperAdmin');

        $request->validate([
            'rejection_note' => 'required|string|max:1000',
        ], [
            'rejection_note.required' => 'Mohon sertakan alasan penolakan atau catatan perbaikan.',
        ]);

        $post->update([
            'status'         => 'rejected',
            'validated_by'   => auth()->id(),
            'validated_at'   => now(),
            'rejection_note' => $request->rejection_note,
        ]);

        return back()->with('success', "Berita \"{$post->title}\" telah ditolak/dikembalikan ke pembuat berita dengan catatan perbaikan.");
    }

    /**
     * Menghapus data berita dari database.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Berita berhasil dihapus!');
    }

    /**
     * Normalisasi data konten multi-bahasa agar tag kosong dari editor tidak disimpan
     */
    private function normalizeLanguageFields(array &$data): void
    {
        if (isset($data['content_en'])) {
            $raw = $data['content_en'];
            $hasMedia = str_contains($raw, '<img') || str_contains($raw, '<iframe') || str_contains($raw, '<video');
            $clean = preg_replace('/[\s\x{00a0}\x{200b}]+/u', '', html_entity_decode(strip_tags($raw), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if ($clean === '' && !$hasMedia) {
                $data['content_en'] = null;
            }
        }

        if (isset($data['title_en']) && empty(trim($data['title_en']))) {
            $data['title_en'] = null;
            $data['slug_en'] = null;
        }

        if (isset($data['excerpt_en']) && empty(trim($data['excerpt_en']))) {
            $data['excerpt_en'] = null;
        }
    }
}
