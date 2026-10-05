<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\LandscapeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandscapeBannerController extends Controller
{
    /**
     * Tampilkan daftar semua banner landscape & form penambahan.
     */
    public function index()
    {
        $banners = LandscapeBanner::orderBy('order')->orderByDesc('id')->get();
        return view('dashboard.landscape_banners.index', compact('banners'));
    }

    /**
     * Simpan banner landscape baru ke database & penyimpanan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'nullable|string|max:255',
            'image'     => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'url'       => 'nullable|string|max:255',
            'target'    => 'required|in:_self,_blank',
            'order'     => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ], [
            'image.required' => 'File gambar banner wajib diunggah.',
            'image.image'    => 'File yang diunggah harus berupa gambar yang valid.',
            'image.mimes'    => 'Format gambar yang didukung adalah JPEG, PNG, JPG, atau WEBP.',
            'image.max'      => 'Ukuran file gambar maksimal 4 MB.',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        $validated['order'] = $validated['order'] ?? (LandscapeBanner::max('order') + 1);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('landscape-banners', 'public');
        }

        LandscapeBanner::create($validated);

        return redirect()->route('landscape-banners.index')
            ->with('success', 'Banner landscape berhasil ditambahkan ke homepage!');
    }

    /**
     * Tampilkan form untuk mengedit banner landscape.
     */
    public function edit(LandscapeBanner $landscapeBanner)
    {
        return view('dashboard.landscape_banners.edit', compact('landscapeBanner'));
    }

    /**
     * Perbarui data banner landscape.
     */
    public function update(Request $request, LandscapeBanner $landscapeBanner)
    {
        $validated = $request->validate([
            'title'     => 'nullable|string|max:255',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'url'       => 'nullable|string|max:255',
            'target'    => 'required|in:_self,_blank',
            'order'     => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ], [
            'image.image' => 'File yang diunggah harus berupa gambar yang valid.',
            'image.mimes' => 'Format gambar yang didukung adalah JPEG, PNG, JPG, atau WEBP.',
            'image.max'   => 'Ukuran file gambar maksimal 4 MB.',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        $validated['order'] = $validated['order'] ?? $landscapeBanner->order;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($landscapeBanner->image && Storage::disk('public')->exists($landscapeBanner->image)) {
                Storage::disk('public')->delete($landscapeBanner->image);
            }
            $validated['image'] = $request->file('image')->store('landscape-banners', 'public');
        }

        $landscapeBanner->update($validated);

        return redirect()->route('landscape-banners.index')
            ->with('success', 'Banner landscape berhasil diperbarui!');
    }

    /**
     * Toggle status aktif/nonaktif banner.
     */
    public function toggle(LandscapeBanner $landscapeBanner)
    {
        $landscapeBanner->is_active = !$landscapeBanner->is_active;
        $landscapeBanner->save();

        $status = $landscapeBanner->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Banner \"{$landscapeBanner->title}\" berhasil {$status}!");
    }

    /**
     * Hapus banner landscape dan filenya.
     */
    public function destroy(LandscapeBanner $landscapeBanner)
    {
        if ($landscapeBanner->image && Storage::disk('public')->exists($landscapeBanner->image)) {
            Storage::disk('public')->delete($landscapeBanner->image);
        }

        $landscapeBanner->delete();

        return redirect()->route('landscape-banners.index')
            ->with('success', 'Banner landscape berhasil dihapus!');
    }
}
