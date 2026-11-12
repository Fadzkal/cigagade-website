<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TiktokVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'tiktok_url',
        'video_id',
        'thumbnail',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    /**
     * Auto-extract Video ID dari URL saat model disimpan.
     */
    protected static function booted(): void
    {
        static::saving(function (TiktokVideo $video) {
            $video->video_id = self::extractVideoId($video->tiktok_url);
        });
    }

    /**
     * Ekstrak TikTok Video ID dari berbagai variasi URL TikTok.
     * Contoh:
     * - https://www.tiktok.com/@kkn_cigagade/video/7382910293847561829
     * - https://www.tiktok.com/embed/v2/7382910293847561829
     * - https://m.tiktok.com/v/7382910293847561829.html
     */
    public static function extractVideoId(?string $url): ?string
    {
        if (!$url) return null;

        // Cari pola angka panjang video ID (biasanya 15-22 digit)
        if (preg_match('/(?:video|v|embed\/v2|embed)\/([0-9]{15,25})/i', $url, $match)) {
            return $match[1];
        }

        // Fallback jika URL mengandung ID video numerik panjang
        if (preg_match('/([0-9]{18,22})/', $url, $match)) {
            return $match[1];
        }

        return null;
    }

    /**
     * URL embed resmi TikTok player.
     */
    public function getEmbedUrlAttribute(): string
    {
        if ($this->video_id) {
            return "https://www.tiktok.com/embed/v2/{$this->video_id}";
        }
        return '';
    }

    /**
     * URL thumbnail (custom upload atau placeholder bertema TikTok).
     */
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return 'https://placehold.co/400x700/010101/00f2fe?text=TikTok+Desa';
    }
}
