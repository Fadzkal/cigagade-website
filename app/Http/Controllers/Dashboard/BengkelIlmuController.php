<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BengkelIlmuController extends Controller
{
    use AuthorizesRequests;

    /**
     * Slug-slug kategori yang termasuk dalam Bengkel Ilmu.
     */
    private array $bengkelSlugs = [
        'karir-pengembangan-diri',
        'riset-inovasi',
        'hiburan',
        'institusional',
    ];

    /**
     * Ambil semua kategori Bengkel Ilmu.
     */
    private function getBengkelCategories()
    {
        return Category::whereIn('slug', $this->bengkelSlugs)->get();
    }

    /**
     * Menampilkan daftar semua artikel Bengkel Ilmu.
     */
    public function index()
    {
        $posts = Post::with(['category', 'user'])
            ->whereHas('category', function ($q) {
                $q->whereIn('slug', $this->bengkelSlugs);
            })
            ->latest()
            ->get();

        $categories = $this->getBengkelCategories();

        return view('dashboard.bengkel-ilmu.index', compact('posts', 'categories'));
    }

    /**
     * Menampilkan form untuk membuat artikel baru.
     */
    public function create()
    {
        $categories = $this->getBengkelCategories();

        return view('dashboard.bengkel-ilmu.create', compact('categories'));
    }

    /**
     * Menyimpan artikel baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'        => 'required|string|max:255|unique:posts',
            'category_id'  => 'required|exists:categories,id',
            'image'        => 'nullable|image|file|max:5120',
            'excerpt'      => 'required|string',
            'content'      => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('post-images', 'public');
        }

        $validatedData['slug']         = Str::slug($validatedData['title'], '-');
        $validatedData['user_id']      = auth()->id();
        $validatedData['published_at'] = $validatedData['published_at'] ?? now();

        Post::create($validatedData);

        return redirect()->route('bengkel-ilmu.index')->with('success', 'Artikel Bengkel Ilmu berhasil dipublikasikan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $bengkelIlmu)
    {
        //
    }

    /**
     * Menampilkan form untuk mengedit artikel.
     */
    public function edit(Post $bengkelIlmu)
    {
        $this->authorize('update', $bengkelIlmu);

        $categories = $this->getBengkelCategories();

        return view('dashboard.bengkel-ilmu.edit', [
            'post'       => $bengkelIlmu,
            'categories' => $categories,
        ]);
    }

    /**
     * Mengupdate data artikel di database.
     */
    public function update(Request $request, Post $bengkelIlmu)
    {
        $this->authorize('update', $bengkelIlmu);

        $validatedData = $request->validate([
            'title' => [
                'required', 'string', 'max:255',
                Rule::unique('posts')->ignore($bengkelIlmu->id),
            ],
            'category_id'  => 'required|exists:categories,id',
            'image'        => 'nullable|image|file|max:5120',
            'excerpt'      => 'required|string',
            'content'      => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            if ($bengkelIlmu->image) {
                Storage::disk('public')->delete($bengkelIlmu->image);
            }
            $validatedData['image'] = $request->file('image')->store('post-images', 'public');
        }

        $validatedData['slug']         = Str::slug($validatedData['title'], '-');
        $validatedData['published_at'] = $validatedData['published_at'] ?? $bengkelIlmu->published_at ?? now();

        $bengkelIlmu->update($validatedData);

        return redirect()->route('bengkel-ilmu.index')->with('success', 'Artikel Bengkel Ilmu berhasil diperbarui!');
    }

    /**
     * Menghapus artikel dari database.
     */
    public function destroy(Post $bengkelIlmu)
    {
        $this->authorize('delete', $bengkelIlmu);

        if ($bengkelIlmu->image) {
            Storage::disk('public')->delete($bengkelIlmu->image);
        }

        $bengkelIlmu->delete();

        return redirect()->route('bengkel-ilmu.index')->with('success', 'Artikel Bengkel Ilmu berhasil dihapus!');
    }
}
