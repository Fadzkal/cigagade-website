<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstagramReel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'instagram_url',
        'reel_id',
        'thumbnail',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Auto-extract Reel ID dari URL saat model disimpan.
     */
    protected static function booted(): void
    {
        static::saving(function (InstagramReel $reel) {
            $reel->reel_id = self::extractReelId($reel->instagram_url);
        });
    }

    /**
     * Ekstrak Reel ID dari Instagram URL.
     * Format: https://www.instagram.com/reel/ABCDEFG/
     */
    public static function extractReelId(?string $url): ?string
    {
        if (!$url) return null;
        preg_match('/instagram\.com\/(?:reel|p)\/([A-Za-z0-9_-]+)/i', $url, $match);
        return $match[1] ?? null;
    }

    /**
     * URL embed Instagram Reel.
     */
    public function getEmbedUrlAttribute(): string
    {
        if ($this->reel_id) {
            return "https://www.instagram.com/p/{$this->reel_id}/embed/?autoplay=1";
        }
        return '';
    }

    /**
     * URL thumbnail (custom atau placeholder).
     */
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return 'https://placehold.co/400x700/111928/FFF?text=Reels';
    }
}
