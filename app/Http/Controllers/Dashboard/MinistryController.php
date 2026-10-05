<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ministry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import Trait

class MinistryController extends Controller
{
    use AuthorizesRequests; // Gunakan Trait

    /**
     * Menampilkan daftar kementerian.
     */
    public function index()
    {
        $ministries = Ministry::latest()->get();
        return view('dashboard.ministries.index', compact('ministries'));
    }

    /**
     * Menampilkan form tambah.
     */
    public function create()
    {
        return view('dashboard.ministries.create');
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|file|max:2048', // maks 2MB
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('ministry-images', 'public');
            $validatedData['image'] = $imagePath;
        }

        Ministry::create($validatedData);

        return redirect()->route('ministries.index')->with('success', 'Kementerian berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ministry $ministry)
    {
        // Tidak dipakai, langsung ke edit
        return redirect()->route('ministries.edit', $ministry);
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Ministry $ministry)
    {
        return view('dashboard.ministries.edit', compact('ministry'));
    }

    /**
     * Mengupdate data.
     */
    public function update(Request $request, Ministry $ministry)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|file|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($request->oldImage) {
                Storage::disk('public')->delete($request->oldImage);
            }
            // Upload gambar baru
            $imagePath = $request->file('image')->store('ministry-images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $ministry->update($validatedData);

        return redirect()->route('ministries.index')->with('success', 'Kementerian berhasil diperbarui!');
    }

    /**
     * Menghapus data.
     */
    public function destroy(Ministry $ministry)
    {
        // Hapus gambar dari storage
        if ($ministry->image) {
            Storage::disk('public')->delete($ministry->image);
        }

        // Hapus data dari database
        $ministry->delete();

        return redirect()->route('ministries.index')->with('success', 'Kementerian berhasil dihapus!');
    }
}
