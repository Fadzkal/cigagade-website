<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    /**
     * Display a listing of UMKM products.
     */
    public function index(Request $request)
    {
        $query = Umkm::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('seller_name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $umkms = $query->latest()->paginate(10)->withQueryString();

        $categories = [
            'Makanan & Minuman',
            'Pertanian & Perkebunan',
            'Kerajinan Tangan',
            'Fashion & Busana',
            'Peternakan & Perikanan',
            'Jasa & Lainnya',
        ];

        return view('dashboard.umkm.index', compact('umkms', 'categories'));
    }

    /**
     * Show the form for creating a new UMKM product.
     */
    public function create()
    {
        $categories = [
            'Makanan & Minuman',
            'Pertanian & Perkebunan',
            'Kerajinan Tangan',
            'Fashion & Busana',
            'Peternakan & Perikanan',
            'Jasa & Lainnya',
        ];

        return view('dashboard.umkm.create', compact('categories'));
    }

    /**
     * Store a newly created UMKM product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'seller_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'is_active' => 'nullable',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('umkm', 'public');
        }

        Umkm::create($validated);

        return redirect()->route('umkm.admin.index')->with('success', 'Produk UMKM berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified UMKM product.
     */
    public function edit(Umkm $umkm)
    {
        $categories = [
            'Makanan & Minuman',
            'Pertanian & Perkebunan',
            'Kerajinan Tangan',
            'Fashion & Busana',
            'Peternakan & Perikanan',
            'Jasa & Lainnya',
        ];

        return view('dashboard.umkm.edit', compact('umkm', 'categories'));
    }

    /**
     * Update the specified UMKM product in storage.
     */
    public function update(Request $request, Umkm $umkm)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:50',
            'seller_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'is_active' => 'nullable',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($umkm->image && Storage::disk('public')->exists($umkm->image)) {
                Storage::disk('public')->delete($umkm->image);
            }
            $validated['image'] = $request->file('image')->store('umkm', 'public');
        }

        $umkm->update($validated);

        return redirect()->route('umkm.admin.index')->with('success', 'Produk UMKM berhasil diperbarui!');
    }

    /**
     * Remove the specified UMKM product from storage.
     */
    public function destroy(Umkm $umkm)
    {
        if ($umkm->image && Storage::disk('public')->exists($umkm->image)) {
            Storage::disk('public')->delete($umkm->image);
        }

        $umkm->delete();

        return redirect()->route('umkm.admin.index')->with('success', 'Produk UMKM berhasil dihapus!');
    }
}
