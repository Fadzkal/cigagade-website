<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TiktokVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TiktokVideoController extends Controller
{
    public function index()
    {
        $videos = TiktokVideo::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('dashboard.tiktok-videos.index', compact('videos'));
    }

    public function create()
    {
        return view('dashboard.tiktok-videos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'tiktok_url' => 'required|url',
            'thumbnail'  => 'nullable|image|file|max:5120',
            'order'      => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('tiktok-thumbnails', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order']     = $validated['order'] ?? 0;

        TiktokVideo::create($validated);

        return redirect()->route('tiktok-videos.index')->with('success', 'Video TikTok berhasil ditambahkan!');
    }

    public function show(TiktokVideo $tiktokVideo)
    {
        return redirect()->route('tiktok-videos.edit', $tiktokVideo);
    }

    public function edit(TiktokVideo $tiktokVideo)
    {
        return view('dashboard.tiktok-videos.edit', compact('tiktokVideo'));
    }

    public function update(Request $request, TiktokVideo $tiktokVideo)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'tiktok_url' => 'required|url',
            'thumbnail'  => 'nullable|image|file|max:5120',
            'order'      => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($tiktokVideo->thumbnail) {
                Storage::disk('public')->delete($tiktokVideo->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('tiktok-thumbnails', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order']     = $validated['order'] ?? $tiktokVideo->order;

        $tiktokVideo->update($validated);

        return redirect()->route('tiktok-videos.index')->with('success', 'Video TikTok berhasil diperbarui!');
    }

    public function destroy(TiktokVideo $tiktokVideo)
    {
        if ($tiktokVideo->thumbnail) {
            Storage::disk('public')->delete($tiktokVideo->thumbnail);
        }
        $tiktokVideo->delete();

        return redirect()->route('tiktok-videos.index')->with('success', 'Video TikTok berhasil dihapus!');
    }
}
