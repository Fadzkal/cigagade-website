<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandscapeBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'url',
        'target',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    /**
     * Scope query untuk banner aktif terurut
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order')->orderByDesc('id');
    }
}
