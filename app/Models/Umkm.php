<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkms';

    protected $fillable = [
        'name',
        'slug',
        'seller_name',
        'phone',
        'category',
        'price',
        'unit',
        'description',
        'address',
        'image',
        'is_active',
        'views',
    ];

    protected $casts = [
        'price' => 'integer',
        'is_active' => 'boolean',
        'views' => 'integer',
    ];

    /**
     * Boot function to generate slug automatically.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($umkm) {
            if (empty($umkm->slug)) {
                $slug = Str::slug($umkm->name);
                $originalSlug = $slug;
                $count = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$originalSlug}-" . $count++;
                }
                $umkm->slug = $slug;
            }
        });

        static::updating(function ($umkm) {
            if ($umkm->isDirty('name') && empty($umkm->slug)) {
                $slug = Str::slug($umkm->name);
                $originalSlug = $slug;
                $count = 1;
                while (static::where('slug', $slug)->where('id', '!=', $umkm->id)->exists()) {
                    $slug = "{$originalSlug}-" . $count++;
                }
                $umkm->slug = $slug;
            }
        });
    }

    /**
     * Scope for active products only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Formatted price string.
     */
    public function getFormattedPriceAttribute(): string
    {
        $formatted = 'Rp ' . number_format($this->price, 0, ',', '.');
        if (!empty($this->unit)) {
            $formatted .= ' / ' . trim($this->unit);
        }
        return $formatted;
    }

    /**
     * Direct WhatsApp URL with customized order greeting.
     */
    public function getWhatsappUrlAttribute(): string
    {
        $rawPhone = preg_replace('/[^0-9]/', '', $this->phone ?? '');
        if (str_starts_with($rawPhone, '0')) {
            $phone = '62' . substr($rawPhone, 1);
        } elseif (str_starts_with($rawPhone, '62')) {
            $phone = $rawPhone;
        } else {
            $phone = '62' . $rawPhone;
        }

        $seller = $this->seller_name ?: 'Bapak/Ibu Penjual';
        $product = $this->name;
        $price = 'Rp ' . number_format($this->price, 0, ',', '.');

        $message = "Halo {$seller}, saya melihat produk \"{$product}\" ({$price}) di Portal Resmi Desa Cigagade.\n\nApakah produk ini masih tersedia dan bisa saya pesan? Terima kasih.";

        return "https://wa.me/{$phone}?text=" . rawurlencode($message);
    }

    /**
     * Get image URL with fallback.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-umkm.png');
    }
}
