<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\InstagramReel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstagramReelController extends Controller
{
    public function index()
    {
        $reels = InstagramReel::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('dashboard.instagram-reels.index', compact('reels'));
    }

    public function create()
    {
        return view('dashboard.instagram-reels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'instagram_url' => 'required|url',
            'thumbnail'     => 'nullable|image|file|max:5120',
            'order'         => 'nullable|integer|min:0',
            'is_active'     => 'nullable|boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('reels-thumbnails', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order']     = $validated['order'] ?? 0;

        InstagramReel::create($validated);

        return redirect()->route('instagram-reels.index')->with('success', 'Reel berhasil ditambahkan!');
    }

    public function show(InstagramReel $instagramReel)
    {
        return redirect()->route('instagram-reels.edit', $instagramReel);
    }

    public function edit(InstagramReel $instagramReel)
    {
        return view('dashboard.instagram-reels.edit', compact('instagramReel'));
    }

    public function update(Request $request, InstagramReel $instagramReel)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'instagram_url' => 'required|url',
            'thumbnail'     => 'nullable|image|file|max:5120',
            'order'         => 'nullable|integer|min:0',
            'is_active'     => 'nullable|boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($instagramReel->thumbnail) {
                Storage::disk('public')->delete($instagramReel->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('reels-thumbnails', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order']     = $validated['order'] ?? $instagramReel->order;

        $instagramReel->update($validated);

        return redirect()->route('instagram-reels.index')->with('success', 'Reel berhasil diperbarui!');
    }

    public function destroy(InstagramReel $instagramReel)
    {
        if ($instagramReel->thumbnail) {
            Storage::disk('public')->delete($instagramReel->thumbnail);
        }
        $instagramReel->delete();
        return redirect()->route('instagram-reels.index')->with('success', 'Reel berhasil dihapus!');
    }
}
