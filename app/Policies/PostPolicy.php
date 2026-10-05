<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Semua user yang login boleh lihat halaman daftar berita
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        // Semua user yang login boleh lihat detail berita
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Semua user yang login boleh membuat berita
        return true;
    }

    /**
     * (LOGIKA PENTING)
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        // User boleh update JIKA dia adalah penulis post ($user->id === $post->user_id)
        // ATAU JIKA dia adalah 'superadmin'
        return $user->id === $post->user_id || $user->role === 'superadmin';
    }

    /**
     * (LOGIKA PENTING)
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        // User boleh hapus JIKA dia adalah penulis post ($user->id === $post->user_id)
        // ATAU JIKA dia adalah 'superadmin'
        return $user->id === $post->user_id || $user->role === 'superadmin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        // (Boleh diabaikan dulu)
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        // (Boleh diabaikan dulu)
        return false;
    }
}
