<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Melindungi agar 'id' tidak bisa diisi manual
    protected $guarded = ['id'];

    // Cast agar published_at & validated_at otomatis jadi Carbon object
    protected $casts = [
        'published_at' => 'datetime',
        'validated_at' => 'datetime',
        'rw' => 'integer',
    ];

    // ─── Status & Moderasi Helpers ───────────────────────────────────────────

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'published' => 'Tayang / Disetujui',
            'pending'   => 'Menunggu Validasi',
            'rejected'  => 'Ditolak / Perlu Revisi',
            default     => ucfirst($this->status ?? 'Tayang'),
        };
    }

    /**
     * Scope untuk berita yang sudah lolos validasi dan tayang ke publik.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope untuk berita yang masih menunggu validasi Super Admin.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk berita yang ditolak.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // ─── RW & Lokasi Helpers ──────────────────────────────────────────────────

    /**
     * Dapatkan label RW jika berita ini khusus untuk RW tertentu (contoh: "RW 01").
     * Mengembalikan null jika berita umum seluruh desa.
     */
    public function getRwLabel(): ?string
    {
        return $this->rw ? 'RW ' . str_pad($this->rw, 2, '0', STR_PAD_LEFT) : null;
    }

    /**
     * Scope untuk memfilter berita berdasarkan RW.
     */
    public function scopeForRw($query, $rw)
    {
        if (!empty($rw)) {
            if ($rw === 'umum') {
                return $query->whereNull('rw');
            }
            return $query->where('rw', (int)$rw);
        }
        return $query;
    }

    // ─── Locale-aware Helpers ─────────────────────────────────────────────────

    /**
     * Kembalikan judul sesuai bahasa aktif.
     * Fallback ke versi Indonesia jika versi EN belum diisi.
     */
    public function getTitle(): string
    {
        if (app()->getLocale() === 'en' && !empty($this->title_en)) {
            return $this->title_en;
        }
        return $this->title;
    }

    /**
     * Kembalikan ringkasan sesuai bahasa aktif.
     */
    public function getExcerpt(): string
    {
        if (app()->getLocale() === 'en' && !empty($this->excerpt_en)) {
            return $this->excerpt_en;
        }
        return $this->excerpt;
    }

    /**
     * Kembalikan konten penuh sesuai bahasa aktif.
     */
    public function getContent(): string
    {
        if (app()->getLocale() === 'en' && !empty($this->content_en)) {
            return $this->content_en;
        }
        return $this->content;
    }

    /**
     * Kembalikan slug sesuai bahasa aktif (untuk URL SEO).
     */
    public function getLocalizedSlug(): string
    {
        if (app()->getLocale() === 'en' && !empty($this->slug_en)) {
            return $this->slug_en;
        }
        return $this->slug;
    }

    /**
     * Kembalikan route untuk halaman detail sesuai bahasa aktif.
     */
    public function getShowRoute(): string
    {
        if (app()->getLocale() === 'en' && !empty($this->slug_en)) {
            return route('berita.show.en', $this->slug_en);
        }
        return route('berita.show', $this->slug);
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    /**
     * Relasi: Satu Berita (Post) dimiliki oleh satu Kategori (Category)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: Satu Berita (Post) dimiliki oleh satu Penulis (User)
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Admin'
        ]);
    }

    /**
     * Relasi: Validator yang menyetujui/meninjau berita ini (Super Admin)
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by')->withDefault([
            'name' => 'Super Admin'
        ]);
    }
}
