<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HeroSlideController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $slides = HeroSlide::with('post')->orderBy('order')->get();
        return view('dashboard.hero_slides.index', compact('slides'));
    }

    public function create()
    {
        $posts = Post::latest()->get();
        return view('dashboard.hero_slides.create', compact('posts'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:post,youtube',
            'post_id' => 'nullable|exists:posts,id',
            'youtube_url' => 'nullable|url|max:255',
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|file|max:2048',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
        ]);

        if (!isset($validatedData['is_active'])) {
            $validatedData['is_active'] = false;
        }

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('hero-slides', 'public');
        }

        HeroSlide::create($validatedData);

        return redirect()->route('hero-slides.index')->with('success', 'Slide berhasil ditambahkan!');
    }

    public function show(HeroSlide $heroSlide)
    {
        return redirect()->route('hero-slides.edit', $heroSlide);
    }

    public function edit(HeroSlide $heroSlide)
    {
        $posts = Post::latest()->get();
        return view('dashboard.hero_slides.edit', compact('heroSlide', 'posts'));
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:post,youtube',
            'post_id' => 'nullable|exists:posts,id',
            'youtube_url' => 'nullable|url|max:255',
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|file|max:2048',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
        ]);

        if (!isset($validatedData['is_active'])) {
            $validatedData['is_active'] = false;
        }

        if ($request->hasFile('image')) {
            if ($request->oldImage) {
                Storage::disk('public')->delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('hero-slides', 'public');
        }

        $heroSlide->update($validatedData);

        return redirect()->route('hero-slides.index')->with('success', 'Slide berhasil diperbarui!');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->image) {
            Storage::disk('public')->delete($heroSlide->image);
        }
        $heroSlide->delete();
        return redirect()->route('hero-slides.index')->with('success', 'Slide berhasil dihapus!');
    }
}
