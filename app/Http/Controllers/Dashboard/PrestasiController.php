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

class PrestasiController extends Controller
{
    use AuthorizesRequests;

    private function getCategory()
    {
        return Category::firstOrCreate(
            ['name' => 'Prestasi'],
            ['slug' => 'prestasi']
        );
    }

    public function index()
    {
        $categoryId = $this->getCategory()->id;
        $posts = Post::with(['user'])->where('category_id', $categoryId)->latest()->get();

        return view('dashboard.prestasi.index', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('dashboard.prestasi.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'        => 'required|string|max:255|unique:posts',
            'image'        => 'nullable|image|file|max:5120',
            'excerpt'      => 'required|string',
            'content'      => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post-images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $validatedData['slug']         = Str::slug($validatedData['title'], '-');
        $validatedData['user_id']      = auth()->id();
        $validatedData['category_id']  = $this->getCategory()->id;
        $validatedData['published_at'] = $validatedData['published_at'] ?? now();

        Post::create($validatedData);

        return redirect()->route('prestasi.index')->with('success', 'Prestasi baru berhasil dipublikasikan!');
    }

    public function edit(Post $prestasi)
    {
        $this->authorize('update', $prestasi);

        return view('dashboard.prestasi.edit', [
            'post' => $prestasi
        ]);
    }

    public function update(Request $request, Post $prestasi)
    {
        $this->authorize('update', $prestasi);

        $validatedData = $request->validate([
            'title' => [
                'required', 'string', 'max:255',
                Rule::unique('posts')->ignore($prestasi->id),
            ],
            'image'        => 'nullable|image|file|max:5120',
            'excerpt'      => 'required|string',
            'content'      => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            if ($request->oldImage) {
                Storage::disk('public')->delete($request->oldImage);
            }
            $imagePath = $request->file('image')->store('post-images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $validatedData['slug']         = Str::slug($validatedData['title'], '-');
        $validatedData['published_at'] = $validatedData['published_at'] ?? $prestasi->published_at ?? now();

        $prestasi->update($validatedData);

        return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil diperbarui!');
    }

    public function destroy(Post $prestasi)
    {
        $this->authorize('delete', $prestasi);

        if ($prestasi->image) {
            Storage::disk('public')->delete($prestasi->image);
        }

        $prestasi->delete();

        return redirect()->route('prestasi.index')->with('success', 'Prestasi berhasil dihapus!');
    }
}
