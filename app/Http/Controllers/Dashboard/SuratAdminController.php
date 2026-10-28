<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SuratRequest;
use App\Services\SuratDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SuratAdminController extends Controller
{
    protected SuratDocumentService $docService;

    public function __construct(SuratDocumentService $docService)
    {
        $this->docService = $docService;
    }

    /**
     * Tampilan Utama Manajemen & Statistik Permohonan Surat
     */
    public function index(Request $request)
    {
        // ─── Filter & Search Query ─────────────────────────────────────
        $query = SuratRequest::query();

        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('nama_lengkap', 'like', "%{$s}%")
                  ->orWhere('nik', 'like', "%{$s}%")
                  ->orWhere('tracking_code', 'like', "%{$s}%")
                  ->orWhere('nomor_surat', 'like', "%{$s}%");
            });
        }

        if ($request->filled('jenis') && $request->jenis !== 'all') {
            $query->where('jenis_surat', $request->jenis);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('rw') && $request->rw !== 'all') {
            $query->where('rw', str_pad($request->rw, 3, '0', STR_PAD_LEFT));
        }

        $surats = $query->latest()->paginate(15)->withQueryString();

        // ─── Live Statistics ───────────────────────────────────────────
        $totalCount    = SuratRequest::count();
        $pendingCount  = SuratRequest::where('status', 'pending')->count();
        $diprosesCount = SuratRequest::where('status', 'diproses')->count();
        $selesaiCount  = SuratRequest::where('status', 'selesai')->count();
        $ditolakCount  = SuratRequest::where('status', 'ditolak')->count();

        // Breakdown per Jenis Surat (7 template)
        $jenisCountsRaw = SuratRequest::select('jenis_surat', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_surat')
            ->pluck('total', 'jenis_surat')
            ->toArray();

        $byJenis = [];
        foreach (SuratRequest::JENIS_LIST as $key => $info) {
            $count = $jenisCountsRaw[$key] ?? 0;
            $percentage = $totalCount > 0 ? round(($count / $totalCount) * 100, 1) : 0;
            $byJenis[$key] = array_merge($info, [
                'count' => $count,
                'percentage' => $percentage,
            ]);
        }

        // Breakdown per RW (RW 01 - RW 10)
        $rwCounts = SuratRequest::select('rw', DB::raw('COUNT(*) as total'))
            ->groupBy('rw')
            ->orderBy('rw')
            ->pluck('total', 'rw')
            ->toArray();

        return view('dashboard.surat.index', compact(
            'surats',
            'totalCount',
            'pendingCount',
            'diprosesCount',
            'selesaiCount',
            'ditolakCount',
            'byJenis',
            'rwCounts'
        ));
    }

    /**
     * Form pembuatan surat baru secara langsung oleh admin
     */
    public function create()
    {
        $jenisList = SuratRequest::JENIS_LIST;
        return view('dashboard.surat.create', compact('jenisList'));
    }

    /**
     * Simpan surat baru oleh admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat' => 'required|in:sku,skbb,skd,sktm,skm,skbm,skp',
            'nama_lengkap' => 'required|string|max:150',
            'nik' => 'required|string|min:16|max:20',
            'no_kk' => 'nullable|string|max:20',
            'no_telepon' => 'required|string|max:30',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'warga_negara' => 'required|string|max:50',
            'agama' => 'required|string|max:30',
            'status_perkawinan' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'rt' => 'required|string|max:10',
            'rw' => 'required|string|max:10',
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'nomor_surat' => 'nullable|string|max:100',
            'tanggal_surat' => 'nullable|date',
            'nama_kades' => 'nullable|string|max:100',
            'jabatan_kades' => 'nullable|string|max:100',
            'keperluan' => 'nullable|string|max:500',
            'catatan' => 'nullable|string|max:1000',
            'data_spesifik' => 'nullable|array',
        ]);

        $random = strtoupper(Str::random(4));
        $trackingCode = 'SRT-' . date('Ymd') . '-' . $random;

        $surat = new SuratRequest();
        $surat->fill($validated);
        $surat->tracking_code = $trackingCode;
        $surat->rt = str_pad($validated['rt'], 3, '0', STR_PAD_LEFT);
        $surat->rw = str_pad($validated['rw'], 3, '0', STR_PAD_LEFT);
        $surat->desa = 'Cigagade';
        $surat->kecamatan = 'Balubur Limbangan';
        $surat->kabupaten = 'Garut';
        $surat->nama_lengkap = strtoupper($validated['nama_lengkap']);
        $surat->nama_kades = $validated['nama_kades'] ?: 'DEVI FAHRUROJI, S.Pd.I.';
        $surat->jabatan_kades = $validated['jabatan_kades'] ?: 'Kepala Desa Cigagade';
        $surat->tanggal_surat = $validated['tanggal_surat'] ?: now();
        $surat->data_spesifik = $request->input('data_spesifik', []);

        // Auto assign nomor surat jika kosong
        if (empty($surat->nomor_surat)) {
            $surat->nomor_surat = $surat->formatted_nomor_surat;
        }

        $surat->save();

        return redirect()->route('surat.admin.show', $surat->id)
            ->with('success', 'Surat berhasil dibuat! Nomor Registrasi: ' . $surat->tracking_code);
    }

    /**
     * Tampilan Detail, Verifikasi & Kelola Surat
     */
    public function show($id)
    {
        $surat = SuratRequest::findOrFail($id);
        $jenisList = SuratRequest::JENIS_LIST;
        return view('dashboard.surat.show', compact('surat', 'jenisList'));
    }

    /**
     * Update data surat, nomor surat, tanggal & status
     */
    public function update(Request $request, $id)
    {
        $surat = SuratRequest::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'nomor_surat' => 'nullable|string|max:100',
            'tanggal_surat' => 'nullable|date',
            'nama_kades' => 'nullable|string|max:100',
            'jabatan_kades' => 'nullable|string|max:100',
            'catatan' => 'nullable|string|max:1000',
            'nama_lengkap' => 'sometimes|required|string|max:150',
            'nik' => 'sometimes|required|string|min:16|max:20',
            'no_telepon' => 'sometimes|required|string|max:30',
            'pekerjaan' => 'sometimes|required|string|max:100',
            'alamat' => 'sometimes|required|string|max:255',
            'rt' => 'sometimes|required|string|max:10',
            'rw' => 'sometimes|required|string|max:10',
            'keperluan' => 'nullable|string|max:500',
            'data_spesifik' => 'nullable|array',
        ]);

        $surat->status = $validated['status'];
        $surat->nomor_surat = $validated['nomor_surat'] ?: $surat->formatted_nomor_surat;
        $surat->tanggal_surat = $validated['tanggal_surat'] ?: now();
        $surat->nama_kades = $validated['nama_kades'] ?: 'DEVI FAHRUROJI, S.Pd.I.';
        $surat->jabatan_kades = $validated['jabatan_kades'] ?: 'Kepala Desa Cigagade';
        $surat->catatan = $validated['catatan'] ?? null;

        if ($request->has('nama_lengkap')) {
            $surat->nama_lengkap = strtoupper($request->nama_lengkap);
        }
        if ($request->has('nik')) {
            $surat->nik = $request->nik;
        }
        if ($request->has('no_telepon')) {
            $surat->no_telepon = $request->no_telepon;
        }
        if ($request->has('pekerjaan')) {
            $surat->pekerjaan = $request->pekerjaan;
        }
        if ($request->has('alamat')) {
            $surat->alamat = $request->alamat;
        }
        if ($request->has('rt')) {
            $surat->rt = str_pad($request->rt, 3, '0', STR_PAD_LEFT);
        }
        if ($request->has('rw')) {
            $surat->rw = str_pad($request->rw, 3, '0', STR_PAD_LEFT);
        }
        if ($request->has('keperluan')) {
            $surat->keperluan = $request->keperluan;
        }
        if ($request->has('data_spesifik')) {
            $surat->data_spesifik = array_merge($surat->data_spesifik ?? [], $request->input('data_spesifik', []));
        }

        $surat->save();

        return redirect()->route('surat.admin.show', $surat->id)
            ->with('success', 'Data permohonan surat berhasil diperbarui!');
    }

    /**
     * Hapus permohonan surat
     */
    public function destroy($id)
    {
        $surat = SuratRequest::findOrFail($id);
        $surat->delete();

        return redirect()->route('surat.admin.index')
            ->with('success', 'Permohonan surat berhasil dihapus.');
    }

    /**
     * Tampilan Cetak Browser (Siap Cetak / Save As PDF dari Browser)
     */
    public function print($id)
    {
        $surat = SuratRequest::findOrFail($id);
        return view('surat.print', compact('surat'));
    }

    /**
     * Unduh File PDF Resmi (DomPDF)
     */
    public function downloadPdf($id)
    {
        $surat = SuratRequest::findOrFail($id);
        return $this->docService->generatePdf($surat);
    }

    /**
     * Unduh File Word Resmi .docx (PhpOffice)
     */
    public function downloadWord($id)
    {
        $surat = SuratRequest::findOrFail($id);
        return $this->docService->generateWord($surat);
    }
}
