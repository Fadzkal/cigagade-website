<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // Kita tambahkan 'role' di sini agar bisa diisi
        'role',
        'rw',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'rw' => 'integer',
        ];
    }

    /**
     * Cek apakah user adalah akun RW.
     */
    public function isRw(): bool
    {
        return $this->role === 'rw' || !is_null($this->rw);
    }

    /**
     * Cek apakah user adalah Super Admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }

    /**
     * Dapatkan label format RW (contoh: "RW 01").
     */
    public function getRwLabel(): ?string
    {
        return $this->rw ? 'RW ' . str_pad($this->rw, 2, '0', STR_PAD_LEFT) : null;
    }

    /**
     * (FUNGSI TAMBAHAN KITA)
     * Relasi: Satu User (Penulis) bisa memiliki banyak Berita (Post)
     */
    public function posts()
    {
        // 'hasMany' artinya 'memiliki banyak'
        return $this->hasMany(Post::class);
    }
}
