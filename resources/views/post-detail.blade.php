<x-public-layout>
    <x-slot name="title">
        {{ $post->getTitle() }} - Desa Cigagade
    </x-slot>

    <!-- Hero Section -->
    <section class="relative h-screen flex items-center justify-center overflow-hidden">
        @if ($post->image)
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->getTitle() }}"
                     class="w-full h-full object-cover" id="heroImage">
                <div class="absolute inset-0 bg-gradient-to-b from-slate-950/85 via-emerald-950/80 to-slate-950/95"></div>
            </div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-[#052e20] via-[#063828] to-[#0a4633]"></div>
        @endif

        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Breadcrumb -->
            <nav class="flex justify-center mb-6 scroll-reveal">
                <ol class="flex items-center space-x-2 text-sm backdrop-blur-sm bg-white/10 px-6 py-3 rounded-full border border-white/20">
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
                    <li class="text-white font-semibold">{{ Str::limit($post->getTitle(), 30) }}</li>
                </ol>
            </nav>

            <!-- Kategori Badge (Warna Solid) -->
            <div class="mb-6 scroll-reveal animation-delay-200">
                <a href="{{ route('kategori.posts', $post->category->slug) }}" class="inline-flex items-center px-6 py-3 bg-[#111928] text-white font-bold rounded-full hover:bg-[#1f2a40] transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-tag mr-2"></i>
                    {{ $post->category->name }}
                </a>
            </div>

            <!-- Judul Artikel -->
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-8 leading-tight scroll-reveal animation-delay-400">
                {{ $post->getTitle() }}
            </h1>

            <!-- Meta Info -->
            <div class="flex flex-wrap items-center justify-center gap-6 text-emerald-100 scroll-reveal animation-delay-600">
                <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm px-5 py-3 rounded-full border border-white/20">
                    <!-- Avatar Penulis (Warna Solid) -->
                    <div class="w-10 h-10 bg-[#111928] rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-bold">
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="text-left">
                        <p class="text-xs text-emerald-200" data-t="authorLabel">Penulis</p>
                        <p class="font-semibold text-white">{{ $post->user->name }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2 bg-white/10 backdrop-blur-sm px-5 py-3 rounded-full border border-white/20">
                    <i class="far fa-calendar text-emerald-300"></i>
                    <span class="font-semibold">{{ ($post->published_at ?? $post->created_at)->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2 z-20 animate-bounce">
            <div class="text-white text-center">
                <i class="fas fa-chevron-down text-2xl mb-1"></i>
                <p class="text-sm font-light tracking-wider">Scroll</p>
            </div>
        </div>

        <!-- Bottom Wave/SVG -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full block">
                <path d="M0 0L60 8C120 16 240 32 360 42.7C480 53 600 59 720 58.7C840 59 960 53 1080 48C1200 43 1320 37 1380 34.7L1440 32V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V0Z" class="fill-white"/>
            </svg>
        </div>
    </section>

    <!-- Konten Artikel -->
    <div class="bg-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <article class="scroll-reveal">
                
                @if ($post->image)
                    <div class="mb-10 rounded-2xl overflow-hidden">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->getTitle() }}"
                             class="w-full h-auto max-h-[500px] object-cover">
                    </div>
                @endif

                <!-- Isi Konten - Tanpa Card/Shadow -->
                <div class="prose prose-lg max-w-none">
                    <div class="text-gray-700 text-lg leading-loose space-y-6">
                        {!! $post->getContent() !!}
                    </div>
                </div>

                <div class="my-12 border-t border-gray-200"></div>

                <!-- Tags & Kategori (Warna Solid) -->
                <div class="scroll-reveal">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-tags mr-3 text-gray-700"></i>
                        <span data-t="articleCategory">Kategori Artikel</span>
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('kategori.posts', $post->category->slug) }}"
                           class="inline-flex items-center px-6 py-2.5 bg-[#111928] text-white font-semibold rounded-full hover:bg-[#1f2a40] transition-all duration-300">
                            <i class="fas fa-folder mr-2"></i>
                            {{ $post->category->name }}
                        </a>
                    </div>
                </div>

                <div class="my-12 border-t border-gray-200"></div>

                <!-- Tombol Navigasi -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 scroll-reveal">
                    <a href="{{ route('berita.index') }}"
                       class="inline-flex items-center px-8 py-4 bg-gray-50 text-gray-800 font-semibold rounded-xl hover:bg-gray-100 transition-all duration-300 border border-gray-200 group w-full sm:w-auto justify-center">
                        <i class="fas fa-arrow-left mr-3 group-hover:-translate-x-1 transition-transform duration-300"></i>
                        <span data-t="backToNews">Kembali ke Berita</span>
                    </a>

                    <!-- Tombol Ke Beranda (Warna Solid) -->
                    <a href="{{ url('/') }}"
                       class="inline-flex items-center px-8 py-4 bg-[#111928] text-white font-semibold rounded-xl hover:bg-[#1f2a40] transition-all duration-300 w-full sm:w-auto justify-center">
                        <i class="fas fa-home mr-3"></i>
                        <span data-t="backToHome2">Ke Beranda</span>
                    </a>
                </div>
            </article>

            <!-- Berita Terkait -->
            <div class="mt-20 scroll-reveal">
                <div class="mb-8 border-b border-gray-200 pb-4">
                    <h2 class="text-3xl font-bold text-gray-900">
                        <span data-t="relatedNews">Berita Terkait</span>
                    </h2>
                </div>

                @if(isset($relatedPosts) && $relatedPosts->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($relatedPosts as $related)
                            <article class="flex flex-col sm:flex-row gap-4 group">
                                <div class="w-full sm:w-2/5 h-40 flex-shrink-0 rounded-lg overflow-hidden relative">
                                    @if ($related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->getTitle() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow flex flex-col justify-center">
                                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                                        {{ $related->category->name ?? 'BERITA' }}
                                    </span>
                                    <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-emerald-600 transition-colors line-clamp-2">
                                        <a href="{{ $related->getShowRoute() }}">{{ $related->getTitle() }}</a>
                                    </h3>
                                    <div class="flex items-center text-sm text-gray-500 gap-4 mt-auto">
                                        <span>{{ ($related->published_at ?? $related->created_at)->format('d F Y') }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                                @else
                    <p class="text-gray-500 text-center" data-t="noRelated">Belum ada berita terkait lainnya.</p>
                @endif
            </div>

        </div>
    </div>

    <!-- Styling Clean -->
    <style>
        /* Scroll Reveal Animation */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
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

        /* Clean Prose Styling - Flat and Neat */
        .prose { color: #374151; }
        .prose p, .prose ul, .prose ol, .prose li, .prose blockquote {
             color: #4b5563;
        }
        .prose strong {
             color: #111827;
        }
        .prose a {
             color: #2563eb;
             text-decoration: none;
             font-weight: 500;
        }
         .prose a:hover {
             color: #1d4ed8;
             text-decoration: underline;
         }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
             color: #111827;
             font-weight: 700;
             margin-top: 2em;
             margin-bottom: 1em;
        }
        /* Styling gambar di dalam konten */
        .prose img {
             border-radius: 0.5rem;
             margin-top: 2em;
             margin-bottom: 2em;
             max-width: 100%;
             height: auto;
        }

        /* Smooth Scroll */
        html { scroll-behavior: smooth; }

        /* Parallax Optimization */
        #heroImage { will-change: transform; }
    </style>

    <!-- Script Clean -->
    <script>
        // Set alternate URLs for language switching based on this specific post
        window.alternateLangUrl = {
            'id': '{{ route('berita.show', $post->slug) }}',
            'en': '{{ !empty($post->slug_en) ? route('berita.show.en', $post->slug_en) : route('berita.show', $post->slug) }}'
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer untuk animasi scroll
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

            // Efek Parallax untuk Hero Image
            const heroImage = document.getElementById('heroImage');
            if (heroImage) {
                window.addEventListener('scroll', () => {
                    const scrolled = window.scrollY;
                    const rate = scrolled * 0.3; // Lebih smooth
                    heroImage.style.transform = `translate3d(0, ${rate}px, 0)`;
                });
            }
        });
    </script>
</x-public-layout>