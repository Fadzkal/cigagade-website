<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeroSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'post_id',
        'youtube_url',
        'title',
        'image',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['embed_url'];

    public function getEmbedUrlAttribute()
    {
        if (!$this->youtube_url) return null;
        
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->youtube_url, $match);
        $videoId = $match[1] ?? null;
        
        if ($videoId) {
            return 'https://www.youtube.com/embed/' . $videoId . '?autoplay=1&mute=1&loop=1&playlist=' . $videoId . '&controls=0&showinfo=0&rel=0';
        }
        
        return null;
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
