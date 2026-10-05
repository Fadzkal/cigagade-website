<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Website resmi Desa Cigagade, Kecamatan Balubur Limbangan, Kabupaten Garut. Pusat informasi pembangunan, pelayanan warga, dan potensi desa.">
    <meta name="keywords" content="Desa Cigagade, Balubur Limbangan, Garut, Jawa Barat, Portal Desa, Pelayanan Desa, Wisata Sunan Cibalampu, Sungai Cipancar">
    <meta name="author" content="Pemerintah Desa Cigagade">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ?? 'Portal Resmi Desa Cigagade - Balubur Limbangan, Garut' }}">
    <meta property="og:description" content="Website resmi Pemerintah Desa Cigagade, Balubur Limbangan, Kabupaten Garut">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? 'Portal Resmi Desa Cigagade - Balubur Limbangan, Garut' }}">

    <title>{{ $title ?? 'Portal Resmi Desa Cigagade - Balubur Limbangan, Garut' }}</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23059669'><path d='M12 2L2 9.5V11H4V20H9V14H15V20H20V11H22V9.5L12 2Z'/></svg>">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Enhanced Theme Variables */
        :root {
            --primary-light: #059669;
            --primary-dark: #10b981;
            --bg-light: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
            --bg-dark: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #1e293b 100%);
            --text-light: #1e293b;
            --text-dark: #f1f5f9;
            --card-light: #ffffff;
            --card-dark: #1e293b;
            --border-light: #e2e8f0;
            --border-dark: #334155;
            --shadow-light: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-dark: 0 4px 20px rgba(0, 0, 0, 0.3);
            --transition-theme: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .dark .nav-shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.4);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #064e3b 0%, #059669 50%, #10b981 100%);
        }

        .dark .gradient-bg {
            background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #059669 100%);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
        }

        html {
            scroll-behavior: smooth;
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .dark ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        ::-webkit-scrollbar-thumb {
            background: #059669;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #047857;
        }

        /* Enhanced transitions for theme switching */
        * {
            transition: background-color 0.5s ease, color 0.5s ease, border-color 0.5s ease, box-shadow 0.5s ease;
        }

        /* Theme toggle animation */
        .theme-toggle {
            position: relative;
            overflow: hidden;
        }

        .theme-toggle::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #059669, #10b981);
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 50%;
        }

        .theme-toggle:hover::before {
            opacity: 0.1;
        }

        /* Language toggle animation */
        .lang-toggle {
            position: relative;
            overflow: hidden;
        }

        .lang-toggle::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #10b981, #34d399);
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 50%;
        }

        .lang-toggle:hover::before {
            opacity: 0.1;
        }

        /* Enhanced iOS-style navigation */
        .nav-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .nav-link:active {
            transform: scale(0.95);
        }

        /* Glassmorphism utilities */
        .glass {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        
        .dark .glass {
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .nav-pill {
            border-radius: 9999px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            font-size: 0.95rem;
        }

        /* Enhanced button styles */
        .btn-primary {
            background-color: #059669;
            border-radius: 9999px;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary:hover {
            background-color: #047857;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(5, 150, 105, 0.4);
        }
        
        .btn-primary:active {
            transform: scale(0.96);
        }

        .dark .btn-primary {
            background-color: #10b981;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-secondary {
            background: rgba(5, 150, 105, 0.1);
            border-radius: 9999px;
            color: #059669;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
        }

        .btn-secondary:hover {
            background: rgba(5, 150, 105, 0.18);
            transform: translateY(-2px);
        }
        
        .btn-secondary:active {
            transform: scale(0.96);
        }

        .dark .btn-secondary {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }

        .dark .btn-secondary:hover {
            background: rgba(16, 185, 129, 0.25);
        }

        /* Enhanced card styles */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-light);
            transition: all 0.3s ease;
            border: 1px solid var(--border-light);
        }

        .dark .card {
            background: var(--card-dark);
            box-shadow: var(--shadow-dark);
            border: 1px solid var(--border-dark);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .dark .card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        /* Enhanced text contrast */
        .text-primary {
            color: var(--text-light);
        }

        .dark .text-primary {
            color: var(--text-dark);
        }

        .text-secondary {
            color: #64748b;
        }

        .dark .text-secondary {
            color: #94a3b8;
        }



        /* Enhanced footer */
        .footer-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .footer-link::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: white;
            transition: width 0.3s ease;
        }

        .footer-link:hover::before {
            width: 100%;
        }

        /* Loading animation for theme transition */
        .theme-transition {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-light);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.5s ease;
        }

        .dark .theme-transition {
            background: var(--bg-dark);
        }

        .theme-transition.active {
            opacity: 1;
        }

        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3b82f6;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .dark .loader {
            border: 5px solid #334155;
            border-top: 5px solid #60a5fa;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Custom navbar height utility */
        .h-14 { height: 3.5rem; }
        @media (min-width: 1024px) {
            .lg\:h-18 { height: 4.5rem; }
        }

        /* Hamburger bar smooth animation */
        .hamburger-bar {
            display: block;
            width: 1.25rem;
            height: 2px;
            background: currentColor;
            border-radius: 2px;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        /* Mobile menu scrollbar */
        .max-h-\[70vh\]::-webkit-scrollbar {
            width: 4px;
        }
        .max-h-\[70vh\]::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.5);
            border-radius: 4px;
        }
        .dark .max-h-\[70vh\]::-webkit-scrollbar-thumb {
            background: rgba(71, 85, 105, 0.6);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-blue-50 to-slate-50 dark:from-gray-900 dark:via-slate-900 dark:to-gray-900"
      x-data="{
        darkMode: localStorage.getItem('theme') === 'dark',
        currentLang: localStorage.getItem('language') || '{{ app()->getLocale() }}',
        isTransitioning: false,
        suratModalOpen: false,
        suratForm: { jenis: 'Surat Keterangan Usaha (SKU)', nama: '', nik: '', no_kk: '', alamat: '', keperluan: '' },
        kirimSuratWa() {
            if (!this.suratForm.nama || !this.suratForm.nik) {
                alert('Mohon masukkan Nama Lengkap dan NIK Anda.');
                return;
            }
            const pesan = `*PERMOHONAN LAYANAN SURAT DESA CIGAGADE*\n\n` +
                `• *Jenis Surat:* ${this.suratForm.jenis}\n` +
                `• *Nama Lengkap:* ${this.suratForm.nama}\n` +
                `• *NIK:* ${this.suratForm.nik}\n` +
                `• *No. KK:* ${this.suratForm.no_kk || '-'}\n` +
                `• *Alamat / Dusun:* ${this.suratForm.alamat || '-'}\n` +
                `• *Keperluan:* ${this.suratForm.keperluan || '-'}\n\n` +
                `_Mohon dapat diproses oleh petugas pelayanan Kantor Desa Cigagade. Terima kasih._`;
            const waUrl = 'https://wa.me/6281234567890?text=' + encodeURIComponent(pesan);
            window.open(waUrl, '_blank');
            this.suratModalOpen = false;
        },

        translations: {
            id: {
                home: 'Beranda',
                news: 'Kabar & Informasi',
                ormawa: 'Kelembagaan',
                bengkelIlmu: 'Potensi Desa',
                layananSurat: 'Layanan Surat',
                dashboard: 'Dashboard',
                login: 'Masuk',
                register: 'Daftar',
                aboutUs: 'Tentang Kami',
                contact: 'Kontak',
                contactUs: 'Hubungi Kami',
                quickLinks: 'Tautan Cepat',
                allRights: 'Hak Cipta Dilindungi',
                description: 'Pemerintah Desa Cigagade, Kecamatan Balubur Limbangan, Kabupaten Garut. Bersama mewujudkan desa yang maju, mandiri, agamis, dan sejahtera.',
                address: 'Jl. Raya Cigagade, Kec. Balubur Limbangan, Garut, Jawa Barat 44186',
                polmanBandung: 'Pemerintah Desa Cigagade',
                latestNews: 'Kabar Desa Terkini',
                newsSubtitle: 'Informasi pembangunan, pelayanan warga, dan kegiatan terkini di Desa Cigagade',
                newsPortal: 'Portal Berita Desa',
                noNews: 'Belum Ada Berita',
                noNewsDesc: 'Saat ini belum ada berita yang dipublikasikan. Silakan periksa kembali nanti.',
                backToHome: 'Kembali ke Beranda',
                filter: 'Filter',
                search: 'Cari...',
                month: 'Bulan',
                year: 'Tahun',
                allNews: 'Semua Berita',
                categoryLabel: 'Kategori',
                totalNews: 'Total Berita',
                readMore: 'Baca Selengkapnya',
                backToAllNews: 'Kembali ke Semua Berita',
                allCategories: 'Lihat Semua Kategori',
                noNewsInCat: 'Belum Ada Berita',
                noNewsInCatDesc: 'Kategori ini belum memiliki berita. Silakan cek kategori lainnya.',
                bengkelIlmuSubtitle: 'Ruang informasi potensi pertanian, perkebunan, UMKM, inovasi, dan literasi warga Desa Cigagade.',
                all: 'Semua',
                noContent: 'Belum ada konten di kategori ini.',
                infoCenter: 'Pusat Informasi Desa',
                infoCenterDesc: 'Pantau terus capaian prestasi dan pengumuman resmi dari Pemerintah Desa Cigagade.',
                achievement: 'Prestasi Desa',
                announcement: 'Pengumuman Resmi',
                noAchievement: 'Belum Ada Prestasi',
                noAchievementDesc: 'Belum ada catatan prestasi yang dipublikasikan.',
                noAnnouncement: 'Tidak Ada Pengumuman',
                noAnnouncementDesc: 'Belum ada pengumuman terbaru saat ini.',
                prestasiLabel: 'Prestasi',
                infoPenting: 'Info Penting',
                noImageLabel: 'Tidak ada gambar',
                beranda: 'Beranda',
                berita: 'Kabar Desa',
                collaboration: 'Lembaga & Mitra Kerja Sama',
                campusPress: 'Karang Taruna Karya Muda',
                journalist: 'BUMDes Gagade Mandiri',
                hmtmDesc: 'Badan Permusyawaratan Desa (BPD)',
                himamoDesc: 'Tim Penggerak PKK Desa Cigagade',
                hmtpDesc: 'Lembaga Pemberdayaan Masyarakat Desa (LPMD)',
                hmtplDesc: 'Kelompok Tani & Satlinmas Cigagade'
            },
            en: {
                home: 'Home',
                news: 'News & Info',
                ormawa: 'Institutions',
                bengkelIlmu: 'Village Potential',
                layananSurat: 'Online Service',
                dashboard: 'Dashboard',
                login: 'Login',
                register: 'Register',
                aboutUs: 'About Us',
                contact: 'Contact',
                contactUs: 'Contact Us',
                quickLinks: 'Quick Links',
                allRights: 'All Rights Reserved',
                description: 'Government of Cigagade Village, Balubur Limbangan District, Garut Regency. Together realizing a prosperous and self-reliant village.',
                address: 'Jl. Raya Cigagade, Balubur Limbangan, Garut, West Java 44186, Indonesia',
                polmanBandung: 'Cigagade Village Government',
                latestNews: 'Latest Village News',
                newsSubtitle: 'Development updates, public services, and community activities in Cigagade Village',
                newsPortal: 'Village News Portal',
                noNews: 'No News Yet',
                noNewsDesc: 'There are no published news at the moment. Please check back later.',
                backToHome: 'Back to Home',
                filter: 'Filter',
                search: 'Search...',
                month: 'Month',
                year: 'Year',
                allNews: 'All News',
                categoryLabel: 'Category',
                totalNews: 'Total News',
                readMore: 'Read More',
                backToAllNews: 'Back to All News',
                allCategories: 'View All Categories',
                noNewsInCat: 'No News Yet',
                noNewsInCatDesc: 'This category has no news yet. Please check other categories.',
                bengkelIlmuSubtitle: 'Information hub for agriculture, plantation, MSMEs, innovation, and local culture of Cigagade Village.',
                all: 'All',
                noContent: 'No content in this category yet.',
                infoCenter: 'Village Information Center',
                infoCenterDesc: 'Keep track of proud accomplishments and official notices from Cigagade Village Government.',
                achievement: 'Village Achievements',
                announcement: 'Official Announcements',
                noAchievement: 'No Achievements Yet',
                noAchievementDesc: 'No achievement records published yet.',
                noAnnouncement: 'No Announcements',
                noAnnouncementDesc: 'There are no latest announcements at this time.',
                prestasiLabel: 'Achievement',
                infoPenting: 'Important Info',
                noImageLabel: 'No image',
                beranda: 'Home',
                berita: 'News',
                collaboration: 'Institutions & Partners',
                campusPress: 'Karya Muda Youth Organization',
                journalist: 'Gagade Mandiri Village Enterprise',
                hmtmDesc: 'Village Consultative Body (BPD)',
                himamoDesc: 'Family Welfare Movement (TP-PKK)',
                hmtpDesc: 'Community Empowerment Body (LPMD)',
                hmtplDesc: 'Farmers Group & Village Guards'
            }
        },

        t(key) {
            return this.translations[this.currentLang][key] || key;
        },

        toggleDarkMode() {
            this.isTransitioning = true;
            setTimeout(() => {
                this.darkMode = !this.darkMode;
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
                setTimeout(() => {
                    this.isTransitioning = false;
                }, 500);
            }, 100);
        },

        toggleLanguage() {
            const nextLang = this.currentLang === 'id' ? 'en' : 'id';
            this.currentLang = nextLang;
            localStorage.setItem('language', nextLang);
            
            // Check if there is an alternate URL specific to the current page (e.g. news detail page)
            let redirectUrl = window.location.href;
            if (typeof window.alternateLangUrl !== 'undefined' && window.alternateLangUrl[nextLang]) {
                redirectUrl = window.alternateLangUrl[nextLang];
            }
            
            // Redirect to the Laravel set-locale route which sets a proper encrypted cookie,
            // then comes back to the correct URL.
            const encodedUrl = encodeURIComponent(redirectUrl);
            window.location.href = '/set-locale/' + nextLang + '?redirect=' + encodedUrl;
        }
    }"
    x-init="
        if (darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    ">

    {{-- Early global translation setup (non-deferred, runs immediately) --}}
    <script>
        window.bemCurrentLang = localStorage.getItem('language') || '{{ app()->getLocale() }}';
        window._bemTranslations = {
            id: Object.assign({}, @json(\Illuminate\Support\Facades\Lang::get('home', [], 'id')), {
                latestNews:'Kabar Desa Terkini',newsSubtitle:'Informasi pembangunan, pelayanan, dan kabar terkini Desa Cigagade',
                newsPortal:'Portal Berita Desa',noNews:'Belum Ada Berita',noNewsDesc:'Saat ini belum ada berita yang dipublikasikan. Silakan periksa kembali nanti.',
                backToHome:'Kembali ke Beranda',filter:'Filter',search:'Cari...',month:'Bulan',year:'Tahun',
                allNews:'Semua Berita',categoryLabel:'Kategori',totalNews:'Total Berita',readMore:'Baca Selengkapnya',
                backToAllNews:'Kembali ke Semua Berita',allCategories:'Lihat Semua Kategori',
                noNewsInCat:'Belum Ada Berita',noNewsInCatDesc:'Kategori ini belum memiliki berita. Silakan cek kategori lainnya.',
                bengkelIlmuSubtitle:'Ruang informasi potensi pertanian, perkebunan, UMKM, inovasi, dan literasi warga Desa Cigagade.',
                all:'Semua',noContent:'Belum ada konten di kategori ini.',
                infoCenter:'Pusat Informasi Desa',infoCenterDesc:'Pantau terus capaian prestasi dan pengumuman resmi dari Pemerintah Desa Cigagade.',
                achievement:'Prestasi Desa',announcement:'Pengumuman Resmi',
                noAchievement:'Belum Ada Prestasi',noAchievementDesc:'Belum ada catatan prestasi yang dipublikasikan.',
                noAnnouncement:'Tidak Ada Pengumuman',noAnnouncementDesc:'Belum ada pengumuman terbaru saat ini.',
                prestasiLabel:'Prestasi',infoPenting:'Info Penting',noImageLabel:'Tidak ada gambar',
                beranda:'Beranda',berita:'Kabar Desa',
                // Video page
                latestVideos:'Video & Dokumentasi Desa',videoSubtitle:'Dokumentasi kegiatan dan liputan potensi Desa Cigagade',
                featuredVideo:'Video Unggulan',watchNow:'Tonton Sekarang',
                noVideos:'Belum Ada Video',noVideosDesc:'Saat ini belum ada video yang dipublikasikan.',
                allVideos:'Semua Video',featured:'Unggulan',
                // Detail pages
                authorLabel:'Penulis',backToNews:'Kembali ke Berita',backToHome2:'Ke Beranda',
                articleCategory:'Kategori Berita',relatedNews:'Berita Terkait',
                noRelated:'Belum ada berita terkait lainnya.',
                backToInfoCenter:'Kembali ke Pusat Informasi',
                backToAnnouncements:'Kembali ke Daftar Pengumuman',
                achievementCorner:'Prestasi Desa',relatedAchievements:'Prestasi Terkait',
                relatedAnnouncements:'Pengumuman Terkait',
                pojokPrestasi:'Prestasi Desa',pengumuman:'Pengumuman',pusatInformasi:'Pusat Informasi'
            }),
            en: Object.assign({}, @json(\Illuminate\Support\Facades\Lang::get('home', [], 'en')), {
                latestNews:'Latest Village News',newsSubtitle:'Development updates and public services in Cigagade Village',
                newsPortal:'Village News Portal',noNews:'No News Yet',noNewsDesc:'There are no published news at the moment. Please check back later.',
                backToHome:'Back to Home',filter:'Filter',search:'Search...',month:'Month',year:'Year',
                allNews:'All News',categoryLabel:'Category',totalNews:'Total News',readMore:'Read More',
                backToAllNews:'Back to All News',allCategories:'View All Categories',
                noNewsInCat:'No News Yet',noNewsInCatDesc:'This category has no news yet. Please check other categories.',
                bengkelIlmuSubtitle:'Information hub for agriculture, MSMEs, innovation, and local culture of Cigagade Village.',
                all:'All',noContent:'No content in this category yet.',
                infoCenter:'Village Information Center',infoCenterDesc:'Keep track of proud accomplishments and official announcements from Cigagade Village Government.',
                achievement:'Village Achievements',announcement:'Official Announcements',
                noAchievement:'No Achievements Yet',noAchievementDesc:'No achievement records published yet.',
                noAnnouncement:'No Announcements',noAnnouncementDesc:'There are no latest announcements at this time.',
                prestasiLabel:'Achievement',infoPenting:'Important Info',noImageLabel:'No image',
                beranda:'Home',berita:'News',
                // Video page
                latestVideos:'Latest Village Videos',videoSubtitle:'Documentation of activities and village life in Cigagade',
                featuredVideo:'Featured Video',watchNow:'Watch Now',
                noVideos:'No Videos Yet',noVideosDesc:'There are no published videos at the moment.',
                allVideos:'All Videos',featured:'Featured',
                // Detail pages
                authorLabel:'Author',backToNews:'Back to News',backToHome2:'Go to Home',
                articleCategory:'Article Category',relatedNews:'Related News',
                noRelated:'No related news yet.',
                backToInfoCenter:'Back to Information Center',
                backToAnnouncements:'Back to Announcements',
                achievementCorner:'Village Achievements',relatedAchievements:'Related Achievements',
                relatedAnnouncements:'Related Announcements',
                pojokPrestasi:'Village Achievements',pengumuman:'Announcement',pusatInformasi:'Information Center'
            })
        };
        window.bemTranslate = function(key, lang) {
            lang = lang || window.bemCurrentLang;
            if (key.startsWith('home.')) {
                var subKey = key.substring(5);
                return (window._bemTranslations[lang] && window._bemTranslations[lang][subKey]) || key;
            }
            return (window._bemTranslations[lang] && window._bemTranslations[lang][key]) || key;
        };
        // Keep bemCurrentLang in sync
        window.addEventListener('langChanged', function(e) {
            window.bemCurrentLang = e.detail.lang;
        });
        // Auto-apply [data-t] translations
        function _applyDataT(lang) {
            document.querySelectorAll('[data-t]').forEach(function(el) {
                var key = el.getAttribute('data-t');
                el.textContent = window.bemTranslate(key, lang);
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            _applyDataT(window.bemCurrentLang);
            window.addEventListener('langChanged', function(e) {
                _applyDataT(e.detail.lang);
            });
        });
    </script>

    <div class="theme-transition" :class="{ 'active': isTransitioning }">
        <div class="loader"></div>
    </div>

    <!-- Floating iOS-style Navbar -->
    <div class="fixed top-0 inset-x-0 z-50 flex justify-center pt-4 px-4 sm:px-6 lg:px-8 pointer-events-none transition-all duration-300" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <nav :class="{'shadow-[0_8px_30px_rgb(0,0,0,0.08)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.3)]': scrolled, 'shadow-sm': !scrolled}" class="glass w-full max-w-7xl rounded-[2rem] pointer-events-auto transition-all duration-500 ease-out" x-data="{ open: false, kategoriOpen: false }" @click.away="open = false">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-14 lg:h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center space-x-3 hover-lift active:scale-95 transition-transform flex-shrink-0">
                            @if ($logoPath && file_exists(public_path('storage/' . $logoPath)))
                                <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo Desa Cigagade" class="block h-10 w-auto drop-shadow-md">
                            @else
                                <x-application-logo class="h-10 w-10 text-emerald-600 dark:text-emerald-400" />
                            @endif
                            <div class="hidden sm:block text-left">
                                <div class="font-extrabold text-sm sm:text-base text-slate-900 dark:text-white tracking-tight leading-none uppercase">DESA CIGAGADE</div>
                                <div class="text-[10px] font-semibold text-emerald-600 dark:text-emerald-400 tracking-wider mt-0.5">KEC. BALUBUR LIMBANGAN</div>
                            </div>
                        </a>
                    </div>

                    <div class="hidden lg:flex lg:items-center space-x-1.5 xl:space-x-2">
                        {{-- Home --}}
                        <a href="{{ route('home') }}" class="nav-link nav-pill text-slate-600 dark:text-slate-300 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 {{ request()->routeIs('home') ? 'bg-slate-100/80 dark:bg-slate-800/80 text-slate-900 dark:text-white shadow-sm font-semibold' : '' }}" x-text="t('home')">
                        </a>

                        {{-- Kabar & Informasi Dropdown (Digabung dengan Prestasi & Pengumuman) --}}
                        <div class="relative" x-data="{ openNews: false }">
                            <button @click="openNews = !openNews"
                                    class="nav-link nav-pill whitespace-nowrap text-slate-600 dark:text-slate-300 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 inline-flex items-center gap-1 {{ request()->routeIs('berita.*') || request()->routeIs('kategori.*') || request()->routeIs('prestasi-pengumuman') || request()->routeIs('video.*') || request()->routeIs('infografis.*') ? 'bg-slate-100/80 dark:bg-slate-800/80 text-slate-900 dark:text-white shadow-sm font-semibold' : '' }}">
                                <span x-text="t('news')"></span>
                                <svg class="ml-1 h-3.5 w-3.5 transition-transform duration-300" :class="{ '-rotate-180': openNews }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="openNews"
                                 @click.away="openNews = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                 class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-64 rounded-2xl shadow-2xl bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl overflow-hidden border border-slate-200/80 dark:border-slate-700/80 p-2 z-50"
                                 style="display: none;">
                                <div class="flex flex-col space-y-1">
                                    <a href="{{ route('infografis.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50/80 dark:hover:bg-emerald-900/30 transition-all flex items-center justify-between">
                                        <span class="flex items-center gap-2.5">
                                            <i class="fas fa-chart-pie text-xs"></i>
                                            <span>Infografis & Data Desa</span>
                                        </span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">Data</span>
                                    </a>
                                    <a href="{{ route('berita.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-2.5">
                                        <i class="fas fa-newspaper text-xs"></i>
                                        <span>Semua Kabar Desa</span>
                                    </a>
                                    <a href="{{ route('prestasi-pengumuman') }}" class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-2.5">
                                        <i class="fas fa-bullhorn text-xs text-blue-500"></i>
                                        <span>Pengumuman & Prestasi</span>
                                    </a>
                                    <a href="{{ route('video.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-2.5">
                                        <i class="fab fa-youtube text-xs text-red-500"></i>
                                        <span>Cigagade TV & Video</span>
                                    </a>
                                    <div class="border-t border-slate-200/60 dark:border-slate-700/60 my-1 mx-2"></div>
                                    <div class="px-3 py-1">
                                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Kategori Populer</span>
                                    </div>
                                    @foreach ($categories->take(5) as $category)
                                        <a href="{{ route('kategori.posts', $category->slug) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white transition-all flex items-center justify-between">
                                            <span>{{ $category->name }}</span>
                                            <i class="fas fa-chevron-right text-[9px] text-slate-300 dark:text-slate-600"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Kelembagaan Desa Dropdown --}}
                        <div class="relative" x-data="{ openOrmawa: false }">
                            <button @click="openOrmawa = !openOrmawa"
                                    class="nav-link nav-pill whitespace-nowrap text-slate-600 dark:text-slate-300 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 inline-flex items-center gap-1 {{ request()->routeIs('kategori.posts', 'kegiatan-ukm') || request()->routeIs('kategori.posts', 'prestasi-ukm') || request()->routeIs('kategori.posts', 'kegiatan-himpunan') || request()->routeIs('kategori.posts', 'prestasi-himpunan') ? 'bg-slate-100/80 dark:bg-slate-800/80 text-slate-900 dark:text-white shadow-sm font-semibold' : '' }}">
                                <span x-text="t('ormawa')"></span>
                                <svg class="ml-1 h-3.5 w-3.5 transition-transform duration-300" :class="{ '-rotate-180': openOrmawa }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="openOrmawa"
                                 @click.away="openOrmawa = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                 class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-60 rounded-2xl shadow-2xl bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl overflow-hidden border border-slate-200/80 dark:border-slate-700/80 p-2 z-50"
                                 style="display: none;">
                                <div class="flex flex-col space-y-0.5">
                                    <div class="px-3 pt-1 pb-1">
                                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Lembaga Warga</span>
                                    </div>
                                    <a href="{{ route('kategori.posts', 'kegiatan-ukm') }}" class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-2.5">
                                        <i class="fas fa-users text-xs text-emerald-500"></i> Karang Taruna
                                    </a>
                                    <a href="{{ route('kategori.posts', 'prestasi-ukm') }}" class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-2.5">
                                        <i class="fas fa-hand-holding-heart text-xs text-pink-500"></i> TP-PKK Desa
                                    </a>
                                    <div class="border-t border-slate-200/60 dark:border-slate-700/60 my-1 mx-2"></div>
                                    <div class="px-3 pt-1 pb-1">
                                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Aparatur & Musyawarah</span>
                                    </div>
                                    <a href="{{ route('kategori.posts', 'kegiatan-himpunan') }}" class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-2.5">
                                        <i class="fas fa-landmark text-xs text-blue-500"></i> BPD & LPMD
                                    </a>
                                    <a href="{{ route('kategori.posts', 'prestasi-himpunan') }}" class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-2.5">
                                        <i class="fas fa-wheat-awn text-xs text-amber-500"></i> Gapoktan & Linmas
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Potensi Desa Dropdown (Termasuk UMKM Desa) --}}
                        <div class="relative" x-data="{ openBengkel: false }">
                            <button @click="openBengkel = !openBengkel"
                                    class="nav-link nav-pill whitespace-nowrap text-slate-600 dark:text-slate-300 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 inline-flex items-center gap-1 {{ request()->routeIs('bengkel-ilmu.*') || request()->routeIs('umkm.*') ? 'bg-slate-100/80 dark:bg-slate-800/80 text-slate-900 dark:text-white shadow-sm font-semibold' : '' }}">
                                <span x-text="t('bengkelIlmu')"></span>
                                <svg class="ml-1 h-3.5 w-3.5 transition-transform duration-300" :class="{ '-rotate-180': openBengkel }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="openBengkel"
                                 @click.away="openBengkel = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                 class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-64 rounded-2xl shadow-2xl bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl overflow-hidden border border-slate-200/80 dark:border-slate-700/80 p-2 z-50"
                                 style="display: none;">
                                <div class="flex flex-col space-y-1">
                                    <a href="{{ route('umkm.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50/80 dark:hover:bg-emerald-900/30 transition-all flex items-center justify-between">
                                        <span class="flex items-center gap-2.5">
                                            <i class="fas fa-store text-xs"></i>
                                            <span>Produk UMKM Desa</span>
                                        </span>
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">Katalog</span>
                                    </a>
                                    <a href="{{ route('bengkel-ilmu.list') }}" class="px-3.5 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 transition-all flex items-center gap-2.5">
                                        <i class="fas fa-layer-group text-xs text-blue-500"></i>
                                        <span>Semua Potensi Desa</span>
                                    </a>
                                    <div class="border-t border-slate-200/60 dark:border-slate-700/60 my-1 mx-2"></div>
                                    <div class="px-3 py-1">
                                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Sektor Unggulan</span>
                                    </div>
                                    <a href="{{ route('bengkel-ilmu.list', ['kategori' => 'karir-pengembangan-diri']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-2.5">
                                        <i class="fas fa-seedling text-emerald-500 text-xs"></i> Pertanian & Irigasi
                                    </a>
                                    <a href="{{ route('bengkel-ilmu.list', ['kategori' => 'hiburan']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100/80 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white transition-all flex items-center gap-2.5">
                                        <i class="fas fa-mountain-sun text-amber-500 text-xs"></i> Seni, Wisata & Budaya
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Fitur Unggulan: Layanan Surat Online --}}
                        <button @click="suratModalOpen = true" class="nav-link nav-pill bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-md shadow-emerald-600/20 inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs transition-all hover:scale-105 active:scale-95">
                            <i class="fas fa-file-pen text-xs"></i>
                            <span x-text="t('layananSurat')"></span>
                        </button>
                    </div>

                    <div class="hidden lg:flex lg:items-center space-x-2">
                        <div class="flex items-center space-x-1 mr-1 bg-slate-100/60 dark:bg-slate-800/60 p-1 rounded-full border border-slate-200/50 dark:border-slate-700/50">
                            <button @click="toggleLanguage()" class="w-8 h-8 flex items-center justify-center rounded-full text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 hover:shadow-sm transition-all" title="Ubah Bahasa">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                </svg>
                            </button>

                            <button @click="toggleDarkMode()" class="w-8 h-8 flex items-center justify-center rounded-full text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 hover:shadow-sm transition-all" title="Mode Gelap / Terang">
                                <svg x-show="!darkMode" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                                <svg x-show="darkMode" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </button>
                        </div>

                        @if (Route::has('login'))
                            <div class="flex items-center">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn-primary px-4 py-2 text-xs font-semibold text-white shadow-sm flex items-center gap-1.5" x-text="t('dashboard')">
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-full text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100/80 dark:bg-slate-800/80 hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 dark:hover:text-white transition-all shadow-sm flex items-center gap-1.5 border border-slate-200/50 dark:border-slate-700/50" title="Login Admin / Staf Desa">
                                        <i class="fas fa-lock text-[10px]"></i>
                                        <span x-text="t('login')"></span>
                                    </a>
                                @endauth
                            </div>
                        @endif
                    </div>

                <div class="flex items-center space-x-2 lg:hidden">
                    <div class="flex items-center space-x-1 mr-1 bg-slate-100/50 dark:bg-slate-800/50 p-1 rounded-full border border-slate-200/50 dark:border-slate-700/50">
                        <button @click="toggleLanguage()" class="nav-link w-8 h-8 flex items-center justify-center rounded-full text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 hover:shadow-sm transition-all">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                            </svg>
                        </button>
                        <button @click="toggleDarkMode()" class="nav-link w-8 h-8 flex items-center justify-center rounded-full text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-700 hover:shadow-sm transition-all">
                            <svg x-show="!darkMode" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <svg x-show="darkMode" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </button>
                    </div>

                    <button @click="open = !open" class="nav-link w-10 h-10 flex items-center justify-center rounded-full bg-slate-100/50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-300 hover:bg-slate-200/50 dark:hover:bg-slate-700/50 active:scale-90 transition-all border border-slate-200/50 dark:border-slate-700/50" aria-label="Toggle menu" aria-expanded="open">
                        <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Collapsible) -->
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden border-t border-slate-200/50 dark:border-slate-700/50"
             style="display: none;">
            <div class="p-4 space-y-1 max-h-[70vh] overflow-y-auto overscroll-contain" x-data="{ mobileNewsOpen: false, mobileOrmawaOpen: false, mobileBengkelOpen: false }">
                {{-- Home --}}
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl {{ request()->routeIs('home') ? 'bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-semibold' : 'text-slate-600 dark:text-slate-300' }} text-base font-medium hover:bg-slate-100 dark:hover:bg-slate-800 transition-all" x-text="t('home')">
                </a>

                {{-- Kabar & Informasi Dropdown (Mobile) --}}
                <div>
                    <button @click="mobileNewsOpen = !mobileNewsOpen" class="w-full flex items-center justify-between px-4 py-3 text-left rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('berita.*') || request()->routeIs('kategori.*') || request()->routeIs('prestasi-pengumuman') ? 'bg-slate-100 dark:bg-slate-800 font-semibold text-slate-900 dark:text-white' : '' }}">
                        <span class="text-base font-medium text-slate-700 dark:text-slate-200" x-text="t('news')"></span>
                        <svg class="h-4 w-4 text-slate-500 dark:text-slate-400 transition-transform duration-300" :class="{ 'rotate-180': mobileNewsOpen }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="mobileNewsOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="space-y-1 pl-4 mt-1 border-l-2 border-emerald-200 dark:border-emerald-800 ml-4">
                        <a href="{{ route('infografis.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all flex items-center justify-between">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-chart-pie text-xs"></i>
                                <span>Infografis & Data Desa</span>
                            </span>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">Data</span>
                        </a>
                        <a href="{{ route('berita.index') }}" class="block px-4 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex items-center gap-2">
                            <i class="fas fa-newspaper text-xs"></i>
                            <span>Semua Kabar Desa</span>
                        </a>
                        <a href="{{ route('prestasi-pengumuman') }}" class="block px-4 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex items-center gap-2">
                            <i class="fas fa-bullhorn text-xs text-blue-500"></i>
                            <span>Pengumuman & Prestasi</span>
                        </a>
                        <a href="{{ route('video.index') }}" class="block px-4 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex items-center gap-2">
                            <i class="fab fa-youtube text-xs text-red-500"></i>
                            <span>Cigagade TV & Video</span>
                        </a>
                        <div class="border-t border-slate-200/60 dark:border-slate-700/60 my-1"></div>
                        @foreach ($categories->take(5) as $category)
                            <a href="{{ route('kategori.posts', $category->slug) }}" class="block px-4 py-1.5 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-all">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Kelembagaan Desa Dropdown (Mobile) --}}
                <div>
                    <button @click="mobileOrmawaOpen = !mobileOrmawaOpen" class="w-full flex items-center justify-between px-4 py-3 text-left rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('video.*') ? 'bg-slate-100 dark:bg-slate-800 font-semibold text-slate-900 dark:text-white' : '' }}">
                        <span class="text-base font-medium text-slate-700 dark:text-slate-200" x-text="t('ormawa')"></span>
                        <svg class="h-4 w-4 text-slate-500 dark:text-slate-400 transition-transform duration-300" :class="{ 'rotate-180': mobileOrmawaOpen }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="mobileOrmawaOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="mt-1 ml-4 border-l-2 border-emerald-200 dark:border-emerald-800 pl-4 space-y-0.5">
                        <p class="px-4 pt-2 pb-1 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Lembaga Warga</p>
                        <a href="{{ route('kategori.posts', 'kegiatan-ukm') }}" class="block px-4 py-2 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex items-center gap-2">
                            Karang Taruna
                        </a>
                        <a href="{{ route('kategori.posts', 'prestasi-ukm') }}" class="block px-4 py-2 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex items-center gap-2">
                            TP-PKK Desa
                        </a>
                        <p class="px-4 pt-3 pb-1 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Aparatur & Musyawarah</p>
                        <a href="{{ route('kategori.posts', 'kegiatan-himpunan') }}" class="block px-4 py-2 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex items-center gap-2">
                            BPD & LPMD
                        </a>
                        <a href="{{ route('kategori.posts', 'prestasi-himpunan') }}" class="block px-4 py-2 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex items-center gap-2">
                            Gapoktan & Linmas
                        </a>
                    </div>
                </div>

                {{-- Potensi Desa Dropdown (Mobile) --}}
                <div>
                    <button @click="mobileBengkelOpen = !mobileBengkelOpen" class="w-full flex items-center justify-between px-4 py-3 text-left rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('bengkel-ilmu.*') || request()->routeIs('umkm.*') ? 'bg-slate-100 dark:bg-slate-800 font-semibold text-slate-900 dark:text-white' : '' }}">
                        <span class="text-base font-medium text-slate-700 dark:text-slate-200" x-text="t('bengkelIlmu')"></span>
                        <svg class="h-4 w-4 text-slate-500 dark:text-slate-400 transition-transform duration-300" :class="{ 'rotate-180': mobileBengkelOpen }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="mobileBengkelOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="mt-1 ml-4 border-l-2 border-emerald-200 dark:border-emerald-800 pl-4 space-y-0.5">
                        <a href="{{ route('umkm.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all flex items-center justify-between">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-store text-xs"></i>
                                <span>Produk UMKM Desa</span>
                            </span>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">Katalog</span>
                        </a>
                        <a href="{{ route('bengkel-ilmu.list') }}" class="block px-4 py-2 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex items-center gap-2">
                            <i class="fas fa-layer-group text-xs text-blue-500"></i>
                            <span>Semua Potensi Desa</span>
                        </a>
                        <div class="border-t border-slate-200/60 dark:border-slate-700/60 my-1"></div>
                        <a href="{{ route('bengkel-ilmu.list', ['kategori' => 'karir-pengembangan-diri']) }}" class="block px-4 py-1.5 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex items-center gap-2">
                            <i class="fas fa-seedling text-emerald-500 text-xs"></i>
                            Pertanian & Irigasi
                        </a>
                        <a href="{{ route('bengkel-ilmu.list', ['kategori' => 'hiburan']) }}" class="block px-4 py-1.5 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-all flex items-center gap-2">
                            <i class="fas fa-mountain-sun text-amber-500 text-xs"></i>
                            Seni, Wisata & Budaya
                        </a>
                    </div>
                </div>

                {{-- Layanan Surat (Mobile Action) --}}
                <div class="pt-2">
                    <button type="button" @click="suratModalOpen = true; open = false" class="w-full py-2.5 px-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 flex items-center justify-center gap-2 shadow-sm transition-all active:scale-95">
                        <i class="fas fa-file-pen text-sm"></i>
                        <span>Layanan Surat Mandiri Warga</span>
                    </button>
                </div>

            </div>

            <div class="pt-4 mt-4 border-t border-slate-200/50 dark:border-slate-700/50">
                <div class="space-y-3">
                     @if (Route::has('login'))
                         @auth
                            <a href="{{ url('/dashboard') }}" class="block w-full py-3 rounded-full text-base font-semibold text-white btn-primary text-center" x-text="t('dashboard')">
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block w-full py-3 rounded-full text-sm font-bold btn-secondary text-center transition-all flex items-center justify-center gap-2" title="Login Admin Desa">
                                <i class="fas fa-lock text-xs"></i>
                                <span x-text="t('login')"></span>
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
        </nav>
    </div>

    <main class="min-h-screen {{ isset($noPadding) && $noPadding ? '' : 'pt-28' }}">
        {{ $slot }}
    </main>

    <footer class="mt-16 bg-slate-900 text-white border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        @if ($logoPath && file_exists(public_path('storage/' . $logoPath)))
                            <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo Desa Cigagade" class="h-10 w-auto">
                        @else
                            <x-application-logo class="h-10 w-auto text-emerald-500" />
                        @endif
                        <div>
                            <h3 class="text-xl font-bold text-white tracking-tight">Desa Cigagade</h3>
                            <p class="text-xs text-emerald-400 font-semibold tracking-wider uppercase">Kecamatan Balubur Limbangan</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6" x-text="t('description')">
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://garutkab.go.id" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-emerald-600 transition-all duration-300" title="Portal Pemkab Garut">
                            <i class="fas fa-globe text-base"></i>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-emerald-600 transition-all duration-300" title="WhatsApp Pelayanan Desa">
                            <i class="fab fa-whatsapp text-lg"></i>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-pink-600 transition-all duration-300" title="Instagram Resmi">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4 text-white" x-text="t('quickLinks')"></h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white hover:underline transition-colors" x-text="t('home')"></a></li>
                        <li><a href="{{ route('berita.index') }}" class="text-gray-400 hover:text-white hover:underline transition-colors" x-text="t('news')"></a></li>
                        <li><a href="{{ route('prestasi-pengumuman') }}" class="text-gray-400 hover:text-white hover:underline transition-colors" x-text="t('infoCenter')"></a></li>
                        <li><a href="{{ route('bengkel-ilmu.list') }}" class="text-gray-400 hover:text-white hover:underline transition-colors" x-text="t('bengkelIlmu')"></a></li>
                        <li><a href="{{ route('video.index') }}" class="text-gray-400 hover:text-white hover:underline transition-colors" x-text="t('latestVideos')"></a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4 text-white" x-text="t('contactUs')"></h3>
                    <div class="space-y-3 text-sm text-gray-400">
                        <p class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-emerald-400"></i>
                            <span><strong class="text-slate-200">Kantor Kepala Desa Cigagade</strong><br>Jl. Raya Cigagade, Kec. Balubur Limbangan, Kab. Garut, Jawa Barat 44186</span>
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-emerald-400"></i>
                            <a href="mailto:desa.cigagade@garutkab.go.id" class="hover:text-white transition-colors">desa.cigagade@garutkab.go.id</a>
                        </p>
                        <p class="flex items-center">
                            <i class="fab fa-whatsapp mr-3 text-emerald-400 text-base"></i>
                            <a href="https://wa.me/6281234567890" target="_blank" class="hover:text-white transition-colors">+62 812-3456-7890 (Layanan Warga)</a>
                        </p>
                        <p class="flex items-center text-xs text-slate-500">
                            <i class="far fa-clock mr-3 text-slate-500"></i>
                            <span>Senin - Jumat: 08.00 - 15.30 WIB</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- ── Footer Bottom & Watermark KKN POLMAN Bandung ── --}}
            <div class="mt-12 pt-8 border-t border-slate-800/80 flex flex-col md:flex-row items-center justify-between gap-4 text-center md:text-left">
                <div>
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} Pemerintah Desa Cigagade, Balubur Limbangan, Garut. <span x-text="t('allRights')"></span>.
                    </p>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Portal Layanan Informasi dan Pelayanan Publik Terpadu Desa Cigagade.
                    </p>
                </div>
                <div class="inline-flex items-center gap-3 px-4 py-2 rounded-2xl bg-slate-800/90 border border-slate-700/80 shadow-xs">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-sm">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="text-left">
                        <span class="block text-[10px] uppercase font-bold tracking-wider text-slate-400">Pengabdian Masyarakat</span>
                        <span class="block text-xs font-bold text-white tracking-wide">KKN Politeknik Manufaktur Bandung</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Modal Layanan Surat Mandiri Warga --}}
    <div x-show="suratModalOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm"
         style="display: none;"
         @keydown.escape.window="suratModalOpen = false">
        
        <div @click.away="suratModalOpen = false" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="w-full max-w-lg bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden my-6 max-h-[90vh] flex flex-col">
            
            <!-- Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-md">
                        <i class="fas fa-file-signature text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Layanan Surat Mandiri Warga</h3>
                        <p class="text-xs text-emerald-100">Pelayanan Administrasi Desa Cigagade</p>
                    </div>
                </div>
                <button type="button" @click="suratModalOpen = false" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-all">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Form Body -->
            <div class="p-6 overflow-y-auto space-y-4 text-sm text-slate-700 dark:text-slate-200">
                <div class="p-3 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-xs text-emerald-800 dark:text-emerald-300">
                    <p class="font-semibold mb-1"><i class="fas fa-circle-info mr-1"></i> Informasi Layanan:</p>
                    Isi data di bawah ini untuk mengajukan permohonan surat keterangan. Pengajuan akan langsung diformat dan dikirim ke kontak WhatsApp resmi Kantor Desa Cigagade untuk segera diproses.
                </div>

                <div>
                    <label class="block font-semibold mb-1 text-slate-700 dark:text-slate-300">Jenis Surat yang Dimohon <span class="text-red-500">*</span></label>
                    <select x-model="suratForm.jenis" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-slate-100">
                        <option value="Surat Keterangan Usaha (SKU)">Surat Keterangan Usaha (SKU)</option>
                        <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                        <option value="Surat Pengantar SKCK">Surat Pengantar SKCK</option>
                        <option value="Surat Keterangan Tidak Mampu (SKTM)">Surat Keterangan Tidak Mampu (SKTM)</option>
                        <option value="Surat Keterangan Belum Menikah">Surat Keterangan Belum Menikah</option>
                        <option value="Surat Keterangan Kematian">Surat Keterangan Kematian</option>
                        <option value="Surat Pengantar Umum">Surat Pengantar Umum / Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-1 text-slate-700 dark:text-slate-300">Nama Lengkap (Sesuai KTP) <span class="text-red-500">*</span></label>
                    <input type="text" x-model="suratForm.nama" placeholder="Contoh: Asep Saepudin" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-slate-100" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1 text-slate-700 dark:text-slate-300">NIK (Nomor KTP) <span class="text-red-500">*</span></label>
                        <input type="text" x-model="suratForm.nik" maxlength="16" placeholder="16 digit NIK" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-slate-100" />
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-slate-700 dark:text-slate-300">No. WhatsApp Pemohon <span class="text-red-500">*</span></label>
                        <input type="text" x-model="suratForm.telepon" placeholder="08xxxxxxxxxx" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-slate-100" />
                    </div>
                </div>

                <div>
                    <label class="block font-semibold mb-1 text-slate-700 dark:text-slate-300">Alamat / Dusun / RT / RW <span class="text-red-500">*</span></label>
                    <input type="text" x-model="suratForm.alamat" placeholder="Contoh: Dusun Cigagade, RT 02 / RW 04" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-slate-100" />
                </div>

                <div>
                    <label class="block font-semibold mb-1 text-slate-700 dark:text-slate-300">Keperluan Pembuatan Surat <span class="text-red-500">*</span></label>
                    <textarea x-model="suratForm.keperluan" rows="2" placeholder="Contoh: Pengajuan pinjaman modal usaha / Melamar pekerjaan" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none text-slate-800 dark:text-slate-100 resize-none"></textarea>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="p-4 bg-slate-50 dark:bg-slate-800/80 border-t border-slate-200 dark:border-slate-800 flex items-center justify-end gap-3 shrink-0">
                <button type="button" @click="suratModalOpen = false" class="px-4 py-2.5 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 font-medium transition-all">
                    Batal
                </button>
                <button type="button" @click="kirimSuratWa()" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold flex items-center gap-2 shadow-md hover:shadow-emerald-500/20 active:scale-95 transition-all">
                    <i class="fab fa-whatsapp text-lg"></i>
                    <span>Kirim via WhatsApp Pelayanan</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- WIDGET STATISTIK KUNJUNGAN - Pojok Kiri Bawah --}}
    {{-- ============================================================ --}}
    <x-visitor-counter />

    {{-- ============================================================ --}}
    {{-- WIDGET AKSESIBILITAS - Floating Action Button (semua halaman) --}}
    {{-- ============================================================ --}}

    {{-- CSS Aksesibilitas --}}
    <style>
        /* ── OpenDyslexic font ── */
        @import url('https://fonts.cdnfonts.com/css/opendyslexic');

        /* ── Dyslexia Font Mode ── */
        html.dyslexia-font body,
        html.dyslexia-font p,
        html.dyslexia-font h1, html.dyslexia-font h2, html.dyslexia-font h3,
        html.dyslexia-font h4, html.dyslexia-font li, html.dyslexia-font a,
        html.dyslexia-font span, html.dyslexia-font td, html.dyslexia-font th {
            font-family: 'OpenDyslexic', 'Comic Sans MS', cursive !important;
            letter-spacing: 0.07em !important;
            line-height: 1.9 !important;
            word-spacing: 0.2em !important;
        }

        /* ── High Contrast Mode ── */
        html.high-contrast body { background: #000 !important; color: #fff !important; }
        
        /* Memastikan teks utama terbaca dengan jelas (Putih) */
        html.high-contrast h1, html.high-contrast h2, html.high-contrast h3, html.high-contrast h4, html.high-contrast h5, html.high-contrast h6, html.high-contrast p, html.high-contrast span, html.high-contrast div {
            color: #ffffff !important;
        }

        /* Memberikan background hitam pekat & border tegas untuk elemen struktural / Card agar tidak transparan */
        html.high-contrast .bg-white, html.high-contrast .bg-slate-50, html.high-contrast .bg-slate-100, html.high-contrast .bg-slate-800, html.high-contrast .bg-slate-900, html.high-contrast .bg-slate-950, html.high-contrast .glass, html.high-contrast #a11y-panel, html.high-contrast header, html.high-contrast footer, html.high-contrast nav {
            background-color: #000 !important;
            border: 1px solid #555 !important;
        }
        
        /* Link menjadi kuning agar kontras */
        html.high-contrast a, html.high-contrast a * { color: #facc15 !important; text-decoration: underline !important; }
        
        /* Tombol */
        html.high-contrast button, html.high-contrast button * { background-color: #111 !important; color: #facc15 !important; border-color: #facc15 !important; }
        html.high-contrast button { border: 1px solid #facc15 !important; }
        
        /* Gambar hitam putih & kontras tinggi */
        html.high-contrast img { filter: grayscale(100%) contrast(130%) !important; }

        /* ── Highlight Links ── */
        html.highlight-links a {
            outline: 2px solid #facc15 !important;
            background: rgba(250, 204, 21, 0.15) !important;
            border-radius: 3px !important;
            text-decoration: underline !important;
        }

        /* ── Pause Animations ── */
        html.pause-animations *,
        html.pause-animations *::before,
        html.pause-animations *::after {
            animation-duration: 0.001s !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.001s !important;
            scroll-behavior: auto !important;
        }

        /* ── Reading Mask ── */
        #a11y-reading-mask {
            position: fixed;
            left: 0;
            width: 100%;
            height: 60px;
            pointer-events: none;
            z-index: 9990;
            background: rgba(255, 255, 180, 0.25);
            box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.45);
            border-radius: 4px;
            display: none;
            top: 200px;
            transition: top 0.05s linear;
        }
        html.reading-mask #a11y-reading-mask { display: block; }

        /* ── FAB Widget ── */
        #a11y-widget {
            position: fixed;
            bottom: 5.5rem;
            right: 1.25rem;
            z-index: 9999;
        }

        #a11y-fab {
            width: 3.25rem;
            height: 3.25rem;
            background: linear-gradient(135deg, #059669, #064e3b);
            border-radius: 50%;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(5, 150, 105, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s;
            color: white;
            font-size: 1.3rem;
        }
        #a11y-fab:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 28px rgba(5, 150, 105, 0.65);
        }
        #a11y-fab.active { transform: rotate(20deg) scale(1.05); }

        /* Panel */
        #a11y-panel {
            position: absolute;
            bottom: 4rem;
            right: 0;
            width: calc(100vw - 2.5rem);
            max-width: 20rem;
            max-height: calc(100vh - 11rem);
            max-height: calc(100dvh - 11rem);
            overflow-y: auto;
            background: white;
            border-radius: 1.25rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.18);
            border: 1px solid rgba(0,0,0,0.06);
            opacity: 0;
            transform: translateY(16px) scale(0.95);
            transform-origin: bottom right;
            transition: opacity 0.25s ease, transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            pointer-events: none;
        }
        #a11y-panel.open {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: all;
        }
        .dark #a11y-panel {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }

        /* Panel header */
        .a11y-header {
            background: linear-gradient(135deg, #059669, #047857);
            color: white;
            padding: 1rem 1.25rem;
            border-radius: 1.25rem 1.25rem 0 0;
        }

        /* Feature rows */
        .a11y-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1.25rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: background 0.2s;
        }
        .dark .a11y-row { border-color: rgba(255,255,255,0.05); }
        .a11y-row:hover { background: rgba(5, 150, 105, 0.05); }
        .a11y-row:last-child { border-bottom: none; }

        .a11y-label {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: #374151;
        }
        .dark .a11y-label { color: #cbd5e1; }
        .a11y-label .icon { width: 1.6rem; height: 1.6rem; display:flex; align-items:center; justify-content:center; border-radius: 8px; font-size: 0.85rem; flex-shrink: 0; }

        /* Toggle switch */
        .a11y-toggle {
            position: relative;
            width: 2.75rem;
            height: 1.5rem;
            flex-shrink: 0;
        }
        .a11y-toggle input { opacity: 0; width: 0; height: 0; }
        .a11y-slider {
            position: absolute;
            inset: 0;
            background: #d1d5db;
            border-radius: 9999px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .a11y-slider::before {
            content: '';
            position: absolute;
            height: 1.1rem;
            width: 1.1rem;
            left: 3px;
            bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s;
        }
        .a11y-toggle input:checked + .a11y-slider { background: #059669; }
        .a11y-toggle input:checked + .a11y-slider::before { transform: translateX(1.25rem); }

        /* TTS section */
        .a11y-tts-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .a11y-tts-btn {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            transition: all 0.2s;
        }
        .a11y-tts-btn.play { background: #059669; color: white; }
        .a11y-tts-btn.play:hover { background: #047857; }
        .a11y-tts-btn.stop { background: #f1f5f9; color: #64748b; }
        .dark .a11y-tts-btn.stop { background: #334155; color: #94a3b8; }
        .a11y-tts-btn.stop:hover { background: #fee2e2; color: #dc2626; }

        /* Font size buttons */
        .a11y-fs-group {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        .a11y-fs-btn {
            width: 1.85rem;
            height: 1.85rem;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            transition: all 0.2s;
            color: #374151;
        }
        .dark .a11y-fs-btn { background: #334155; border-color: #475569; color: #e2e8f0; }
        .a11y-fs-btn:hover { background: #059669; color: white; border-color: #059669; }
        .a11y-fs-btn:disabled { opacity: 0.4; cursor: not-allowed; }
        .a11y-fs-btn:disabled:hover { background: #f8fafc; color: #374151; border-color: #e2e8f0; }

        #a11y-fs-value {
            min-width: 2.2rem;
            text-align: center;
            font-size: 0.75rem;
            font-weight: 600;
            color: #059669;
        }

        /* Speed control */
        .a11y-speed {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .a11y-speed-btn {
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            cursor: pointer;
            font-size: 0.65rem;
            font-weight: 700;
            color: #374151;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.15s;
        }
        .dark .a11y-speed-btn { background: #334155; border-color: #475569; color: #e2e8f0; }
        .a11y-speed-btn:hover { background: #059669; color: white; border-color: #059669; }

        /* TTS progress bar */
        #a11y-tts-progress {
            height: 3px;
            background: #e2e8f0;
            margin: 0 1.25rem;
            border-radius: 9999px;
            overflow: hidden;
            display: none;
        }
        #a11y-tts-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #059669, #10b981);
            border-radius: 9999px;
            transition: width 0.5s linear;
        }

        /* Speaking wave indicator */
        @keyframes a11y-wave {
            0%, 100% { transform: scaleY(0.5); }
            50% { transform: scaleY(1.5); }
        }
        .a11y-wave-bar {
            display: inline-block;
            width: 3px;
            height: 12px;
            background: #059669;
            border-radius: 2px;
            animation: a11y-wave 0.8s ease infinite;
            margin: 0 1px;
        }
        .a11y-wave-bar:nth-child(2) { animation-delay: 0.15s; }
        .a11y-wave-bar:nth-child(3) { animation-delay: 0.3s; }
        .a11y-wave-bar:nth-child(4) { animation-delay: 0.15s; }

        /* Reset button */
        .a11y-reset {
            display: block;
            width: calc(100% - 2.5rem);
            margin: 0.75rem 1.25rem;
            padding: 0.5rem;
            border-radius: 0.75rem;
            border: 1px dashed #cbd5e1;
            background: transparent;
            font-size: 0.8rem;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 500;
        }
        .a11y-reset:hover { background: #fef2f2; border-color: #fca5a5; color: #dc2626; }
        .dark .a11y-reset { border-color: #475569; color: #94a3b8; }
        .dark .a11y-reset:hover { background: #450a0a; }

        /* Scrollbar inside panel */
        #a11y-panel::-webkit-scrollbar { width: 4px; }
        #a11y-panel::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
    </style>

    {{-- Reading Mask Overlay --}}
    <div id="a11y-reading-mask" aria-hidden="true"></div>

    {{-- Widget HTML --}}
    <div id="a11y-widget" role="region" aria-label="Widget Aksesibilitas">
        {{-- FAB Button --}}
        <button id="a11y-fab"
                aria-label="Buka panel aksesibilitas"
                aria-expanded="false"
                aria-controls="a11y-panel"
                onclick="a11yWidget.toggle()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="22" height="22">
                <path d="M12 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm-1 5h2l1.5 4.5L17 13l-1 1-2.5-1.5V19h-2v-6.5L9 14l-1-1 2.5-1.5L11 7z"/>
            </svg>
        </button>

        {{-- Panel --}}
        <div id="a11y-panel" role="dialog" aria-label="Fitur Aksesibilitas" aria-modal="false">

            {{-- Header --}}
            <div class="a11y-header">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-bold text-base flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 2a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm-1 5h2l1.5 4.5L17 13l-1 1-2.5-1.5V19h-2v-6.5L9 14l-1-1 2.5-1.5L11 7z"/></svg>
                            Aksesibilitas
                        </div>
                        <div class="text-emerald-100 text-xs mt-0.5">Sesuaikan tampilan & baca</div>
                    </div>
                    <button onclick="a11yWidget.toggle()" class="text-white/70 hover:text-white transition" aria-label="Tutup panel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            {{-- ── SECTION: Text-to-Speech ── --}}
            <div style="padding: 0.75rem 1.25rem 0.5rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #059669;">
                <i class="fas fa-volume-up mr-1 text-emerald-600"></i> Pembaca Teks (TTS)
            </div>

            <div class="a11y-row" style="flex-direction: column; align-items: flex-start; gap: 0.75rem;">
                {{-- TTS Controls --}}
                <div style="width: 100%; display: flex; align-items: center; justify-content: space-between;">
                    <div class="a11y-tts-controls">
                        {{-- Play/Pause --}}
                        <button id="a11y-tts-play" class="a11y-tts-btn play" onclick="a11yWidget.toggleSpeak()" aria-label="Putar / Jeda pembacaan" title="Putar / Jeda">
                            <i class="fas fa-play" id="a11y-play-icon"></i>
                        </button>
                        {{-- Stop --}}
                        <button class="a11y-tts-btn stop" onclick="a11yWidget.stopSpeak()" aria-label="Hentikan pembacaan" title="Hentikan">
                            <i class="fas fa-stop"></i>
                        </button>
                        {{-- Wave indicator --}}
                        <div id="a11y-wave" style="display:none; align-items:center; gap:2px; margin-left: 4px;">
                            <span class="a11y-wave-bar"></span>
                            <span class="a11y-wave-bar"></span>
                            <span class="a11y-wave-bar"></span>
                            <span class="a11y-wave-bar"></span>
                        </div>
                    </div>
                    {{-- Speed --}}
                    <div class="a11y-speed">
                        <span style="font-size:0.7rem; color:#94a3b8; font-weight:600;">Kec.</span>
                        <button class="a11y-speed-btn" onclick="a11yWidget.changeRate(-0.25)" title="Lebih lambat">−</button>
                        <span id="a11y-rate-val" style="font-size:0.75rem; font-weight:700; color:#059669; min-width:2rem; text-align:center;">1×</span>
                        <button class="a11y-speed-btn" onclick="a11yWidget.changeRate(0.25)" title="Lebih cepat">+</button>
                    </div>
                </div>
                {{-- Page to read selector --}}
                <div style="width:100%; display:flex; align-items:center; gap:0.5rem;">
                    <span style="font-size:0.72rem; color:#94a3b8; white-space:nowrap;">Baca:</span>
                    <select id="a11y-read-scope" style="flex:1; font-size:0.75rem; border:1px solid #e2e8f0; border-radius:6px; padding:3px 6px; background: white; color:#374151;" onchange="a11yWidget.stopSpeak()">
                        <option value="auto">Otomatis (Konten Utama)</option>
                        <option value="title">Judul Saja</option>
                        <option value="page">Seluruh Halaman</option>
                    </select>
                </div>
            </div>

            {{-- Progress bar --}}
            <div id="a11y-tts-progress"><div id="a11y-tts-bar"></div></div>

            {{-- ── SECTION: Tampilan ── --}}
            <div style="padding: 0.75rem 1.25rem 0.5rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #059669;">
                <i class="fas fa-palette mr-1 text-emerald-600"></i> Tampilan
            </div>

            {{-- Font Size --}}
            <div class="a11y-row">
                <div class="a11y-label">
                    <div class="icon" style="background:#ede9fe;"><i class="fas fa-font text-purple-600"></i></div>
                    Ukuran Font
                </div>
                <div class="a11y-fs-group">
                    <button class="a11y-fs-btn" onclick="a11yWidget.changeFontSize(-1)" id="a11y-fs-dec" aria-label="Perkecil font" title="Perkecil">A−</button>
                    <span id="a11y-fs-value">100%</span>
                    <button class="a11y-fs-btn" onclick="a11yWidget.changeFontSize(1)" id="a11y-fs-inc" aria-label="Perbesar font" title="Perbesar">A+</button>
                </div>
            </div>

            {{-- High Contrast --}}
            <div class="a11y-row">
                <div class="a11y-label">
                    <div class="icon" style="background:#fef9c3;"><i class="fas fa-moon text-yellow-600"></i></div>
                    Kontras Tinggi
                </div>
                <label class="a11y-toggle" aria-label="Toggle kontras tinggi">
                    <input type="checkbox" id="a11y-contrast-toggle" onchange="a11yWidget.toggleFeature('highContrast')">
                    <span class="a11y-slider"></span>
                </label>
            </div>

            {{-- Dyslexia Font --}}
            <div class="a11y-row">
                <div class="a11y-label">
                    <div class="icon" style="background:#dcfce7;"><i class="fas fa-book-open text-green-600"></i></div>
                    Font Disleksia
                </div>
                <label class="a11y-toggle" aria-label="Toggle font disleksia">
                    <input type="checkbox" id="a11y-dyslexia-toggle" onchange="a11yWidget.toggleFeature('dyslexiaFont')">
                    <span class="a11y-slider"></span>
                </label>
            </div>

            {{-- ── SECTION: Navigasi ── --}}
            <div style="padding: 0.75rem 1.25rem 0.5rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #059669;">
                <i class="fas fa-compass mr-1 text-emerald-600"></i> Navigasi & Fokus
            </div>

            {{-- Reading Mask --}}
            <div class="a11y-row">
                <div class="a11y-label">
                    <div class="icon" style="background:#fde68a;"><i class="fas fa-bullseye text-orange-600"></i></div>
                    Panduan Baca
                </div>
                <label class="a11y-toggle" aria-label="Toggle panduan baca">
                    <input type="checkbox" id="a11y-mask-toggle" onchange="a11yWidget.toggleFeature('readingMask')">
                    <span class="a11y-slider"></span>
                </label>
            </div>

            {{-- Highlight Links --}}
            <div class="a11y-row">
                <div class="a11y-label">
                    <div class="icon" style="background:#ecfdf5;"><i class="fas fa-link text-emerald-600"></i></div>
                    Sorot Tautan
                </div>
                <label class="a11y-toggle" aria-label="Toggle sorot tautan">
                    <input type="checkbox" id="a11y-links-toggle" onchange="a11yWidget.toggleFeature('highlightLinks')">
                    <span class="a11y-slider"></span>
                </label>
            </div>

            {{-- Pause Animations --}}
            <div class="a11y-row">
                <div class="a11y-label">
                    <div class="icon" style="background:#fee2e2;"><i class="fas fa-pause text-red-600"></i></div>
                    Hentikan Animasi
                </div>
                <label class="a11y-toggle" aria-label="Toggle hentikan animasi">
                    <input type="checkbox" id="a11y-anim-toggle" onchange="a11yWidget.toggleFeature('pauseAnimations')">
                    <span class="a11y-slider"></span>
                </label>
            </div>

            {{-- Reset --}}
            <button class="a11y-reset" onclick="a11yWidget.resetAll()" aria-label="Reset semua pengaturan aksesibilitas">
                <i class="fas fa-undo-alt mr-1"></i> Reset Semua Pengaturan
            </button>

            {{-- Info --}}
            <div style="padding: 0.5rem 1.25rem 1rem; font-size: 0.68rem; color: #94a3b8; text-align:center; line-height:1.5;">
                Pengaturan tersimpan otomatis di browser ini.
            </div>

        </div>{{-- /panel --}}
    </div>{{-- /widget --}}

    {{-- ── Widget Script ── --}}
    <script>
    const a11yWidget = (() => {
        // State
        const state = {
            isOpen:          false,
            isSpeaking:      false,
            isPaused:        false,
            speechRate:      1.0,
            fontSize:        0,      // Steps: each = 10% change; range -2 to +5
            highContrast:    false,
            dyslexiaFont:    false,
            readingMask:     false,
            highlightLinks:  false,
            pauseAnimations: false,
        };

        /* ── Helpers ── */
        function $(id) { return document.getElementById(id); }

        function getReadableText() {
            const scope = $('a11y-read-scope')?.value || 'auto';
            if (scope === 'title') {
                return document.querySelector('h1')?.innerText || document.title;
            }
            if (scope === 'page') {
                return document.querySelector('main')?.innerText || document.body.innerText;
            }
            // Auto: prioritize article content
            const selectors = ['.prose', 'article .content', '[data-a11y-readable]', 'article', 'main .max-w-4xl', 'main .max-w-3xl'];
            let el = null;
            for (const sel of selectors) {
                el = document.querySelector(sel);
                if (el) break;
            }
            const h1 = document.querySelector('h1');
            const prefix = h1 ? h1.innerText + '. ' : '';
            return prefix + (el ? el.innerText : (document.querySelector('main')?.innerText || document.title));
        }

        function updatePlayIcon() {
            const icon = $('a11y-play-icon');
            if (!icon) return;
            if (state.isSpeaking && !state.isPaused) {
                icon.className = 'fas fa-pause';
            } else {
                icon.className = 'fas fa-play';
            }
            // Wave indicator
            const wave = $('a11y-wave');
            if (wave) wave.style.display = (state.isSpeaking && !state.isPaused) ? 'flex' : 'none';
        }

        function savePrefs() {
            const { isSpeaking, isPaused, isOpen, ...toSave } = state;
            localStorage.setItem('bem-a11y', JSON.stringify(toSave));
        }

        function loadPrefs() {
            try {
                const saved = JSON.parse(localStorage.getItem('bem-a11y') || '{}');
                Object.assign(state, saved);
            } catch(e) {}
        }

        function applyAll() {
            // Font size
            document.documentElement.style.fontSize = (100 + state.fontSize * 10) + '%';
            const pct = (100 + state.fontSize * 10) + '%';
            if ($('a11y-fs-value')) $('a11y-fs-value').textContent = pct;
            if ($('a11y-fs-dec'))  $('a11y-fs-dec').disabled  = state.fontSize <= -2;
            if ($('a11y-fs-inc'))  $('a11y-fs-inc').disabled  = state.fontSize >= 5;

            // Classes
            document.documentElement.classList.toggle('high-contrast',   state.highContrast);
            document.documentElement.classList.toggle('dyslexia-font',   state.dyslexiaFont);
            document.documentElement.classList.toggle('reading-mask',    state.readingMask);
            document.documentElement.classList.toggle('highlight-links', state.highlightLinks);
            document.documentElement.classList.toggle('pause-animations',state.pauseAnimations);

            // Sync checkboxes
            const map = {
                'a11y-contrast-toggle': 'highContrast',
                'a11y-dyslexia-toggle': 'dyslexiaFont',
                'a11y-mask-toggle':     'readingMask',
                'a11y-links-toggle':    'highlightLinks',
                'a11y-anim-toggle':     'pauseAnimations',
            };
            Object.entries(map).forEach(([id, key]) => {
                const el = $(id);
                if (el) el.checked = state[key];
            });

            // Speech rate
            if ($('a11y-rate-val')) $('a11y-rate-val').textContent = state.speechRate.toFixed(2).replace('.00', '').replace(/\.?0+$/, '') + '×';
        }

        /* ── Public API ── */
        return {
            init() {
                loadPrefs();
                applyAll();

                // Reading mask: follow mouse
                document.addEventListener('mousemove', (e) => {
                    if (state.readingMask) {
                        const mask = $('a11y-reading-mask');
                        if (mask) mask.style.top = (e.clientY - 30) + 'px';
                    }
                });

                // Close panel on outside click
                document.addEventListener('click', (e) => {
                    const widget = $('a11y-widget');
                    if (state.isOpen && widget && !widget.contains(e.target)) {
                        this.toggle(false);
                    }
                });

                // Stop speech on page change
                window.addEventListener('beforeunload', () => {
                    window.speechSynthesis?.cancel();
                });
            },

            toggle(force) {
                state.isOpen = (force !== undefined) ? force : !state.isOpen;
                const panel = $('a11y-panel');
                const fab   = $('a11y-fab');
                if (panel) panel.classList.toggle('open', state.isOpen);
                if (fab)   fab.classList.toggle('active', state.isOpen);
                if (fab)   fab.setAttribute('aria-expanded', state.isOpen);
            },

            /* ── TTS ── */
            toggleSpeak() {
                if (!window.speechSynthesis) {
                    alert('Browser Anda tidak mendukung Text-to-Speech.');
                    return;
                }
                if (state.isSpeaking && !state.isPaused) {
                    // Pause
                    window.speechSynthesis.pause();
                    state.isPaused = true;
                    updatePlayIcon();
                    return;
                }
                if (state.isPaused) {
                    // Resume
                    window.speechSynthesis.resume();
                    state.isPaused = false;
                    updatePlayIcon();
                    return;
                }
                // Start fresh
                window.speechSynthesis.cancel();
                const text = getReadableText();
                if (!text) return;

                const utterance = new SpeechSynthesisUtterance(text);

                // Try Indonesian voice first, then fallback
                const voices = window.speechSynthesis.getVoices();
                const idVoice = voices.find(v => v.lang.startsWith('id')) ||
                                voices.find(v => v.lang.startsWith('ms')) ||
                                voices.find(v => v.default);
                if (idVoice) utterance.voice = idVoice;

                utterance.lang  = 'id-ID';
                utterance.rate  = state.speechRate;
                utterance.pitch = 1.0;

                utterance.onstart = () => {
                    state.isSpeaking = true;
                    state.isPaused   = false;
                    updatePlayIcon();
                    const prog = $('a11y-tts-progress');
                    if (prog) prog.style.display = 'block';
                    // Animate bar (estimate)
                    const bar = $('a11y-tts-bar');
                    if (bar) {
                        const duration = (text.length / 15) / state.speechRate * 1000;
                        bar.style.transition = `width ${duration}ms linear`;
                        setTimeout(() => bar.style.width = '100%', 50);
                    }
                };
                utterance.onend = utterance.onerror = () => {
                    state.isSpeaking = false;
                    state.isPaused   = false;
                    updatePlayIcon();
                    const prog = $('a11y-tts-progress');
                    if (prog) prog.style.display = 'none';
                    const bar = $('a11y-tts-bar');
                    if (bar) { bar.style.transition = 'none'; bar.style.width = '0%'; }
                };

                window.speechSynthesis.speak(utterance);
            },

            stopSpeak() {
                window.speechSynthesis?.cancel();
                state.isSpeaking = false;
                state.isPaused   = false;
                updatePlayIcon();
                const prog = $('a11y-tts-progress');
                if (prog) prog.style.display = 'none';
                const bar = $('a11y-tts-bar');
                if (bar) { bar.style.transition = 'none'; bar.style.width = '0%'; }
            },

            changeRate(delta) {
                state.speechRate = Math.min(2.0, Math.max(0.5, +(state.speechRate + delta).toFixed(2)));
                if ($('a11y-rate-val')) $('a11y-rate-val').textContent = state.speechRate + '×';
                savePrefs();
                // If currently speaking, restart with new rate
                if (state.isSpeaking) {
                    this.stopSpeak();
                    setTimeout(() => this.toggleSpeak(), 100);
                }
            },

            /* ── Visual ── */
            changeFontSize(delta) {
                state.fontSize = Math.min(5, Math.max(-2, state.fontSize + delta));
                applyAll();
                savePrefs();
            },

            toggleFeature(key) {
                state[key] = !state[key];
                applyAll();
                savePrefs();
            },

            resetAll() {
                this.stopSpeak();
                state.fontSize        = 0;
                state.highContrast    = false;
                state.dyslexiaFont    = false;
                state.readingMask     = false;
                state.highlightLinks  = false;
                state.pauseAnimations = false;
                state.speechRate      = 1.0;
                applyAll();
                savePrefs();
            },
        };
    })();

    // Init when DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => a11yWidget.init());
    } else {
        a11yWidget.init();
    }

    // Voices are loaded async in some browsers
    window.speechSynthesis && window.speechSynthesis.addEventListener('voiceschanged', () => {});
    </script>


</body>
</html>
