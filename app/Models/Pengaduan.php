<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduans';

    protected $fillable = [
        'kode_tiket',
        'nama',
        'is_anonim',
        'kontak',
        'kategori',
        'judul',
        'isi_pengaduan',
        'lokasi',
        'foto_bukti',
        'status',
        'tanggapan',
        'tanggapan_at',
        'tanggapan_oleh',
        'is_public',
        'ip_address',
    ];

    protected $casts = [
        'is_anonim'    => 'boolean',
        'is_public'    => 'boolean',
        'tanggapan_at' => 'datetime',
    ];

    /**
     * Kategori pengaduan resmi
     */
    public const KATEGORI_LIST = [
        'Infrastruktur & Jalan'   => ['icon' => 'fa-road', 'color' => 'blue', 'desc' => 'Jalan rusak, jembatan, irigasi, penerangan jalan'],
        'Kebersihan & Lingkungan' => ['icon' => 'fa-trash-can', 'color' => 'emerald', 'desc' => 'Sampah liar, selokan mampet, polusi lingkungan'],
        'Pelayanan Desa'          => ['icon' => 'fa-id-card', 'color' => 'indigo', 'desc' => 'Administrasi kantor desa, pembuatan surat, jam pelayanan'],
        'Ketertiban & Keamanan'   => ['icon' => 'fa-shield-halved', 'color' => 'amber', 'desc' => 'Gangguan ketertiban umum, ronda malam, keamanan'],
        'Bantuan Sosial'          => ['icon' => 'fa-hand-holding-heart', 'color' => 'rose', 'desc' => 'Penyaluran bansos, BLT, PKH, data kemiskinan'],
        'Lainnya'                 => ['icon' => 'fa-comment-dots', 'color' => 'slate', 'desc' => 'Aspirasi, masukan, dan pengaduan umum warga'],
    ];

    /**
     * Generate Kode Tiket unik: PGD-YYYYMMDD-XXXX
     */
    public static function generateKodeTiket(): string
    {
        $prefix = 'PGD-' . date('Ymd') . '-';
        do {
            $random = strtoupper(Str::random(4));
            $code = $prefix . $random;
        } while (static::where('kode_tiket', $code)->exists());

        return $code;
    }

    /**
     * Nama pelapor yang ditampilkan ke publik
     */
    public function getNamaTampilAttribute(): string
    {
        if ($this->is_anonim || empty(trim($this->nama ?? ''))) {
            return 'Warga Anonim';
        }
        return $this->nama;
    }

    /**
     * Label Status Bahasa Indonesia
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu Verifikasi',
            'diproses' => 'Sedang Diproses',
            'selesai'  => 'Selesai Ditindaklanjuti',
            'ditolak'  => 'Ditolak / Tidak Valid',
            default    => ucfirst($this->status),
        };
    }

    /**
     * Warna / Kelas Tailwind untuk Status
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'menunggu' => [
                'bg'    => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
                'dot'   => 'bg-amber-500',
                'icon'  => 'fa-clock',
            ],
            'diproses' => [
                'bg'    => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
                'dot'   => 'bg-blue-500',
                'icon'  => 'fa-spinner fa-spin',
            ],
            'selesai' => [
                'bg'    => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800',
                'dot'   => 'bg-emerald-500',
                'icon'  => 'fa-circle-check',
            ],
            'ditolak' => [
                'bg'    => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800',
                'dot'   => 'bg-rose-500',
                'icon'  => 'fa-circle-xmark',
            ],
            default => [
                'bg'    => 'bg-gray-50 text-gray-700 border-gray-200',
                'dot'   => 'bg-gray-400',
                'icon'  => 'fa-circle-info',
            ],
        };
    }

    /**
     * URL Foto Bukti jika ada
     */
    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto_bukti) {
            return null;
        }
        return asset('storage/' . $this->foto_bukti);
    }

    /**
     * Link WhatsApp pelapor (jika nomor hp terisi)
     */
    public function getWhatsappLinkAttribute(): ?string
    {
        if (!$this->kontak) {
            return null;
        }

        $clean = preg_replace('/[^0-9]/', '', $this->kontak);
        if (str_starts_with($clean, '0')) {
            $clean = '62' . substr($clean, 1);
        } elseif (!str_starts_with($clean, '62')) {
            $clean = '62' . $clean;
        }

        $pesan = "Halo Sdr/i " . ($this->nama ?: 'Warga Desa Cigagade') . ", menindaklanjuti pengaduan Anda di Portal Desa Cigagade terkait: *" . $this->judul . "* (Tiket: *" . $this->kode_tiket . "*).";
        return "https://wa.me/" . $clean . "?text=" . urlencode($pesan);
    }

    /**
     * Konversi data publik pengaduan untuk JSON / tracking view
     */
    public function toPublicArray(): array
    {
        return [
            'kode_tiket'     => $this->kode_tiket,
            'nama_tampil'    => $this->nama_tampil,
            'kategori'       => $this->kategori,
            'judul'          => $this->judul,
            'isi_pengaduan'  => $this->isi_pengaduan,
            'lokasi'         => $this->lokasi,
            'foto_url'       => $this->foto_url,
            'status'         => $this->status,
            'status_label'   => $this->status_label,
            'status_badge'   => $this->status_badge,
            'tanggapan'      => $this->tanggapan,
            'tanggapan_at'   => $this->tanggapan_at ? $this->tanggapan_at->translatedFormat('d F Y, H:i') : null,
            'tanggapan_oleh' => $this->tanggapan_oleh,
            'created_at'     => $this->created_at ? $this->created_at->translatedFormat('d F Y, H:i') : null,
        ];
    }
}
