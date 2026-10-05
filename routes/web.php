<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// IMPORT CONTROLLER
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\MinistryController;
use App\Http\Controllers\Dashboard\PartnerController;
use App\Http\Controllers\Dashboard\GalleryController; // <-- IMPORT BARU
use App\Http\Controllers\Dashboard\HeroSlideController;
use App\Http\Controllers\Dashboard\TinyMCEController;
use App\Http\Controllers\Dashboard\PrestasiController;
use App\Http\Controllers\Dashboard\PengumumanController;
use App\Http\Controllers\Dashboard\MediaController;
use App\Http\Controllers\Dashboard\VideoController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\BengkelIlmuController;
use App\Http\Controllers\Dashboard\InstagramReelController;
use App\Http\Controllers\Dashboard\UmkmController;
use App\Http\Controllers\Dashboard\InfografisController;
use App\Http\Controllers\Dashboard\RunningTextController;
use App\Http\Controllers\Dashboard\LandscapeBannerController;


// ==========================================================
// RUTE PUBLIK
// ==========================================================
Route::get('/', [HomeController::class, 'home'])->name('home');

// Set Language (cookie-based)
Route::get('/set-locale/{lang}', function (string $lang, \Illuminate\Http\Request $request) {
    $locale = in_array($lang, ['id', 'en']) ? $lang : 'id';
    $redirectUrl = $request->query('redirect', url()->previous());
    return redirect($redirectUrl)->withCookie(cookie()->forever('lang', $locale));
})->name('set.locale');

Route::get('/berita', [HomeController::class, 'beritaIndex'])->name('berita.index');
Route::get('/berita/{post:slug}', [HomeController::class, 'show'])->name('berita.show');
// English SEO route — opens with EN locale pre-set
Route::get('/news/{slug_en}', [HomeController::class, 'showByEnSlug'])->name('berita.show.en');
Route::get('/kategori/{category:slug}', [HomeController::class, 'categoryPosts'])->name('kategori.posts');
Route::get('/prestasi-pengumuman', [HomeController::class, 'prestasiPengumuman'])->name('prestasi-pengumuman');
Route::get('/prestasi/{post:slug}', [HomeController::class, 'showPrestasi'])->name('prestasi.detail');
Route::get('/pengumuman/{post:slug}', [HomeController::class, 'showPengumuman'])->name('pengumuman.detail');

Route::get('/video', [HomeController::class, 'videoIndex'])->name('video.index');
Route::get('/video/{video}', [HomeController::class, 'videoDetail'])->name('video.detail');

Route::get('/bengkel-ilmu', [HomeController::class, 'bengkelIlmuIndex'])->name('bengkel-ilmu.list');

// Katalog & Detail UMKM Publik
Route::get('/umkm', [HomeController::class, 'umkmIndex'])->name('umkm.index');
Route::get('/umkm/{slug}', [HomeController::class, 'umkmShow'])->name('umkm.show');

// Halaman Infografis Desa (Demografi, APBDes, Stunting, Bansos, IDM, SDGs)
Route::get('/infografis', [HomeController::class, 'infografisIndex'])->name('infografis.index');
Route::get('/infografis/{tab}', [HomeController::class, 'infografisIndex'])->name('infografis.tab');

// API Statistik Kunjungan
Route::get('/api/visitor-stats', function (\App\Services\VisitorService $service) {
    return response()->json($service->getStats());
})->name('api.visitor-stats');

// ==========================================================
// RUTE DASHBOARD
// ==========================================================
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // RUTE BERITA (Semua user login)
    Route::resource('/dashboard/posts', PostController::class)->names('posts');
    Route::resource('/dashboard/prestasi', PrestasiController::class)->names('prestasi');
    Route::resource('/dashboard/pengumuman', PengumumanController::class)->names('pengumuman');
    Route::resource('/dashboard/umkm', UmkmController::class)->names('umkm.admin');

    // RUTE INFOGRAFIS DESA (Dashboard)
    Route::get('/dashboard/infografis', [InfografisController::class, 'index'])->name('infografis.admin.index');
    Route::post('/dashboard/infografis/bulk', [InfografisController::class, 'updateBulk'])->name('infografis.admin.bulk');
    Route::post('/dashboard/infografis', [InfografisController::class, 'store'])->name('infografis.admin.store');
    Route::put('/dashboard/infografis/{infografi}', [InfografisController::class, 'update'])->name('infografis.admin.update');
    Route::delete('/dashboard/infografis/{infografi}', [InfografisController::class, 'destroy'])->name('infografis.admin.destroy');
    Route::post('/dashboard/infografis/reset', [InfografisController::class, 'reset'])->name('infografis.admin.reset');

    // Rute upload gambar untuk TinyMCE
    Route::post('/tinymce/upload', [TinyMCEController::class, 'upload'])->name('tinymce.upload');


    // --- RUTE KHUSUS SUPERADMIN ---
    Route::middleware('can:isSuperAdmin')->group(function () {

        Route::resource('/dashboard/categories', CategoryController::class)->names('categories');
        Route::get('/dashboard/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/dashboard/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::resource('/dashboard/ministries', MinistryController::class)->names('ministries');
        Route::resource('/dashboard/partners', PartnerController::class)->names('partners');

        // RUTE BARU: GALERI
        Route::resource('/dashboard/galleries', GalleryController::class)->names('galleries');
        
        Route::resource('/dashboard/hero-slides', HeroSlideController::class)->names('hero-slides');
        Route::resource('/dashboard/running-texts', RunningTextController::class)->names('running-texts');
        Route::patch('/dashboard/running-texts/{runningText}/toggle', [RunningTextController::class, 'toggle'])->name('running-texts.toggle');
        Route::resource('/dashboard/landscape-banners', LandscapeBannerController::class)->names('landscape-banners');
        Route::patch('/dashboard/landscape-banners/{landscapeBanner}/toggle', [LandscapeBannerController::class, 'toggle'])->name('landscape-banners.toggle');
        Route::resource('/dashboard/media', MediaController::class)->names('media');
        Route::resource('/dashboard/videos', VideoController::class)->names('videos');

        Route::resource('/dashboard/bengkel-ilmu', BengkelIlmuController::class)->names('bengkel-ilmu');
        Route::resource('/dashboard/instagram-reels', InstagramReelController::class)->names('instagram-reels');

    });
    // --- Akhir Rute SuperAdmin ---

});

require __DIR__.'/auth.php';
