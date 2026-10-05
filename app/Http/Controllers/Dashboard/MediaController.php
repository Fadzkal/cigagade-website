<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $mediaItems = Media::orderBy('order')->latest()->get();
        return view('dashboard.media.index', compact('mediaItems'));
    }

    public function create()
    {
        return view('dashboard.media.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:image,social',
            'image'       => 'nullable|image|file|max:5120',
            'url'         => 'nullable|string|max:1000',
            'platform'    => 'nullable|in:instagram,tiktok,youtube,other',
            'is_featured' => 'nullable|boolean',
            'order'       => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('media-images', 'public');
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['order'] = $request->input('order', 0);

        Media::create($validated);

        return redirect()->route('media.index')->with('success', 'Media berhasil ditambahkan!');
    }

    public function show(Media $medium)
    {
        return redirect()->route('media.edit', $medium);
    }

    public function edit(Media $medium)
    {
        return view('dashboard.media.edit', compact('medium'));
    }

    public function update(Request $request, Media $medium)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:image,social',
            'image'       => 'nullable|image|file|max:5120',
            'url'         => 'nullable|string|max:1000',
            'platform'    => 'nullable|in:instagram,tiktok,youtube,other',
            'is_featured' => 'nullable|boolean',
            'order'       => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($medium->image) {
                Storage::disk('public')->delete($medium->image);
            }
            $validated['image'] = $request->file('image')->store('media-images', 'public');
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['order'] = $request->input('order', $medium->order);

        $medium->update($validated);

        return redirect()->route('media.index')->with('success', 'Media berhasil diperbarui!');
    }

    public function destroy(Media $medium)
    {
        if ($medium->image) {
            Storage::disk('public')->delete($medium->image);
        }
        $medium->delete();
        return redirect()->route('media.index')->with('success', 'Media berhasil dihapus!');
    }
}
