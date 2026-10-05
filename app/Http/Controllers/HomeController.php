<?php

namespace App\Http\Controllers;

// ===================================
// TAMBAHKAN BARIS INI
// ===================================
use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Gallery;
use App\Models\Ministry;
use App\Models\Partner;
use App\Models\HeroSlide;
use App\Models\Video;
use App\Models\InstagramReel;
use App\Models\Umkm;
use App\Models\Infografis;
use App\Models\RunningText;
use App\Models\LandscapeBanner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Depan (Landing Page) Perkenalan.
     */
    public function home()
    {
        // 1. Ambil Settings (Video, Visi, Misi)
        $settings = Setting::pluck('value', 'key');

        // 2. Logika konversi URL YouTube
        $embedUrl = null;
        $videoUrl = $settings['video_url'] ?? null;

        if ($videoUrl) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoUrl, $match);
            $videoId = $match[1] ?? null;
            if ($videoId) {
                // Tambahkan parameter controls=0&showinfo=0&rel=0 agar lebih bersih
                $embedUrl = 'https://www.youtube.com/embed/' . $videoId . '?autoplay=1&mute=1&loop=1&playlist=' . $videoId . '&controls=0&showinfo=0&rel=0';
            }
        }

        // 3. Ambil data untuk Landing Page
        $heroSlides = HeroSlide::with('post')->where('is_active', true)->orderBy('order')->take(5)->get();
        $galleries = Gallery::latest()->get();
        $ministries = Ministry::latest()->get();
        $posts = Post::with('category')
            ->whereHas('category', function($q) {
                $q->whereNotIn('name', ['Prestasi', 'Pengumuman'])
                  ->whereNotIn('slug', [
                      'kegiatan-ukm', 'prestasi-ukm', 'kegiatan-himpunan', 'prestasi-himpunan',
                      'karir-pengembangan-diri', 'riset-inovasi', 'hiburan', 'institusional'
                  ]);
            })
            ->latest()
            ->take(5)
            ->get(); // Ambil 5 berita terbaru
        $partners_kerjasama = Partner::where('type', 'kerjasama')->latest()->get();
        $partners_media = Partner::where('type', 'media_partner')->latest()->get();

        $bengkelSlugs = ['karir-pengembangan-diri', 'riset-inovasi', 'hiburan', 'institusional'];
        $bengkelIlmuPosts = Post::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('slug', $bengkelSlugs))
            ->latest()
            ->take(6)
            ->get();

        $ormawaSlugs = ['kegiatan-ukm', 'prestasi-ukm', 'kegiatan-himpunan', 'prestasi-himpunan'];
        $ormawaPosts = Post::with('category')
            ->whereHas('category', fn($q) => $q->whereIn('slug', $ormawaSlugs))
            ->latest()
            ->take(5)
            ->get();

        $prestasiPosts = Post::with('category')
            ->whereHas('category', fn($q) => $q->where('name', 'Prestasi'))
            ->latest()
            ->take(6)
            ->get();

        $pengumumanPosts = Post::with('category')
            ->whereHas('category', fn($q) => $q->where('name', 'Pengumuman'))
            ->latest()
            ->take(6)
            ->get();

        $magazinePosts = Post::with('category')
            ->whereHas('category', function($q) {
                $q->whereNotIn('name', ['Prestasi', 'Pengumuman'])
                  ->whereNotIn('slug', [
                      'kegiatan-ukm', 'prestasi-ukm', 'kegiatan-himpunan', 'prestasi-himpunan',
                      'karir-pengembangan-diri', 'riset-inovasi', 'hiburan', 'institusional'
                  ]);
            })
            ->orderByDesc('views')
            ->take(9)
            ->get();

        $instagramReels = InstagramReel::where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('home', [
            'settings'          => $settings,
            'embedUrl'          => $embedUrl,
            'heroSlides'        => $heroSlides,
            'galleries'         => $galleries,
            'ministries'        => $ministries,
            'posts'             => $posts,
            'partners_kerjasama' => $partners_kerjasama,
            'partners_media'    => $partners_media,
            'bengkelIlmuPosts'  => $bengkelIlmuPosts,
            'ormawaPosts'       => $ormawaPosts,
            'prestasiPosts'     => $prestasiPosts,
            'pengumumanPosts'   => $pengumumanPosts,
            'magazinePosts'     => $magazinePosts,
            'instagramReels'    => $instagramReels,
            'umkmProducts'      => Umkm::active()->latest()->take(6)->get(),
            'runningTexts'      => RunningText::where('is_active', true)->orderBy('order')->get(),
            'landscapeBanners'  => LandscapeBanner::active()->get(),
        ]);
    }

    /**
     * Menampilkan Halaman Daftar Semua Berita dengan Filter.
     */
    public function beritaIndex(Request $request)
    {
        $query = Post::with(['category', 'user'])
            ->whereHas('category', function($q) {
                $q->whereNotIn('name', ['Prestasi', 'Pengumuman'])
                  ->whereNotIn('slug', [
                      'kegiatan-ukm', 'prestasi-ukm', 'kegiatan-himpunan', 'prestasi-himpunan',
                      'karir-pengembangan-diri', 'riset-inovasi', 'hiburan', 'institusional'
                  ]);
            })
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $posts = $query->paginate(9)->withQueryString();

        return view('berita-index', [
            'posts' => $posts,
            'search' => $request->search,
            'month' => $request->month,
            'year' => $request->year
        ]);
    }

    /**
     * Menampilkan Halaman Prestasi dan Pengumuman.
     */
    public function prestasiPengumuman()
    {
        $prestasiCategory = Category::where('name', 'Prestasi')->first();
        $pengumumanCategory = Category::where('name', 'Pengumuman')->first();

        $prestasiPosts = $prestasiCategory ? $prestasiCategory->posts()->with('category')->latest()->get() : collect();
        $pengumumanPosts = $pengumumanCategory ? $pengumumanCategory->posts()->with('category')->latest()->get() : collect();

        return view('prestasi-pengumuman', compact('prestasiPosts', 'pengumumanPosts'));
    }

    /**
     * Menampilkan Halaman Detail Berita (Satu Berita).
     */
    public function show(Post $post)
    {
        // Increment view counter
        $post->increment('views');

        $relatedPosts = Post::with('category')
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(6)
            ->get();

        return view('post-detail', [
            'post' => $post,
            'relatedPosts' => $relatedPosts
        ]);
    }

    /**
     * Menampilkan Halaman Detail Berita via slug_en (URL SEO Bahasa Inggris).
     */
    public function showByEnSlug(string $slug_en)
    {
        $post = Post::where('slug_en', $slug_en)->firstOrFail();

        // Force EN locale since user reached this via /news/ URL
        app()->setLocale('en');

        $post->increment('views');

        $relatedPosts = Post::with('category')
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(6)
            ->get();

        return view('post-detail', [
            'post' => $post,
            'relatedPosts' => $relatedPosts
        ]);
    }

    public function showPrestasi(Post $post)
    {
        // Increment view counter
        $post->increment('views');

        $relatedPosts = Post::with('category')
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(6)
            ->get();

        return view('prestasi-detail', [
            'post' => $post,
            'relatedPosts' => $relatedPosts
        ]);
    }

    public function showPengumuman(Post $post)
    {
        // Increment view counter
        $post->increment('views');

        $relatedPosts = Post::with('category')
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(6)
            ->get();

        return view('pengumuman-detail', [
            'post' => $post,
            'relatedPosts' => $relatedPosts
        ]);
    }

    /**
     * Menampilkan Halaman Berita berdasarkan Kategori.
     */
    public function categoryPosts(Category $category)
    {
        $posts = $category->posts()
                        ->with(['category', 'user'])
                        ->latest()
                        ->paginate(9);

        return view('category-posts', [
            'posts' => $posts,
            'category' => $category
        ]);
    }

    /**
     * Menampilkan Halaman Daftar Semua Video YouTube.
     */
    public function videoIndex()
    {
        $videos = Video::latest('published_at')->paginate(12);
        $featuredVideo = Video::where('is_featured', true)->latest('published_at')->first();

        return view('video-index', compact('videos', 'featuredVideo'));
    }

    /**
     * Menampilkan Halaman Detail Video YouTube.
     */
    public function videoDetail(Video $video)
    {
        $relatedVideos = Video::where('id', '!=', $video->id)
            ->latest('published_at')
            ->take(6)
            ->get();

        return view('video-detail', compact('video', 'relatedVideos'));
    }
    /**
     * Menampilkan Halaman Daftar Artikel Bengkel Ilmu (Public).
     */
    public function bengkelIlmuIndex(Request $request)
    {
        $bengkelSlugs = ['karir-pengembangan-diri', 'riset-inovasi', 'hiburan', 'institusional'];

        $bengkelCategories = Category::whereIn('slug', $bengkelSlugs)->get();

        $activeCategory = null;
        if ($request->filled('kategori')) {
            $activeCategory = Category::where('slug', $request->kategori)->first();
        }

        $query = Post::with(['category', 'user'])
            ->whereHas('category', fn($q) => $q->whereIn('slug', $bengkelSlugs))
            ->latest();

        if ($activeCategory) {
            $query->where('category_id', $activeCategory->id);
        }

        $posts = $query->paginate(9);

        return view('bengkel-ilmu-index', compact('posts', 'bengkelCategories', 'activeCategory'));
    }

    /**
     * Menampilkan Katalog Publik Produk UMKM Desa Cigagade.
     */
    public function umkmIndex(Request $request)
    {
        $categories = [
            'Semua Kategori',
            'Makanan & Minuman',
            'Pertanian & Perkebunan',
            'Kerajinan Tangan',
            'Fashion & Busana',
            'Peternakan & Perikanan',
            'Jasa & Lainnya',
        ];

        $query = Umkm::active();

        $category = $request->input('category', $request->input('kategori'));
        if (!empty($category) && $category !== 'Semua Kategori') {
            $query->where('category', $category);
        }

        $search = $request->input('search', $request->input('cari'));
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('seller_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $umkms = $query->latest()->paginate(12)->withQueryString();
        $products = $umkms;
        $totalAll = Umkm::active()->count();

        return view('umkm-index', compact('umkms', 'products', 'categories', 'totalAll'));
    }

    /**
     * Menampilkan Halaman Detail Produk UMKM Desa Cigagade.
     */
    public function umkmShow(string $slug)
    {
        $umkm = Umkm::where('slug', $slug)->firstOrFail();
        $umkm->increment('views');

        $related = Umkm::active()
            ->where('id', '!=', $umkm->id)
            ->where('category', $umkm->category)
            ->take(4)
            ->get();

        if ($related->isEmpty()) {
            $related = Umkm::active()
                ->where('id', '!=', $umkm->id)
                ->take(4)
                ->get();
        }

        $product = $umkm;
        $relatedProducts = $related;

        return view('umkm-detail', compact('umkm', 'related', 'product', 'relatedProducts'));
    }

    /**
     * Menampilkan Halaman Infografis Desa (Demografi, APBDes, Stunting, Bansos, IDM, SDGs).
     */
    public function infografisIndex(Request $request, $tab = 'penduduk')
    {
        $allowedTabs = [
            'penduduk' => [
                'title' => 'DEMOGRAFI PENDUDUK',
                'subtitle' => 'Memberikan informasi lengkap mengenai karakteristik demografi penduduk suatu wilayah. Mulai dari jumlah penduduk, usia, jenis kelamin, tingkat pendidikan, pekerjaan, agama, dan aspek penting lainnya yang menggambarkan komposisi populasi secara rinci.',
                'icon' => 'fas fa-users',
                'badge' => 'Statistik Kependudukan',
            ],
            'apbdes' => [
                'title' => 'APBDES (KEUANGAN DESA)',
                'subtitle' => 'Transparansi tata kelola Anggaran Pendapatan dan Belanja Desa Cigagade. Memastikan akuntabilitas pemanfaatan dana desa untuk pembangunan dan kemakmuran warga.',
                'icon' => 'fas fa-hand-holding-dollar',
                'badge' => 'Transparansi Anggaran',
            ],
            'stunting' => [
                'title' => 'STUNTING & KESEHATAN',
                'subtitle' => 'Pemantauan tumbuh kembang balita, deteksi dini gizi buruk, dan intervensi pemberian makanan tambahan (PMT) rutin di seluruh posyandu Desa Cigagade.',
                'icon' => 'fas fa-heart-pulse',
                'badge' => 'Kesehatan Masyarakat',
            ],
            'bansos' => [
                'title' => 'BANTUAN SOSIAL (BANSOS)',
                'subtitle' => 'Data akurat penyaluran bantuan sosial pemerintah seperti PKH, BPNT/Sembako, BLT Dana Desa, dan Cadangan Pangan Pemerintah bagi keluarga penerima manfaat.',
                'icon' => 'fas fa-box-open',
                'badge' => 'Jaring Pengaman Sosial',
            ],
            'idm' => [
                'title' => 'INDEKS DESA MEMBANGUN (IDM)',
                'subtitle' => 'Indeks komposit yang mengukur status kemandirian dan perkembangan desa melalui 3 dimensi utama: Indeks Ketahanan Sosial, Ekonomi, dan Lingkungan.',
                'icon' => 'fas fa-crown',
                'badge' => 'Status Kemajuan Desa',
            ],
            'sdgs' => [
                'title' => 'SDGs DESA CIGAGADE',
                'subtitle' => 'Pencapaian 18 Tujuan Pembangunan Berkelanjutan (Sustainable Development Goals) Desa Cigagade untuk mewujudkan desa yang mandiri, berkeadilan, dan berkelanjutan.',
                'icon' => 'fas fa-list-ol',
                'badge' => 'Pembangunan Berkelanjutan',
            ],
        ];

        $tab = strtolower($tab);
        if (!array_key_exists($tab, $allowedTabs)) {
            $tab = 'penduduk';
        }

        $items = Infografis::where('category', $tab)->orderBy('order_index')->get();
        $sections = $items->groupBy('section');
        $tabMeta = $allowedTabs[$tab];

        // Specific dataset parsing for charts
        $chartData = [];
        if ($tab === 'penduduk') {
            $piramida = $sections->get('piramida', collect());
            $chartData['piramida_labels'] = $piramida->pluck('title')->toArray();
            $chartData['piramida_laki'] = $piramida->pluck('value')->map(fn($v) => (int)$v)->toArray();
            $chartData['piramida_perempuan'] = $piramida->pluck('value_alt')->map(fn($v) => (int)$v)->toArray();

            $pendidikan = $sections->get('pendidikan', collect());
            $chartData['pendidikan_labels'] = $pendidikan->pluck('title')->toArray();
            $chartData['pendidikan_values'] = $pendidikan->pluck('value')->map(fn($v) => (int)$v)->toArray();

            $pekerjaan = $sections->get('pekerjaan', collect());
            $chartData['pekerjaan_labels'] = $pekerjaan->pluck('title')->toArray();
            $chartData['pekerjaan_values'] = $pekerjaan->pluck('value')->map(fn($v) => (int)$v)->toArray();
        } elseif ($tab === 'apbdes') {
            $rincian = $sections->get('rincian', collect());
            $chartData['belanja_labels'] = $rincian->pluck('title')->toArray();
            $chartData['belanja_values'] = $rincian->pluck('value')->map(fn($v) => (float)$v)->toArray();
        }

        return view('infografis', compact('tab', 'allowedTabs', 'tabMeta', 'sections', 'items', 'chartData'));
    }
}
