<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Setting; // <-- IMPORT SETTING

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            // Ambil semua settings sekali saja
            $settings = Setting::pluck('value', 'key');

            // Bagikan Categories ke semua view (hanya untuk dropdown News di navbar)
            // Exclude kategori khusus Ormawa, Bengkel Ilmu & Prestasi/Pengumuman yang punya section tersendiri
            $ormawaSlugs = ['kegiatan-ukm', 'prestasi-ukm', 'kegiatan-himpunan', 'prestasi-himpunan'];
            $bengkelSlugs = ['karir-pengembangan-diri', 'riset-inovasi', 'hiburan', 'institusional'];
            $excludeNames = ['Prestasi', 'Pengumuman'];
            View::share('categories', Category::whereNotIn('slug', array_merge($ormawaSlugs, $bengkelSlugs))
                                                ->whereNotIn('name', $excludeNames)
                                                ->get());

            // Bagikan path logo (jika ada) ke semua view
            View::share('logoPath', $settings['logo_path'] ?? null);

            // Bagikan visitor statistics ke public-layout
            View::composer('components.public-layout', function ($view) {
                try {
                    $visitorService = app(\App\Services\VisitorService::class);
                    $view->with('visitorStats', $visitorService->getStats());
                } catch (\Throwable $e) {
                    $view->with('visitorStats', [
                        'today' => 0,
                        'yesterday' => 0,
                        'this_week' => 0,
                        'last_week' => 0,
                        'this_month' => 0,
                        'last_month' => 0,
                        'total' => 0,
                    ]);
                }
            });
        } catch (\Exception $e) {
            // Mengabaikan error jika tabel belum dibuat di database, contohnya saat menjalankan php artisan migrate
        }
    }
}
