<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicPengaduanController extends Controller
{
    /**
     * Tampilkan halaman formulir pengaduan & transparansi aduan publik
     */
    public function index(Request $request)
    {
        $kategoriList = Pengaduan::KATEGORI_LIST;

        // Query pengaduan publik yang sudah diverifikasi / ditampilkan
        $query = Pengaduan::where('is_public', true);

        if ($request->filled('kategori') && array_key_exists($request->kategori, $kategoriList)) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status') && in_array($request->status, ['menunggu', 'diproses', 'selesai'])) {
            $query->where('status', $request->status);
        }

        $pengaduans = $query->latest()->paginate(6)->withQueryString();

        // Statistik Pengaduan Publik
        $stats = [
            'total'    => Pengaduan::count(),
            'selesai'  => Pengaduan::where('status', 'selesai')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'menunggu' => Pengaduan::where('status', 'menunggu')->count(),
        ];

        // Jika ada parameter lacak langsung dari URL (misal: /pengaduan?lacak=PGD-...)
        $trackedPengaduan = null;
        $trackedData = null;
        if ($request->filled('lacak')) {
            $trackedPengaduan = Pengaduan::where('kode_tiket', trim($request->lacak))->first();
            if ($trackedPengaduan) {
                $trackedData = $trackedPengaduan->toPublicArray();
            }
        }

        return view('pengaduan.index', compact('kategoriList', 'pengaduans', 'stats', 'trackedPengaduan', 'trackedData'));
    }

    /**
     * Simpan pengaduan baru dari masyarakat
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'nullable|string|max:100',
            'is_anonim'     => 'nullable|boolean',
            'kontak'        => 'nullable|string|max:50',
            'kategori'      => 'required|string|max:100',
            'judul'         => 'required|string|min:5|max:200',
            'isi_pengaduan' => 'required|string|min:15|max:5000',
            'lokasi'        => 'nullable|string|max:255',
            'foto_bukti'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Maks 5MB
        ], [
            'kategori.required'      => 'Silakan pilih kategori pengaduan.',
            'judul.required'         => 'Judul pengaduan wajib diisi.',
            'judul.min'              => 'Judul pengaduan minimal 5 karakter.',
            'isi_pengaduan.required' => 'Isi uraian pengaduan wajib diisi.',
            'isi_pengaduan.min'      => 'Uraian pengaduan minimal 15 karakter agar informasi jelas.',
            'foto_bukti.image'       => 'File bukti harus berupa gambar (JPG, PNG, atau WEBP).',
            'foto_bukti.max'         => 'Ukuran foto bukti maksimal 5 MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')->store('pengaduan', 'public');
        }

        $isAnonim = $request->boolean('is_anonim') || empty(trim($request->nama ?? ''));
        $kodeTiket = Pengaduan::generateKodeTiket();

        $pengaduan = Pengaduan::create([
            'kode_tiket'    => $kodeTiket,
            'nama'          => $isAnonim ? null : trim($request->nama),
            'is_anonim'     => $isAnonim,
            'kontak'        => $request->filled('kontak') ? trim($request->kontak) : null,
            'kategori'      => $request->kategori,
            'judul'         => trim($request->judul),
            'isi_pengaduan' => trim($request->isi_pengaduan),
            'lokasi'        => $request->filled('lokasi') ? trim($request->lokasi) : null,
            'foto_bukti'    => $fotoPath,
            'status'        => 'menunggu',
            'is_public'     => true,
            'ip_address'    => $request->ip(),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success'    => true,
                'message'    => 'Pengaduan Anda berhasil dikirim ke Pemerintah Desa Cigagade!',
                'kode_tiket' => $kodeTiket,
                'data'       => $pengaduan,
            ]);
        }

        return redirect()->route('pengaduan.index', ['lacak' => $kodeTiket])
            ->with('success', 'Pengaduan Anda berhasil dikirim! Simpan Kode Tiket Anda: ' . $kodeTiket);
    }

    /**
     * Lacak status pengaduan via JSON (untuk live tracking input)
     */
    public function track(Request $request)
    {
        $query = trim($request->query('query', ''));
        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan masukkan Kode Tiket Pengaduan.',
            ], 400);
        }

        $pengaduan = Pengaduan::where('kode_tiket', $query)->first();

        if (!$pengaduan) {
            return response()->json([
                'success' => false,
                'message' => 'Pengaduan dengan nomor tiket "' . $query . '" tidak ditemukan. Mohon periksa kembali kodenya.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $pengaduan->toPublicArray(),
        ]);
    }
}
