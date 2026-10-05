<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // $guarded = ['id'] berarti semua kolom boleh diisi massal
    // kecuali 'id' (ini kebalikan dari $fillable)
    protected $guarded = ['id'];

    /**
     * Relasi: Satu Kategori (Category) memiliki banyak Berita (Post)
     */
    public function posts()
    {
        // 'hasMany' artinya 'memiliki banyak'
        return $this->hasMany(Post::class);
    }
}
