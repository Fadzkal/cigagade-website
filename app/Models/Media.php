<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'image',
        'url',
        'platform',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * Ambil thumbnail URL untuk preview:
     * - Jika tipe 'image', kembalikan path storage
     * - Jika tipe 'social', kembalikan null (gunakan icon)
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Cek apakah tipe ini social media
     */
    public function getIsSocialAttribute(): bool
    {
        return $this->type === 'social';
    }
}
