<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PartnerController extends Controller
{
    use AuthorizesRequests;

    /**
     * Menampilkan daftar partner.
     */
    public function index()
    {
        $partners = Partner::latest()->get();
        return view('dashboard.partners.index', compact('partners'));
    }

    /**
     * Menampilkan form tambah.
     */
    public function create()
    {
        return view('dashboard.partners.create');
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:kerjasama,media_partner',
            'logo' => 'required|image|file|max:2048', // wajib ada saat create
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('partner-logos', 'public');
            $validatedData['logo'] = $logoPath;
        }

        Partner::create($validatedData);

        return redirect()->route('partners.index')->with('success', 'Rekan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        return redirect()->route('partners.edit', $partner);
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Partner $partner)
    {
        return view('dashboard.partners.edit', compact('partner'));
    }

    /**
     * Mengupdate data.
     */
    public function update(Request $request, Partner $partner)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:kerjasama,media_partner',
            'logo' => 'nullable|image|file|max:2048', // Boleh kosong saat update
        ]);

        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($request->oldLogo) {
                Storage::disk('public')->delete($request->oldLogo);
            }
            // Upload logo baru
            $logoPath = $request->file('logo')->store('partner-logos', 'public');
            $validatedData['logo'] = $logoPath;
        }

        $partner->update($validatedData);

        return redirect()->route('partners.index')->with('success', 'Rekan berhasil diperbarui!');
    }

    /**
     * Menghapus data.
     */
    public function destroy(Partner $partner)
    {
        // Hapus logo dari storage
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        // Hapus data dari database
        $partner->delete();

        return redirect()->route('partners.index')->with('success', 'Rekan berhasil dihapus!');
    }
}
