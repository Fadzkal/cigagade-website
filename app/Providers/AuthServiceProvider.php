<?php

namespace App\Providers;

// 1. IMPORT MODEL DAN POLICY KITA
use App\Models\Post;
use App\Policies\PostPolicy;

// 2. IMPORT GATE
use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 3. DAFTARKAN POLICY KITA DI SINI
        Post::class => PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // 4. DAFTARKAN GATE SUPERADMIN KITA DI SINI
        // Gate ini akan 'true' JIKA role user yang login adalah 'superadmin'
        Gate::define('isSuperAdmin', function ($user) {
            return $user->role === 'superadmin';
        });
    }
}
