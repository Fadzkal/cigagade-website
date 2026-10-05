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

class PengumumanController extends Controller
{
    use AuthorizesRequests;

    private function getCategory()
    {
        return Category::firstOrCreate(
            ['name' => 'Pengumuman'],
            ['slug' => 'pengumuman']
        );
    }

    public function index()
    {
        $categoryId = $this->getCategory()->id;
        $posts = Post::with(['user'])->where('category_id', $categoryId)->latest()->get();

        return view('dashboard.pengumuman.index', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('dashboard.pengumuman.create');
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

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman baru berhasil dipublikasikan!');
    }

    public function edit(Post $pengumuman)
    {
        $this->authorize('update', $pengumuman);

        return view('dashboard.pengumuman.edit', [
            'post' => $pengumuman
        ]);
    }

    public function update(Request $request, Post $pengumuman)
    {
        $this->authorize('update', $pengumuman);

        $validatedData = $request->validate([
            'title' => [
                'required', 'string', 'max:255',
                Rule::unique('posts')->ignore($pengumuman->id),
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
        $validatedData['published_at'] = $validatedData['published_at'] ?? $pengumuman->published_at ?? now();

        $pengumuman->update($validatedData);

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy(Post $pengumuman)
    {
        $this->authorize('delete', $pengumuman);

        if ($pengumuman->image) {
            Storage::disk('public')->delete($pengumuman->image);
        }

        $pengumuman->delete();

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus!');
    }
}
