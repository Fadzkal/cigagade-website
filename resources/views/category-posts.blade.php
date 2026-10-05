<x-public-layout>
    <x-slot name="title">
        Kategori: {{ $category->name }}
    </x-slot>

    <section class="relative bg-gradient-to-br from-emerald-900 via-emerald-800 to-teal-900 py-20 overflow-hidden" style="background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #134e4a 100%);">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-500 rounded-full filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-teal-500 rounded-full filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <nav class="flex justify-center mb-6 scroll-reveal">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ url('/') }}" class="text-emerald-200 hover:text-white transition-colors duration-200">
                            <i class="fas fa-home"></i> <span data-t="beranda">Beranda</span>
                        </a>
                    </li>
                    <li class="text-emerald-300">/</li>
                    <li>
                        <a href="{{ route('berita.index') }}" class="text-emerald-200 hover:text-white transition-colors duration-200" data-t="berita">
                            Berita
                        </a>
                    </li>
                    <li class="text-emerald-300">/</li>
                    <li class="text-white font-semibold">{{ $category->name }}</li>
                </ol>
            </nav>

            <div class="mb-6 scroll-reveal animation-delay-200">
                <span class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 backdrop-blur-sm rounded-full text-white border border-white border-opacity-30">
                    <i class="fas fa-tag mr-2 text-amber-300"></i>
                    <span data-t="categoryLabel">Kategori</span>
                </span>
            </div>
            <h1 class="text-5xl md:text-6xl font-serif font-bold text-white mb-6 scroll-reveal animation-delay-400">
                {{ $category->name }}
            </h1>
            @if($category->description)
                <p class="text-xl text-emerald-100 max-w-3xl mx-auto mb-8 scroll-reveal animation-delay-600">
                    {{ $category->description }}
                </p>
            @endif
            <div class="w-32 h-1 bg-gradient-to-r from-emerald-400 to-teal-400 mx-auto rounded-full scroll-reveal animation-delay-800"></div>
            <div class="mt-8 scroll-reveal animation-delay-1000">
                <div class="inline-flex items-center space-x-4 bg-white bg-opacity-15 backdrop-blur-sm rounded-2xl px-8 py-4 border border-white border-opacity-20">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">{{ $posts->total() }}</div>
                        <div class="text-sm text-emerald-200" data-t="totalNews">Total Berita</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 0L60 8C120 16 240 32 360 42.7C480 53 600 59 720 58.7C840 59 960 53 1080 48C1200 43 1320 37 1380 34.7L1440 32V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V0Z" class="fill-white dark:fill-[#0f172a]"/>
            </svg>
        </div>
    </section>

    <div class="bg-white dark:bg-gradient-to-b dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-16 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($posts->isEmpty())
                <div class="text-center py-20 scroll-reveal">
                    <div class="inline-flex items-center justify-center w-28 h-28 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 rounded-full mb-8 shadow-sm">
                        <i class="fas fa-newspaper text-5xl"></i>
                    </div>
                    <h3 class="text-3xl font-serif font-bold text-gray-900 dark:text-white mb-4" data-t="noNewsInCat">Belum Ada Berita</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mb-8" data-t="noNewsInCatDesc">Kategori ini belum memiliki berita. Silakan cek kategori lainnya.</p>
                    <a href="{{ route('berita.index') }}" class="inline-flex items-center px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-md">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span data-t="backToAllNews">Kembali ke Semua Berita</span>
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach ($posts as $index => $post)
                        <article class="group bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 flex flex-col h-full hover:shadow-xl transition-all duration-300 scroll-reveal" style="animation-delay: {{ $index * 100 }}ms">
                            <div class="relative overflow-hidden aspect-[4/3]">
                                @if ($post->image)
                                    <img src="{{ asset('storage/'. $post->image) }}" alt="{{ $post->getTitle() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                                @else
                                    <div class="w-full h-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                        <i class="fas fa-image text-4xl text-slate-300 dark:text-slate-600"></i>
                                    </div>
                                @endif
                                
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center px-3 py-1 bg-emerald-600 text-white text-[11px] font-bold uppercase tracking-wider rounded-md shadow-sm">
                                        {{ $post->category->name }}
                                    </span>
                                </div>
                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center px-2.5 py-1 bg-black/60 text-white text-[11px] font-medium rounded-md backdrop-blur-sm">
                                        <i class="far fa-clock mr-1.5 text-emerald-300"></i>
                                        {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-6 flex flex-col flex-grow">
                                <div class="flex items-center justify-between mb-3 text-xs text-slate-500 dark:text-slate-400">
                                    <div class="flex items-center font-medium">
                                        <i class="far fa-user mr-1.5 text-emerald-600"></i>
                                        <span>{{ $post->user->name }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="far fa-calendar mr-1.5"></i>
                                        <span>{{ ($post->published_at ?? $post->created_at)->format('d M Y') }}</span>
                                    </div>
                                </div>
                                
                                <h2 class="text-xl font-serif font-bold text-slate-900 dark:text-white mb-3 line-clamp-2 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-200 leading-snug">
                                    <a href="{{ $post->getShowRoute() }}">{{ $post->getTitle() }}</a>
                                </h2>
                                
                                <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 line-clamp-3 leading-relaxed flex-grow">
                                    {{ $post->getExcerpt() }}
                                </p>
                                
                                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 mt-auto flex items-center justify-between">
                                    <a href="{{ $post->getShowRoute() }}" class="inline-flex items-center text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors uppercase tracking-wider">
                                        <span data-t="readMore">Baca Selengkapnya</span>
                                        <i class="fas fa-arrow-right ml-1.5 text-xs"></i>
                                    </a>
                                    <span class="text-xs text-slate-400 font-medium">
                                        <i class="far fa-eye mr-1"></i>{{ $post->views ?? 0 }}
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
                <div class="text-center mt-12 scroll-reveal">
                    <a href="{{ route('berita.index') }}" class="inline-flex items-center px-8 py-4 bg-gray-100 dark:bg-gradient-to-r dark:from-slate-700 dark:to-slate-800 text-gray-800 dark:text-white font-bold rounded-xl hover:bg-gray-200 dark:hover:from-slate-600 dark:hover:to-slate-700 transition-all duration-300 transform hover:scale-105 shadow-md border border-gray-200 dark:border-slate-600">
                        <i class="fas fa-arrow-left mr-3"></i>
                        <span data-t="allCategories">Lihat Semua Kategori</span>
                    </a>
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
            transform: translateY(40px);
            transition: opacity 0.7s ease-out, transform 0.7s ease-out;
        }

        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Animation Delays */
        .animation-delay-200 { animation-delay: 200ms; }
        .animation-delay-400 { animation-delay: 400ms; }
        .animation-delay-600 { animation-delay: 600ms; }
        .animation-delay-800 { animation-delay: 800ms; }
        .animation-delay-1000 { animation-delay: 1000ms; }

        /* Custom Pagination Styling */
        .pagination {
            @apply flex items-center space-x-2;
        }

        .pagination .page-link {
            @apply px-4 py-2 rounded-lg transition-all duration-300;
            @apply bg-white text-gray-700 border border-gray-200;
            @apply hover:bg-emerald-50 text-emerald-800;
            @apply dark:bg-slate-800 dark:text-white dark:border-slate-700;
            @apply dark:hover:bg-slate-700;
        }

        .pagination .page-item.active .page-link {
            @apply bg-emerald-600 text-white dark:text-white border-emerald-600;
        }

        .pagination .page-item.disabled .page-link {
            @apply opacity-50 cursor-not-allowed;
            @apply bg-gray-100 hover:bg-gray-100;
            @apply dark:bg-slate-800 dark:hover:bg-slate-800;
        }

        html { scroll-behavior: smooth; }

        article:hover { box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08); }
        .dark article:hover { box-shadow: 0 20px 45px rgba(16, 185, 129, 0.15); }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const revealElements = document.querySelectorAll('.scroll-reveal');
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
            revealElements.forEach(element => { revealObserver.observe(element); });
        });
    </script>
</x-public-layout>
