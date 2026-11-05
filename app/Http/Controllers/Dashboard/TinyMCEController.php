<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TinyMCEController extends Controller
{
    /**
     * Handle image upload from TinyMCE & Quill editors.
     */
    public function upload(Request $request)
    {
        $file = $request->file('file') ?? $request->file('image');

        if (!$file) {
            return response()->json(['message' => 'File gambar tidak ditemukan.'], 422);
        }

        $request->validate([
            'file'  => 'nullable|image|file|max:5120',
            'image' => 'nullable|image|file|max:5120',
        ], [
            'file.image'  => 'File harus berupa gambar (JPG, PNG, atau WEBP).',
            'file.max'    => 'Ukuran gambar maksimal 5 MB.',
            'image.image' => 'File harus berupa gambar (JPG, PNG, atau WEBP).',
            'image.max'   => 'Ukuran gambar maksimal 5 MB.',
        ]);

        $path = $file->store('content-images', 'public');

        return response()->json([
            'location' => asset('storage/' . $path),
            'url'      => asset('storage/' . $path),
        ]);
    }
}
