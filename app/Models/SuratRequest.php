<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SuratRequest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_surat' => 'date',
        'data_spesifik' => 'array',
    ];

    public const JENIS_LIST = [
        'sku' => [
            'code' => '517',
            'title' => 'SURAT KETERANGAN USAHA',
            'short' => 'SKU',
            'icon' => 'fa-store',
            'color' => 'emerald',
            'desc' => 'Surat keterangan kepemilikan usaha aktif di wilayah Desa Cigagade atau domisili usaha pemohon.',
            'format_nomor' => '517/ {NO} /2011-DS/{ROMAN}/{YEAR}',
        ],
        'skbb' => [
            'code' => '331',
            'title' => 'SURAT KETERANGAN BERKELAKUAN BAIK',
            'short' => 'SKBB',
            'icon' => 'fa-shield-halved',
            'color' => 'blue',
            'desc' => 'Surat keterangan kelakuan baik dalam kehidupan bermasyarakat dan tidak terlibat masalah hukum.',
            'format_nomor' => '331/ {NO} /2011-DS/{ROMAN}/{YEAR}',
        ],
        'skd' => [
            'code' => '474.4',
            'title' => 'SURAT KETERANGAN DOMISILI',
            'short' => 'SKD',
            'icon' => 'fa-house-user',
            'color' => 'amber',
            'desc' => 'Surat keterangan bukti tempat tinggal sah pemohon di wilayah Desa Cigagade.',
            'format_nomor' => '474.4/ {NO} /DS-2011/{ROMAN}/{YEAR}',
        ],
        'sktm' => [
            'code' => '460',
            'title' => 'SURAT KETERANGAN TIDAK MAMPU',
            'short' => 'SKTM',
            'icon' => 'fa-hand-holding-heart',
            'color' => 'rose',
            'desc' => 'Surat keterangan status ekonomi keluarga tidak mampu untuk keringanan biaya puskesmas/sekolah.',
            'format_nomor' => '460 / {NO} /DS-2011/{ROMAN}/{YEAR}',
        ],
        'skm' => [
            'code' => '474.2',
            'title' => 'SURAT KETERANGAN MENIKAH',
            'short' => 'SKM',
            'icon' => 'fa-ring',
            'color' => 'pink',
            'desc' => 'Surat keterangan telah menikah secara syah untuk keperluan administrasi dan Isbat Nikah.',
            'format_nomor' => '474.2/ {NO} /2011-DS /{ROMAN}/{YEAR}',
        ],
        'skbm' => [
            'code' => '400',
            'title' => 'SURAT KETERANGAN BELUM MENIKAH',
            'short' => 'SKBM',
            'icon' => 'fa-user-check',
            'color' => 'indigo',
            'desc' => 'Surat keterangan status pemohon belum pernah menikah untuk persyaratan nikah atau kerja.',
            'format_nomor' => '400/ {NO} /2011-DS/{ROMAN}/{YEAR}',
        ],
        'skp' => [
            'code' => '400',
            'title' => 'SURAT KETERANGAN PENGHASILAN',
            'short' => 'SKP',
            'icon' => 'fa-money-bill-wave',
            'color' => 'teal',
            'desc' => 'Surat keterangan rincian rata-rata penghasilan per bulan orang tua/pemohon untuk beasiswa/kuliah.',
            'format_nomor' => '400/ {NO} /2011-DS/{ROMAN}/{YEAR}',
        ],
    ];

    /**
     * Konversi angka bulan ke angka romawi.
     */
    public static function getRomanMonth(int $month): string
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $map[$month] ?? 'X';
    }

    /**
     * Konversi angka ke kalimat terbilang rupiah.
     */
    public static function terbilang(int|float $nilai): string
    {
        $nilai = abs((int)$nilai);
        $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
        $hasil = "";

        if ($nilai < 12) {
            $hasil = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $hasil = self::terbilang($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $hasil = self::terbilang(intval($nilai / 10)) . " puluh" . self::terbilang($nilai % 10);
        } else if ($nilai < 200) {
            $hasil = " seratus" . self::terbilang($nilai - 100);
        } else if ($nilai < 1000) {
            $hasil = self::terbilang(intval($nilai / 100)) . " ratus" . self::terbilang($nilai % 100);
        } else if ($nilai < 2000) {
            $hasil = " seribu" . self::terbilang($nilai - 1000);
        } else if ($nilai < 1000000) {
            $hasil = self::terbilang(intval($nilai / 1000)) . " ribu" . self::terbilang($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $hasil = self::terbilang(intval($nilai / 1000000)) . " juta" . self::terbilang($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $hasil = self::terbilang(intval($nilai / 1000000000)) . " milyar" . self::terbilang(fmod($nilai, 1000000000));
        }

        return ucfirst(trim($hasil));
    }

    /**
     * Generate template default nomor surat jika belum diisi.
     */
    public function getFormattedNomorSuratAttribute(): string
    {
        if (!empty($this->nomor_surat)) {
            return $this->nomor_surat;
        }

        $info = self::JENIS_LIST[$this->jenis_surat] ?? null;
        $format = $info['format_nomor'] ?? '{NO} /2011-DS/{ROMAN}/{YEAR}';

        $date = $this->tanggal_surat ? Carbon::parse($this->tanggal_surat) : ($this->created_at ?? now());
        $noUrut = str_pad($this->id ?? 1, 3, '0', STR_PAD_LEFT);
        $roman = self::getRomanMonth((int)$date->format('n'));
        $year = $date->format('Y');

        return str_replace(['{NO}', '{ROMAN}', '{YEAR}'], [$noUrut, $roman, $year], $format);
    }

    public function getJenisInfoAttribute(): array
    {
        return self::JENIS_LIST[$this->jenis_surat] ?? [
            'code' => '000',
            'title' => 'SURAT KETERANGAN',
            'short' => strtoupper($this->jenis_surat),
            'icon' => 'fa-file-lines',
            'color' => 'slate',
            'desc' => 'Layanan Surat Keterangan Desa Cigagade',
            'format_nomor' => '000/ {NO} /2011-DS/{ROMAN}/{YEAR}',
        ];
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'pending' => [
                'label' => 'Menunggu Verifikasi',
                'bg' => 'bg-amber-100 text-amber-800 border-amber-200 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800',
                'dot' => 'bg-amber-500',
                'icon' => 'fa-clock',
            ],
            'diproses' => [
                'label' => 'Sedang Diproses',
                'bg' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800',
                'dot' => 'bg-blue-500',
                'icon' => 'fa-spinner fa-spin',
            ],
            'selesai' => [
                'label' => 'Selesai / Terbit',
                'bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800',
                'dot' => 'bg-emerald-500',
                'icon' => 'fa-check-circle',
            ],
            'ditolak' => [
                'label' => 'Ditolak / Perlu Revisi',
                'bg' => 'bg-rose-100 text-rose-800 border-rose-200 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-800',
                'dot' => 'bg-rose-500',
                'icon' => 'fa-circle-xmark',
            ],
            default => [
                'label' => ucfirst($this->status),
                'bg' => 'bg-slate-100 text-slate-800 border-slate-200',
                'dot' => 'bg-slate-500',
                'icon' => 'fa-info-circle',
            ]
        };
    }

    /**
     * Dapatkan format tanggal bahasa Indonesia: 26 Oktober 2026
     */
    public static function formatTanggalIndonesia($date): string
    {
        if (!$date) return '';
        $c = Carbon::parse($date)->locale('id');
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $c->format('j') . ' ' . ($bulanIndo[(int)$c->format('n')] ?? '') . ' ' . $c->format('Y');
    }
}
