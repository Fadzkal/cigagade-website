<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->get();
        return view('dashboard.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('dashboard.videos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'youtube_url'  => 'required|url',
            'thumbnail'    => 'nullable|image|file|max:5120',
            'is_featured'  => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('video-thumbnails', 'public');
        }

        $validated['is_featured']  = $request->boolean('is_featured');
        $validated['published_at'] = $validated['published_at'] ?? now();

        Video::create($validated);

        return redirect()->route('videos.index')->with('success', 'Video berhasil ditambahkan!');
    }

    public function show(Video $video)
    {
        return redirect()->route('videos.edit', $video);
    }

    public function edit(Video $video)
    {
        return view('dashboard.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'youtube_url'  => 'required|url',
            'thumbnail'    => 'nullable|image|file|max:5120',
            'is_featured'  => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('video-thumbnails', 'public');
        }

        $validated['is_featured']  = $request->boolean('is_featured');
        $validated['published_at'] = $validated['published_at'] ?? $video->published_at ?? now();

        $video->update($validated);

        return redirect()->route('videos.index')->with('success', 'Video berhasil diperbarui!');
    }

    public function destroy(Video $video)
    {
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }
        $video->delete();
        return redirect()->route('videos.index')->with('success', 'Video berhasil dihapus!');
    }
}
