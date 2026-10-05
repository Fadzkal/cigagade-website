<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infografis extends Model
{
    use HasFactory;

    protected $table = 'infografis';

    protected $fillable = [
        'category',
        'section',
        'key',
        'title',
        'value',
        'value_alt',
        'unit',
        'icon',
        'color',
        'order_index',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'order_index' => 'integer',
    ];

    /**
     * Scope query by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope query by section
     */
    public function scopeBySection($query, string $section)
    {
        return $query->where('section', $section);
    }

    /**
     * Helper to get a single value quickly
     */
    public static function getVal(string $category, string $key, $default = null)
    {
        $item = static::where('category', $category)->where('key', $key)->first();
        return $item ? $item->value : $default;
    }
}
