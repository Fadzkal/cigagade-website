<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class GalleryController extends Controller
{
    use AuthorizesRequests;

    /**
     * Menampilkan daftar galeri.
     */
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('dashboard.galleries.index', compact('galleries'));
    }

    /**
     * Menampilkan form tambah.
     */
    public function create()
    {
        return view('dashboard.galleries.create');
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|file|max:2048', // wajib ada saat create
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gallery-images', 'public');
            $validatedData['image'] = $imagePath;
        }

        Gallery::create($validatedData);

        return redirect()->route('galleries.index')->with('success', 'Gambar berhasil di-upload!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        return redirect()->route('galleries.edit', $gallery);
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Gallery $gallery)
    {
        return view('dashboard.galleries.edit', compact('gallery'));
    }

    /**
     * Mengupdate data.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|file|max:2048', // Boleh kosong saat update
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($request->oldImage) {
                Storage::disk('public')->delete($request->oldImage);
            }
            // Upload gambar baru
            $imagePath = $request->file('image')->store('gallery-images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $gallery->update($validatedData);

        return redirect()->route('galleries.index')->with('success', 'Gambar berhasil diperbarui!');
    }

    /**
     * Menghapus data.
     */
    public function destroy(Gallery $gallery)
    {
        // Hapus gambar dari storage
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        // Hapus data dari database
        $gallery->delete();

        return redirect()->route('galleries.index')->with('success', 'Gambar berhasil dihapus!');
    }
}
