<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23059669'><path d='M12 2L2 9.5V11H4V20H9V14H15V20H20V11H22V9.5L12 2Z'/></svg>">
    <title>{{ config('app.name', 'Desa Cigagade') }} - Panel Administrasi</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Quill.js Rich Text Editor (Free, No API Key) --}}
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

    <style>
        /* Custom Scrollbar untuk Sidebar agar lebih elegan */
        aside::-webkit-scrollbar {
            width: 4px;
        }
        aside::-webkit-scrollbar-track {
            background: transparent;
        }
        aside::-webkit-scrollbar-thumb {
            background-color: #334155;
            border-radius: 10px;
        }
        
        /* Styling tambahan untuk sidebar aktif/hover */
        .sidebar-link {
            transition: all 0.2s ease-in-out;
        }
        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            transform: translateX(4px);
        }
        .sidebar-link[aria-current="page"] {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            font-weight: 600;
            border-left: 3px solid #60a5fa; /* Aksen biru di kiri untuk menu aktif */
        }
        .sidebar-link i {
            width: 1.5rem;
            text-align: center;
            font-size: 1.1rem;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-50 overflow-hidden">

        {{-- ─── SIDEBAR (Solid Dark Color, No Gradient) ─── --}}
        <aside
            class="fixed inset-y-0 left-0 z-30 w-64 h-screen overflow-y-auto transition-transform duration-300 transform bg-[#0f172a] border-r border-slate-800 shadow-2xl lg:translate-x-0 lg:static lg:inset-0 flex-shrink-0"
            :class="{'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen}"
        >
            <div class="flex items-center justify-center h-20 px-6 border-b border-slate-700/50">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 hover:opacity-80 transition-opacity">
                     @if (isset($logoPath) && $logoPath && file_exists(public_path('storage/' . $logoPath)))
                        <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo Desa Cigagade" class="block h-10 w-auto rounded-lg shadow-sm">
                    @else
                        <div class="block h-10 w-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-md border border-emerald-400/30">
                             <i class="fas fa-landmark text-white text-base"></i>
                        </div>
                    @endif
                    <div class="flex flex-col text-left">
                        <span class="text-base font-bold text-white tracking-wide leading-tight">Desa Cigagade</span>
                        <span class="text-[10px] text-emerald-400 font-semibold tracking-wider uppercase">Portal Admin</span>
                    </div>
                </a>
            </div>

            <nav class="mt-4 px-3 space-y-1 pb-8">
                
                {{-- MENU UTAMA --}}
                <div class="px-3 pt-4 pb-2">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Menu Utama</p>
                </div>
                <a href="{{ route('dashboard') }}" aria-current="{{ request()->routeIs('dashboard') ? 'page' : '' }}"
                   class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                    <i class="fas fa-tachometer-alt mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                    <span class="text-sm">Dashboard</span>
                </a>
                <a href="{{ route('profile.edit') }}" aria-current="{{ request()->routeIs('profile.edit') ? 'page' : '' }}"
                   class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                    <i class="fas fa-user-edit mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                    <span class="text-sm">Profile Saya</span>
                </a>

                {{-- BLOK SUPERADMIN --}}
                @can('isSuperAdmin')
                    <div class="px-3 pt-6 pb-2">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Pemerintahan Desa</p>
                    </div>
                    <a href="{{ route('categories.index') }}" aria-current="{{ request()->routeIs('categories.*') ? 'page' : '' }}"
                       class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                        <i class="fas fa-tags mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                        <span class="text-sm">Kategori Informasi</span>
                    </a>
                    <a href="{{ route('galleries.index') }}" aria-current="{{ request()->routeIs('galleries.*') ? 'page' : '' }}"
                       class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                        <i class="fas fa-images mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                        <span class="text-sm">Galeri Kegiatan Desa</span>
                    </a>
                    <a href="{{ route('hero-slides.index') }}" aria-current="{{ request()->routeIs('hero-slides.*') ? 'page' : '' }}"
                       class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                        <i class="fas fa-layer-group mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                        <span class="text-sm">Banner Utama (Hero)</span>
                    </a>
                    <a href="{{ route('running-texts.index') }}" aria-current="{{ request()->routeIs('running-texts.*') ? 'page' : '' }}"
                       class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                        <i class="fas fa-bullhorn mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                        <span class="text-sm">Teks Berjalan (Running Text)</span>
                    </a>
                    <a href="{{ route('landscape-banners.index') }}" aria-current="{{ request()->routeIs('landscape-banners.*') ? 'page' : '' }}"
                       class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                        <i class="fas fa-panorama mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                        <span class="text-sm">Banner Landscape</span>
                    </a>
                     <a href="{{ route('ministries.index') }}" aria-current="{{ request()->routeIs('ministries.*') ? 'page' : '' }}"
                       class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                        <i class="fas fa-users-gear mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                        <span class="text-sm">Perangkat Desa</span>
                    </a>
                     <a href="{{ route('partners.index') }}" aria-current="{{ request()->routeIs('partners.*') ? 'page' : '' }}"
                       class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                        <i class="fas fa-handshake mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                        <span class="text-sm">Mitra & Instansi Terkait</span>
                    </a>
                    <a href="{{ route('settings.index') }}" aria-current="{{ request()->routeIs('settings.*') ? 'page' : '' }}"
                       class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                        <i class="fas fa-cog mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                        <span class="text-sm">Profil & Pengaturan Desa</span>
                    </a>
                @endcan

                {{-- KONTEN PUBLIK --}}
                <div class="px-3 pt-6 pb-2">
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Informasi & Warta</p>
                </div>
                <a href="{{ route('posts.index') }}" aria-current="{{ request()->routeIs('posts.*') ? 'page' : '' }}"
                   class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                    <i class="fas fa-newspaper mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                    <span class="text-sm">Kabar & Berita Desa</span>
                </a>
                <a href="{{ route('prestasi.index') }}" aria-current="{{ request()->routeIs('prestasi.*') ? 'page' : '' }}"
                   class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                    <i class="fas fa-award mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                    <span class="text-sm">Prestasi & Capaian</span>
                </a>
                <a href="{{ route('pengumuman.index') }}" aria-current="{{ request()->routeIs('pengumuman.*') ? 'page' : '' }}"
                   class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                    <i class="fas fa-bullhorn mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                    <span class="text-sm">Pengumuman Warga</span>
                </a>
                <a href="{{ route('bengkel-ilmu.index') }}" aria-current="{{ request()->routeIs('bengkel-ilmu.*') ? 'page' : '' }}"
                   class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                    <i class="fas fa-seedling mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                    <span class="text-sm">Potensi & Literasi Desa</span>
                </a>
                <a href="{{ route('umkm.admin.index') }}" aria-current="{{ request()->routeIs('umkm.admin.*') ? 'page' : '' }}"
                   class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                    <i class="fas fa-store mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                    <span class="text-sm">Produk UMKM Desa</span>
                </a>
                <a href="{{ route('infografis.admin.index') }}" aria-current="{{ request()->routeIs('infografis.admin.*') ? 'page' : '' }}"
                   class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                    <i class="fas fa-chart-pie mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                    <span class="text-sm">Infografis & Data Desa</span>
                </a>
                
                @can('isSuperAdmin')
                <a href="{{ route('media.index') }}" aria-current="{{ request()->routeIs('media.*') ? 'page' : '' }}"
                   class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                    <i class="fas fa-photo-film mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                    <span class="text-sm">Media Library</span>
                </a>
                <a href="{{ route('videos.index') }}" aria-current="{{ request()->routeIs('videos.*') ? 'page' : '' }}"
                   class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                    <i class="fab fa-youtube mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                    <span class="text-sm">Video Cigagade TV</span>
                </a>
                <a href="{{ route('instagram-reels.index') }}" aria-current="{{ request()->routeIs('instagram-reels.*') ? 'page' : '' }}"
                   class="sidebar-link flex items-center px-3 py-2.5 text-slate-300 rounded-xl group">
                    <i class="fab fa-instagram mr-3 text-slate-400 group-hover:text-emerald-400 transition-colors"></i>
                    <span class="text-sm">Reels & Kabar Warga</span>
                </a>
                @endcan

                {{-- LOGOUT --}}
                <div class="mt-8 pt-4 border-t border-slate-700/50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="w-full flex items-center px-3 py-2.5 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-xl transition-all duration-200 group">
                            <i class="fas fa-sign-out-alt mr-3 group-hover:scale-110 transition-transform"></i>
                            <span class="text-sm font-medium">Log Out</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        {{-- Overlay untuk mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-slate-900/60 backdrop-blur-sm transition-opacity lg:hidden" x-cloak></div>

        {{-- ─── KONTEN UTAMA ─── --}}
        <div class="flex flex-col flex-1 overflow-y-auto overflow-x-hidden relative">
            
            {{-- Header --}}
            <header class="sticky top-0 z-10 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                         <div class="flex lg:hidden">
                            <button @click="sidebarOpen = ! sidebarOpen" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': sidebarOpen, 'inline-flex': ! sidebarOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                         <div class="hidden lg:flex flex-1"></div>

                        <div class="flex items-center gap-4">
                            <button class="text-slate-400 hover:text-blue-500 transition-colors">
                                <i class="fas fa-bell"></i>
                            </button>
                             <div class="hidden sm:flex sm:items-center pl-4 border-l border-gray-200 gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                    {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'U' }}
                                </div>
                                <span class="text-sm font-semibold text-slate-700">{{ Auth::check() ? Auth::user()->name : 'User' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Header Halaman Tambahan (opsional) --}}
            @if (isset($header))
                <div class="bg-white border-b border-gray-200 py-5 px-6 sm:px-8 shadow-sm">
                    {{ $header }}
                </div>
            @endif

            {{-- Body Slot --}}
            <main class="flex-grow p-6 sm:p-8 max-w-7xl mx-auto w-full">
                {{ $slot ?? '' }}
            </main>

             <footer class="bg-white border-t border-gray-200 py-5 px-6 text-center text-sm font-medium text-slate-500 mt-auto">
                 © {{ date('Y') }} Pemerintah Desa Cigagade. Hak Cipta Dilindungi.
             </footer>
        </div>
    </div>

    {{-- Script Quill.js yang sudah utuh --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editorContainer = document.getElementById('quill-editor');
            if (editorContainer) {
                var quill = new Quill(editorContainer, {
                    theme: 'snow',
                    placeholder: 'Tulis isi konten di sini...',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, 4, false] }],
                            ['bold', 'italic', 'underline', 'strike', 'blockquote'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            [{ 'align': [] }],
                            ['link', 'image', 'video'],
                            ['clean']
                        ]
                    }
                });

                // Sinkronisasi isi Quill ke input hidden sebelum submit form
                var form = editorContainer.closest('form');
                if (form) {
                    form.addEventListener('submit', function() {
                        var contentInput = document.getElementById('content');
                        if (contentInput) {
                            contentInput.value = quill.root.innerHTML;
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>