<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Melindungi agar 'id' tidak bisa diisi manual
    protected $guarded = ['id'];

    // Cast agar published_at otomatis jadi Carbon object
    protected $casts = [
        'published_at' => 'datetime',
    ];

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
}
