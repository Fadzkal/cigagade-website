<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PengaduanAdminController extends Controller
{
    /**
     * Daftar semua pengaduan masyarakat untuk Superadmin
     */
    public function index(Request $request)
    {
        $query = Pengaduan::query();

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Pencarian (Kode Tiket, Nama, Judul, Isi, Lokasi)
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('kode_tiket', 'like', "%{$q}%")
                    ->orWhere('nama', 'like', "%{$q}%")
                    ->orWhere('judul', 'like', "%{$q}%")
                    ->orWhere('isi_pengaduan', 'like', "%{$q}%")
                    ->orWhere('lokasi', 'like', "%{$q}%");
            });
        }

        $pengaduans = $query->latest()->paginate(10)->withQueryString();

        // KPI Metrik
        $stats = [
            'total'    => Pengaduan::count(),
            'menunggu' => Pengaduan::where('status', 'menunggu')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai'  => Pengaduan::where('status', 'selesai')->count(),
            'ditolak'  => Pengaduan::where('status', 'ditolak')->count(),
        ];

        $kategoriList = Pengaduan::KATEGORI_LIST;

        return view('dashboard.pengaduan.index', compact('pengaduans', 'stats', 'kategoriList'));
    }

    /**
     * Tampilkan detail pengaduan & form tanggapan
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $kategoriList = Pengaduan::KATEGORI_LIST;

        return view('dashboard.pengaduan.show', compact('pengaduan', 'kategoriList'));
    }

    /**
     * Update status dan berikan tanggapan resmi
     */
    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $validated = $request->validate([
            'status'         => 'required|in:menunggu,diproses,selesai,ditolak',
            'tanggapan'      => 'nullable|string|max:5000',
            'tanggapan_oleh' => 'nullable|string|max:100',
            'is_public'      => 'nullable|boolean',
        ]);

        $pengaduan->status = $validated['status'];
        $pengaduan->is_public = $request->has('is_public');

        if (!empty(trim($validated['tanggapan'] ?? ''))) {
            $pengaduan->tanggapan = trim($validated['tanggapan']);
            $pengaduan->tanggapan_at = now();
            $pengaduan->tanggapan_oleh = !empty(trim($validated['tanggapan_oleh'] ?? ''))
                ? trim($validated['tanggapan_oleh'])
                : (Auth::user()->name ?? 'Pemerintah Desa Cigagade');
        }

        $pengaduan->save();

        return redirect()->route('pengaduan.admin.show', $pengaduan->id)
            ->with('success', 'Status dan tanggapan pengaduan berhasil diperbarui!');
    }

    /**
     * Hapus data pengaduan
     */
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->foto_bukti && Storage::disk('public')->exists($pengaduan->foto_bukti)) {
            Storage::disk('public')->delete($pengaduan->foto_bukti);
        }

        $pengaduan->delete();

        return redirect()->route('pengaduan.admin.index')
            ->with('success', 'Pengaduan ' . $pengaduan->kode_tiket . ' berhasil dihapus.');
    }
}
