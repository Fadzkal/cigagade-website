<x-public-layout>
    <x-slot name="title">
        {{ $post->title }} - Desa Cigagade
    </x-slot>

    <!-- 
        Container Utama: 
        Background putih bersih, antialiased untuk ketajaman font,
        dengan ruang putih (whitespace) yang cukup di bagian atas dan bawah.
    -->
    <div class="bg-white min-h-screen pt-24 pb-20 antialiased selection:bg-blue-100 selection:text-blue-900">
        
        <!-- Wrapper Konten (Lebar dibatasi agar nyaman untuk membaca paragraf) -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- 1. HEADER ARTIKEL -->
            <header class="mb-10 scroll-reveal">
                
                <!-- Breadcrumb Minimalis -->
                <nav class="flex text-sm text-slate-500 mb-6 font-medium">
                    <ol class="flex items-center space-x-2">
                        <li>
                            <a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors" data-t="beranda">Beranda</a>
                        </li>
                        <li><span class="text-slate-300">/</span></li>
                        <li>
                            <a href="{{ route('prestasi-pengumuman') }}" class="hover:text-blue-600 transition-colors" data-t="pusatInformasi">Pusat Informasi</a>
                        </li>
                        <li><span class="text-slate-300">/</span></li>
                        <li class="text-slate-900 truncate max-w-[150px] sm:max-w-[300px]">
                            {{ $post->title }}
                        </li>
                    </ol>
                </nav>

                <!-- Kategori / Label (Aksen Biru untuk Prestasi) -->
                <div class="mb-4">
                    <span class="text-xs font-bold tracking-widest uppercase text-blue-700" data-t="pojokPrestasi">
                        Pojok Prestasi
                    </span>
                </div>

                <!-- Judul Artikel (Ukuran lebih elegan, tidak raksasa) -->
                <h1 class="text-3xl md:text-4xl lg:text-[40px] font-bold text-slate-900 mb-6 leading-tight">
                    {{ $post->title }}
                </h1>

                <!-- Meta Info (Penulis & Tanggal) dengan pemisah garis -->
                <div class="flex items-center text-sm text-slate-500 border-b border-slate-200 pb-8">
                    <div class="flex items-center gap-3 pr-6 border-r border-slate-200">
                        <!-- Inisial Avatar Penulis yang bersih -->
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold border border-slate-200">
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        </div>
                        <span class="font-medium text-slate-900">{{ $post->user->name }}</span>
                    </div>
                    <div class="pl-6 flex items-center gap-2">
                        <i class="far fa-calendar text-slate-400"></i>
                        <span>{{ ($post->published_at ?? $post->created_at)->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
            </header>

            <!-- 2. GAMBAR UTAMA (Lebih rapi dan menyatu dengan konten) -->
            @if ($post->image)
                <div class="mb-12 rounded-xl overflow-hidden bg-slate-50 aspect-video relative scroll-reveal">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                         class="w-full h-full object-cover">
                </div>
            @endif

            <!-- 3. KONTEN ARTIKEL -->
            <article class="scroll-reveal">
                <!-- 
                    Prose di-setting menggunakan warna slate yang mudah dibaca 
                    serta gaya link dan jarak yang proporsional.
                -->
                <div class="prose prose-slate prose-lg max-w-none text-slate-700 leading-relaxed custom-prose">
                    {!! $post->content !!}
                </div>
            </article>

            <!-- 4. NAVIGASI KEMBALI -->
            <div class="mt-16 pt-8 border-t border-slate-200 scroll-reveal">
                <a href="{{ route('prestasi-pengumuman') }}" class="inline-flex items-center text-sm font-bold tracking-widest uppercase text-slate-500 hover:text-blue-600 transition-colors group">
                    <i class="fas fa-arrow-left mr-3 group-hover:-translate-x-1 transition-transform duration-300"></i>
                    <span data-t="backToInfoCenter">Kembali ke Pusat Informasi</span>
                </a>
            </div>

            <!-- 5. PRESTASI/BERITA TERKAIT -->
            @if(isset($relatedPosts) && $relatedPosts->count() > 0)
                <div class="mt-24 scroll-reveal">
                    <div class="mb-8 border-b border-slate-200 pb-4">
                        <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                            <span class="w-1 h-6 bg-blue-600 rounded-full"></span>
                            <span data-t="relatedAchievements">Prestasi Terkait</span>
                        </h2>
                    </div>

                    <div class="flex flex-col">
                        @foreach($relatedPosts as $related)
                            <!-- Menggunakan border-b sebagai pemisah (Bukan Card kotak) -->
                            <a href="{{ route('berita.show', $related->slug) }}" class="group block border-b border-slate-200 py-6 first:pt-0 last:border-0 transition-colors duration-300">
                                <article class="flex flex-col sm:flex-row gap-6 items-start">
                                    
                                    <!-- Thumbnail Image dengan rasio 16:10 -->
                                    <div class="w-full sm:w-56 aspect-[16/10] flex-shrink-0 rounded-xl overflow-hidden relative bg-slate-100">
                                        @if ($related->image)
                                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-105">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="fas fa-image text-slate-300 text-2xl"></i>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-500 ease-out z-10 pointer-events-none"></div>
                                    </div>

                                    <!-- Teks Meta & Judul -->
                                    <div class="flex-grow flex flex-col py-1">
                                        <span class="text-xs font-bold tracking-widest uppercase text-slate-500 mb-2">
                                            {{ $related->category->name ?? 'Prestasi' }}
                                        </span>
                                        <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors duration-300 ease-out line-clamp-2 leading-snug">
                                            {{ $related->title }}
                                        </h3>
                                        <p class="text-sm text-slate-500 font-medium mt-auto">
                                            {{ ($related->published_at ?? $related->created_at)->translatedFormat('d F Y') }}
                                        </p>
                                    </div>
                                </article>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Styling Custom CSS -->
    <style>
        /* Animasi Muncul Halus (Scroll Reveal) */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Penyesuaian Elemen Hasil CKEditor / TinyMCE agar bersih */
        .custom-prose p {
            margin-top: 1.25em;
            margin-bottom: 1.25em;
        }
        .custom-prose a {
            color: #2563eb; /* Blue 600 */
            text-decoration: none;
            border-bottom: 1px solid transparent;
            transition: border-color 0.3s ease;
        }
        .custom-prose a:hover {
            border-bottom-color: #2563eb;
        }
        .custom-prose img {
            border-radius: 0.75rem;
            margin: 2.5em 0;
            width: 100%;
        }
        .custom-prose h2, .custom-prose h3 {
            color: #0f172a; /* Slate 900 */
            font-weight: 700;
            margin-top: 2em;
            margin-bottom: 1em;
        }
    </style>

    <!-- Script Intersection Observer -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const revealElements = document.querySelectorAll('.scroll-reveal');
            
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            revealElements.forEach(element => {
                revealObserver.observe(element);
            });
        });
    </script>
</x-public-layout>