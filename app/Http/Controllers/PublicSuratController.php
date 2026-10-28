<?php

namespace App\Http\Controllers;

use App\Models\SuratRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicSuratController extends Controller
{
    /**
     * Halaman Utama Layanan Surat Mandiri Warga Desa Cigagade
     */
    public function index(Request $request)
    {
        $jenisList = SuratRequest::JENIS_LIST;
        $activeTab = $request->query('jenis', 'sku');
        $trackQuery = $request->query('lacak', '');

        $trackedSurat = null;
        if (!empty($trackQuery)) {
            $trackedSurat = SuratRequest::where('tracking_code', $trackQuery)
                ->orWhere('nik', $trackQuery)
                ->latest()
                ->first();
        }

        return view('layanan-surat', compact('jenisList', 'activeTab', 'trackQuery', 'trackedSurat'));
    }

    /**
     * Simpan permohonan surat baru dari warga
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
            'keperluan' => 'nullable|string|max:500',
            'data_spesifik' => 'nullable|array',
        ]);

        // Generate unique tracking code
        $random = strtoupper(Str::random(4));
        $trackingCode = 'SRT-' . date('Ymd') . '-' . $random;

        $surat = SuratRequest::create([
            'tracking_code' => $trackingCode,
            'jenis_surat' => $validated['jenis_surat'],
            'status' => 'pending',
            'tanggal_surat' => now(),
            'nama_kades' => 'DEVI FAHRUROJI, S.Pd.I.',
            'jabatan_kades' => 'Kepala Desa Cigagade',
            'nama_lengkap' => strtoupper($validated['nama_lengkap']),
            'nik' => $validated['nik'],
            'no_kk' => $validated['no_kk'] ?? null,
            'no_telepon' => $validated['no_telepon'],
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'warga_negara' => $validated['warga_negara'] ?? 'Indonesia',
            'agama' => $validated['agama'] ?? 'Islam',
            'status_perkawinan' => $validated['status_perkawinan'],
            'pekerjaan' => $validated['pekerjaan'],
            'alamat' => $validated['alamat'],
            'rt' => str_pad($validated['rt'], 3, '0', STR_PAD_LEFT),
            'rw' => str_pad($validated['rw'], 3, '0', STR_PAD_LEFT),
            'desa' => 'Cigagade',
            'kecamatan' => 'Balubur Limbangan',
            'kabupaten' => 'Garut',
            'keperluan' => $validated['keperluan'] ?? null,
            'data_spesifik' => $request->input('data_spesifik', []),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Permohonan surat berhasil dikirim!',
                'data' => [
                    'tracking_code' => $surat->tracking_code,
                    'jenis_surat' => $surat->jenis_info['title'],
                    'nama_lengkap' => $surat->nama_lengkap,
                    'status' => $surat->status_badge['label'],
                ],
            ]);
        }

        return redirect()->route('layanan-surat.index', ['lacak' => $surat->tracking_code])
            ->with('success', 'Permohonan surat berhasil dikirim! Kode Lacak Anda: ' . $surat->tracking_code);
    }

    /**
     * Cek status permohonan via NIK atau Kode Lacak
     */
    public function track(Request $request)
    {
        $q = trim($request->input('query', ''));
        if (empty($q)) {
            return response()->json(['success' => false, 'message' => 'Masukkan NIK atau Kode Lacak Anda.']);
        }

        $results = SuratRequest::where('tracking_code', $q)
            ->orWhere('nik', $q)
            ->latest()
            ->get();

        if ($results->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data permohonan tidak ditemukan dengan kata kunci: ' . e($q),
            ]);
        }

        return response()->json([
            'success' => true,
            'count' => $results->count(),
            'data' => $results->map(function ($s) {
                return [
                    'tracking_code' => $s->tracking_code,
                    'jenis_title' => $s->jenis_info['title'],
                    'jenis_short' => $s->jenis_info['short'],
                    'nama_lengkap' => $s->nama_lengkap,
                    'nik' => substr($s->nik, 0, 6) . '******' . substr($s->nik, -4),
                    'tanggal_pengajuan' => $s->created_at->format('d M Y, H:i'),
                    'status' => $s->status,
                    'status_label' => $s->status_badge['label'],
                    'status_bg' => $s->status_badge['bg'],
                    'catatan' => $s->catatan,
                    'can_print' => $s->status === 'selesai',
                    'print_url' => route('surat.public.print', $s->tracking_code),
                ];
            }),
        ]);
    }

    /**
     * Cetak Surat untuk Warga jika status sudah SELESAI
     */
    public function printPublic($trackingCode)
    {
        $surat = SuratRequest::where('tracking_code', $trackingCode)->firstOrFail();

        if ($surat->status !== 'selesai') {
            return redirect()->route('layanan-surat.index', ['lacak' => $trackingCode])
                ->with('error', 'Surat sedang diproses atau belum diverifikasi oleh Petugas Kantor Desa Cigagade.');
        }

        return view('surat.print', compact('surat'));
    }
}
