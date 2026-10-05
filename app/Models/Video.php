<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'youtube_url',
        'youtube_id',
        'thumbnail',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Auto-extract YouTube video ID dari URL saat model disimpan.
     */
    protected static function booted(): void
    {
        static::saving(function (Video $video) {
            $video->youtube_id = self::extractYoutubeId($video->youtube_url);
        });
    }

    /**
     * Ekstrak YouTube video ID dari berbagai format URL.
     */
    public static function extractYoutubeId(?string $url): ?string
    {
        if (!$url) return null;

        preg_match(
            '/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/'
            . '|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i',
            $url,
            $match
        );

        return $match[1] ?? null;
    }

    /**
     * URL Thumbnail dari YouTube (menggunakan maxresdefault).
     */
    public function getYoutubeThumbnailAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        if ($this->youtube_id) {
            return "https://img.youtube.com/vi/{$this->youtube_id}/maxresdefault.jpg";
        }
        return 'https://placehold.co/1280x720/111928/FFF?text=No+Thumbnail';
    }

    /**
     * URL Embed YouTube.
     */
    public function getEmbedUrlAttribute(): string
    {
        return "https://www.youtube.com/embed/{$this->youtube_id}";
    }
}
