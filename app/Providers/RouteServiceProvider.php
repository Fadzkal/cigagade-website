<?php

namespace App\Providers;

// (Kita hapus beberapa 'use' yang tidak terpakai untuk API)
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard'; // Kita arahkan ke dashboard setelah login

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // (Blok RateLimiter untuk 'api' kita hapus karena tidak terpakai)

        $this->routes(function () {

            // (Blok 'api' kita hapus seluruhnya karena file 'routes/api.php' tidak ada)

            // Kita HANYA memuat file routes/web.php
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
