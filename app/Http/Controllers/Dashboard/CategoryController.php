<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category; // 1. IMPORT MODEL CATEGORY
use Illuminate\Http\Request;
use Illuminate\Support\Str; // 2. IMPORT STR (untuk membuat slug)
use Illuminate\Validation\Rule; // 3. IMPORT RULE (untuk validasi unik saat update)

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori.
     */
    public function index()
    {
        $categories = Category::latest()->get();

        return view('dashboard.categories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name'], '-');

        Category::create($validatedData);

        return redirect()->route('categories.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     * (Kita tidak pakai fungsi ini)
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * (FUNGSI BARU)
     * Menampilkan form untuk mengedit kategori.
     * Perhatikan kita ganti $id menjadi 'Category $category'.
     * Ini adalah Route Model Binding.
     */
    public function edit(Category $category)
    {
        // $category sudah berisi data kategori yang dicari berdasarkan ID
        return view('dashboard.categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * (FUNGSI BARU)
     * Mengupdate data kategori di database.
     */
    public function update(Request $request, Category $category)
    {
        // Validasi
        $validatedData = $request->validate([
            // 'name' harus unik, TAPI boleh sama dengan nama lama ($category->name)
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id),
            ],
        ]);

        // Buat slug baru
        $validatedData['slug'] = Str::slug($validatedData['name'], '-');

        // Update data di database
        $category->update($validatedData);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * (FUNGSI BARU)
     * Menghapus data kategori dari database.
     */
    public function destroy(Category $category)
    {
        // Hapus data
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
