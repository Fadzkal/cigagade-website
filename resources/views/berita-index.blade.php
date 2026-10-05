<x-public-layout>
    <x-slot name="title">
        Kabar Desa Terbaru - Desa Cigagade
    </x-slot>

    <section class="relative bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-900 py-24 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-500 rounded-full filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-teal-500 rounded-full filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-6 scroll-reveal">
                <span class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-white border border-white border-opacity-30">
                    <i class="fas fa-newspaper mr-2"></i>
                    <span data-t="newsPortal">Portal Kabar Desa</span>
                </span>
            </div>
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 scroll-reveal animation-delay-200" data-t="latestNews">
                Kabar Desa Terbaru
            </h1>
            <p class="text-xl md:text-2xl text-emerald-100 max-w-3xl mx-auto mb-8 scroll-reveal animation-delay-400" data-t="newsSubtitle">
                Informasi dan update terkini seputar pembangunan dan kegiatan warga Desa Cigagade
            </p>
            <div class="w-32 h-1 bg-gradient-to-r from-emerald-400 to-teal-400 mx-auto rounded-full scroll-reveal animation-delay-600"></div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 0L60 8C120 16 240 32 360 42.7C480 53 600 59 720 58.7C840 59 960 53 1080 48C1200 43 1320 37 1380 34.7L1440 32V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V0Z" class="fill-white dark:fill-[#0f172a]"/>
            </svg>
        </div>
    </section>

    <div class="bg-white dark:bg-gradient-to-b dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-20 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($posts->isEmpty())
                <div class="text-center py-20 scroll-reveal">
                    <div class="inline-flex items-center justify-center w-28 h-28 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 rounded-full mb-8 shadow-sm">
                        <i class="fas fa-newspaper text-5xl"></i>
                    </div>
                    <h3 class="text-3xl font-serif font-bold text-gray-900 dark:text-white mb-4" data-t="noNews">Belum Ada Berita</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-base mb-8 max-w-md mx-auto" data-t="noNewsDesc">
                        Saat ini belum ada berita yang dipublikasikan. Silakan periksa kembali nanti.
                    </p>
                    <a href="{{ url('/') }}" class="inline-flex items-center px-7 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-all shadow-sm">
                        <i class="fas fa-home mr-2.5"></i>
                        <span data-t="backToHome">Kembali ke Beranda</span>
                    </a>
                </div>
            @else
                <div class="mb-12 scroll-reveal">
                    <div class="flex flex-col md:flex-row justify-between items-center bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700">
                        <div class="mb-4 md:mb-0">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white" data-t="filter">Filter</h3>
                        </div>
                        <form action="{{ route('berita.index') }}" method="GET" class="w-full md:w-auto flex flex-col md:flex-row gap-4">
                            <!-- Search -->
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fas fa-search text-gray-400"></i>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    id="search-input"
                                    class="pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 w-full md:w-64"
                                    oninput="clearTimeout(this.timer); this.timer = setTimeout(() => { this.form.submit(); }, 600);"
                                    @if(request()->has('search')) autofocus onfocus="var val=this.value; this.value=''; this.value=val;" @endif>
                            </div>
                            <!-- Month -->
                            <div class="relative">
                                <select name="month" class="pl-4 pr-8 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 w-full md:w-auto appearance-none" onchange="this.form.submit()">
                                    <option value="" data-t="month">Bulan</option>
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Year -->
                            <div class="relative">
                                <select name="year" class="pl-4 pr-8 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 w-full md:w-auto appearance-none" onchange="this.form.submit()">
                                    <option value="" data-t="year">Tahun</option>
                                    @foreach(range(date('Y'), date('Y') - 5) as $y)
                                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Submit Button for search if needed -->
                            <button type="submit" class="hidden" data-t="filter">Filter</button>
                        </form>
                    </div>
                </div>



                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach ($posts as $index => $post)
                        <article class="group bg-white dark:bg-slate-900 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl border border-gray-100 dark:border-slate-800 flex flex-col h-full scroll-reveal" style="animation-delay: {{ $index * 100 }}ms">
                            <div class="relative overflow-hidden h-56">
                                @if ($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                                @else
                                    <div class="w-full h-full bg-gray-100 dark:bg-slate-800 flex items-center justify-center">
                                        <div class="text-center">
                                            <i class="fas fa-image text-4xl text-gray-300 dark:text-gray-600 mb-2"></i>
                                            <span class="text-gray-400 text-xs block" data-t="noImageLabel">Tidak ada gambar</span>
                                        </div>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-300"></div>
                            </div>
                            
                            <div class="p-6 flex flex-col flex-grow">
                                @if($post->published_at ?? $post->created_at)
                                    <span class="text-sm text-gray-500 dark:text-gray-400 mb-2 font-medium">
                                        {{ ($post->published_at ?? $post->created_at)->format('d M Y') }}
                                    </span>
                                @endif
                                
                                <h2 class="text-lg font-serif font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-200">
                                    <a href="{{ $post->getShowRoute() }}">
                                        {{ $post->getTitle() }}
                                    </a>
                                </h2>
                                
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 line-clamp-3 leading-relaxed flex-grow">
                                    {{ $post->getExcerpt() }}
                                </p>
                                
                                <div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-gray-100 dark:border-slate-800">
                                    <span class="inline-flex items-center px-3 py-1 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 text-xs font-medium rounded-full hover:border-emerald-500 hover:text-emerald-600 transition-colors cursor-default">
                                        {{ $post->category->name }}
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="scroll-reveal">
                    <div class="flex justify-center">
                        {{ $posts->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Line Clamp */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Scroll Reveal Animation */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Animation Delays */
        .animation-delay-200 { animation-delay: 200ms; }
        .animation-delay-400 { animation-delay: 400ms; }
        .animation-delay-600 { animation-delay: 600ms; }

        /* MODIFIKASI: Custom Pagination Styling untuk Light/Dark */
        nav[role="navigation"] {
            @apply flex justify-center;
        }

        .pagination {
            @apply flex items-center space-x-2;
        }

        .pagination .page-link {
            /* Style dasar untuk light & dark */
            @apply px-5 py-3 rounded-lg transition-all duration-300 font-semibold;

            /* Light mode */
            @apply bg-white text-gray-700 border border-gray-200;

            /* Light mode hover */
            @apply hover:bg-emerald-50 text-emerald-800;

            /* Dark mode */
            @apply dark:bg-slate-800 dark:text-white dark:border-slate-700;

            /* Dark mode hover */
            @apply dark:hover:bg-slate-700;
        }

        .pagination .page-item.active .page-link {
             /* Style Active (sama untuk light/dark) */
            @apply bg-emerald-600 text-white dark:text-white border-emerald-600 shadow-sm;
        }

        .pagination .page-item.disabled .page-link {
            /* Style Disabled */
            @apply opacity-50 cursor-not-allowed;

            /* Light mode disabled */
            @apply bg-gray-100 hover:bg-gray-100;

            /* Dark mode disabled */
            @apply dark:bg-slate-800 dark:hover:bg-slate-800;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Hover Glow Effect */
        article:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        }
        .dark article:hover {
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.15);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for Scroll Reveal
            const revealElements = document.querySelectorAll('.scroll-reveal');

            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            revealElements.forEach(element => {
                revealObserver.observe(element);
            });

            // Update search placeholder on language change
            const searchInput = document.getElementById('search-input');
            function updateSearchPlaceholder(lang) {
                if (searchInput) searchInput.placeholder = lang === 'en' ? 'Search...' : 'Cari...';
            }
            updateSearchPlaceholder(window.bemCurrentLang || 'id');
            window.addEventListener('langChanged', function(e) {
                updateSearchPlaceholder(e.detail.lang);
            });
        });
    </script>

    </x-public-layout>
