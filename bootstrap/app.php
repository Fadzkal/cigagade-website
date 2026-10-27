<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Di luar grup 'web' agar polling health tidak membuat sesi/visitor log.
            Route::get('/api/health', function () {
                try {
                    DB::select('select 1');
                } catch (\Throwable $e) {
                    report($e);

                    return response()->json(['status' => 'error', 'db' => 'down'], 503);
                }

                return response()->json(['status' => 'ok', 'db' => 'up'])
                    ->header('Cache-Control', 'no-store');
            })->name('health');
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Di server, HTTPS diterminasi Cloudflare Tunnel; percayai X-Forwarded-*
        // agar URL/aset yang dibangkitkan memakai https (cegah mixed content).
        $middleware->trustProxies(at: '*');

        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\TrackVisitor::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
