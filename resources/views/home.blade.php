<x-public-layout>
    <x-slot name="title">
        {{ __('home.page_title') }}
    </x-slot>
    <x-slot name="noPadding">1</x-slot>

    <!-- Hero Section -->
    @if(isset($heroSlides) && $heroSlides->isNotEmpty())
    <style>
        /* Force hero splide to be truly full screen */
        #hero-slider {
            position: relative;
            width: 100vw;
            height: 100vh;
            height: 100dvh;
            overflow: hidden;
        }
        #hero-slider .splide__track {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        #hero-slider .splide__list {
            width: 100%;
            height: 100%;
        }
        #hero-slider .splide__slide {
            width: 100vw !important;
            height: 100%;
            overflow: hidden;
        }
        /* Override Splide default arrows position */
        #hero-slider .splide__arrow {
            display: none;
        }
    </style>
    <section id="hero-slider" class="splide" data-options='{"type":"loop","autoplay":false,"arrows":false,"pagination":false,"speed":800,"easing":"cubic-bezier(0.25, 1, 0.5, 1)"}'>
        <div class="splide__track h-full">
            <ul class="splide__list h-full">
                @foreach($heroSlides as $slide)
                <li class="splide__slide relative">
                    
                    <!-- Background -->
                    @if($slide->type === 'youtube' && $slide->embed_url)
                        <div class="absolute inset-0 z-0 bg-black pointer-events-none">
                            <iframe class="absolute top-1/2 left-1/2 w-[150vw] h-[150vh] -translate-x-1/2 -translate-y-1/2 opacity-70"
                                    src="{{ $slide->embed_url }}"
                                    title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                            </iframe>
                        </div>
                    @else
                        @php
                            $bgImage = null;
                            if ($slide->image) {
                                $bgImage = asset('storage/' . $slide->image);
                            } elseif ($slide->post && $slide->post->image) {
                                $bgImage = asset('storage/' . $slide->post->image);
                            } else {
                                $bgImage = 'https://ui-avatars.com/api/?name=Desa+Cigagade&size=1024&background=059669&color=fff';
                            }
                        @endphp
                        <div class="absolute inset-0 z-0">
                            <img src="{{ $bgImage }}" alt="Hero Image" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <!-- Gradient Overlay (Dark left to transparent right) -->
                    <div class="absolute inset-0 z-10 bg-gradient-to-r from-black/90 via-black/50 to-transparent"></div>

                    <!-- Content -->
                    <div class="relative z-20 h-full flex flex-col justify-end pb-24 pt-28 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                        <div class="max-w-3xl animate-fade-in-up">
                            
                            <!-- Tag -->
                            @if($slide->type === 'post' && $slide->post)
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-600 text-white text-xs font-bold uppercase tracking-wider rounded-sm mb-4">
                                    <i class="fas fa-newspaper"></i> <span data-t="home.hero_tag_berita"></span>
                                </div>
                            @elseif($slide->type === 'youtube')
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-red-600 text-white text-xs font-bold uppercase tracking-wider rounded-sm mb-4">
                                    <i class="fab fa-youtube"></i> Video
                                </div>
                            @endif

                            <!-- Title -->
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 text-white leading-tight">
                                {{ $slide->type === 'post' && $slide->post ? ($slide->title ?? $slide->post->getTitle()) : $slide->title }}
                            </h1>
                            
                            <!-- Meta/Date -->
                            @if($slide->type === 'post' && $slide->post)
                                <div class="flex items-center gap-2 text-gray-300 text-sm mb-8">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>{{ ($slide->post->published_at ?? $slide->post->created_at)->translatedFormat('d F Y') }}</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-gray-300 text-sm mb-8">
                                    <i class="far fa-clock"></i>
                                    <span>{{ $slide->updated_at->translatedFormat('d F Y') }}</span>
                                </div>
                            @endif

                            <!-- Button -->
                            @if($slide->type === 'post' && $slide->post)
                                <a href="{{ $slide->post->getShowRoute() }}" class="inline-flex items-center gap-3 border border-white text-white px-6 py-3 rounded-full hover:bg-white hover:text-black transition-all duration-300 font-medium">
                                    <span data-t="home.hero_btn_baca"></span> <i class="fas fa-arrow-right"></i>
                                </a>
                            @elseif($slide->type === 'youtube')
                                <a href="{{ $slide->youtube_url }}" target="_blank" class="inline-flex items-center gap-3 border border-white text-white px-6 py-3 rounded-full hover:bg-white hover:text-black transition-all duration-300 font-medium">
                                    <span data-t="home.hero_btn_tonton"></span> <i class="fas fa-play"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        
        <!-- Controls Navigation (Bottom Right) -->
        <div class="absolute bottom-8 right-8 z-30 flex gap-4" id="hero-nav">
            <button onclick="heroSplide && heroSplide.go('<')" class="w-12 h-12 flex items-center justify-center border border-white/50 text-white rounded hover:bg-white hover:text-black transition-all bg-transparent">
                <i class="fas fa-arrow-left"></i>
            </button>
            <button onclick="heroSplide && heroSplide.go('>')" class="w-12 h-12 flex items-center justify-center border border-white/50 text-white rounded hover:bg-white hover:text-black transition-all bg-transparent">
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>

    </section>
    @else
    <!-- Fallback Hero Jika Slide Kosong -->
    <section class="relative h-screen flex items-center justify-center overflow-hidden bg-slate-900">
        @if ($embedUrl)
            <div class="absolute inset-0 z-0">
                <div class="relative w-full h-full" style="padding-bottom: 56.25%;">
                    <iframe class="absolute top-0 left-0 w-full h-full"
                            src="{{ $embedUrl }}"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
        @else
            <div class="absolute inset-0 z-0 bg-slate-900">
                <div class="absolute inset-0 bg-black opacity-60"></div>
            </div>
        @endif

        <div class="absolute inset-0 bg-black bg-opacity-60 z-10"></div>

        <div class="relative z-20 text-center text-white px-4 max-w-5xl mx-auto w-full">
            <div class="mb-10 animate-fade-in-up">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 text-white tracking-tight">
                    PEMERINTAHAN DESA
                </h1>
                <h2 class="text-3xl md:text-5xl font-semibold mb-6 text-emerald-400 tracking-wide">
                    CIGAGADE - BALUBUR LIMBANGAN
                </h2>
                <div class="w-24 h-1 bg-emerald-500 mx-auto rounded-full mb-8 animate-scale-in"></div>
                <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed font-light">
                    <span data-t="home.fallback_desc"></span>
                </p>
            </div>
    </section>
    @endif

    {{-- Running Text Marquee di Bawah Banner Utama (Hero Slider) --}}
    @if(isset($runningTexts) && $runningTexts->isNotEmpty())
    <div id="running-text-ticker" class="relative z-30 select-none shadow-lg" 
         style="background-color: #121214 !important; color: #f1f5f9 !important; border-top: 2px solid #dc2626 !important; border-bottom: 1px solid #1e293b !important; box-shadow: 0 4px 15px rgba(0,0,0,0.35);">
        <div class="ticker-inner">
            {{-- Badge INFO dengan Sisi Miring (Slanted Edge) --}}
            <div class="ticker-badge" style="background-color: #dc2626 !important; color: #ffffff !important;">
                <i class="fas fa-bullhorn ticker-badge-icon" style="color: #ffffff !important;"></i>
                <span class="ticker-badge-text" style="color: #ffffff !important;">INFO</span>
            </div>

            {{-- Marquee Track --}}
            <div class="ticker-track">
                <div class="ticker-content" style="color: #e2e8f0 !important;">
                    {{-- Render dua kali untuk seamless loop tanpa jeda --}}
                    @for($i = 0; $i < 2; $i++)
                        @foreach($runningTexts as $item)
                            <span class="ticker-item">
                                @if($item->url)
                                    <a href="{{ $item->url }}" {{ str_starts_with($item->url, 'http') ? 'target="_blank" rel="noopener noreferrer"' : '' }} 
                                       class="ticker-link" style="color: #fcd34d !important;">
                                        <span style="color: #fcd34d !important;">{{ $item->text }}</span>
                                        <i class="fas fa-arrow-up-right-from-square ticker-ext-icon" style="color: #fcd34d !important;"></i>
                                    </a>
                                @else
                                    <span class="ticker-text" style="color: #f1f5f9 !important;">{{ $item->text }}</span>
                                @endif
                                <span class="ticker-dot" style="color: #ef4444 !important;">•</span>
                            </span>
                        @endforeach
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <style>
        #running-text-ticker {
            position: relative;
            z-index: 30;
            background-color: #121214 !important;
            color: #f1f5f9 !important;
            border-top: 2px solid #dc2626 !important;
            border-bottom: 1px solid #450a0a !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.35);
        }
        .ticker-inner {
            max-width: 100vw;
            margin: 0 auto;
            display: flex;
            align-items: stretch;
            height: 48px;
            overflow: hidden;
        }
        .ticker-badge {
            position: relative;
            z-index: 20;
            display: flex;
            align-items: center;
            gap: 8px;
            padding-left: 1.25rem;
            padding-right: 2rem;
            background-color: #dc2626 !important;
            color: #ffffff !important;
            font-weight: 800;
            font-size: 13px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            flex-shrink: 0;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.4);
            clip-path: polygon(0 0, 100% 0, 85% 100%, 0 100%);
            -webkit-clip-path: polygon(0 0, 100% 0, 85% 100%, 0 100%);
        }
        .ticker-badge-icon {
            font-size: 12px;
            animation: bounce 2s infinite;
        }
        .ticker-badge-text {
            font-weight: 900;
            letter-spacing: 0.15em;
        }
        .ticker-track {
            flex-grow: 1;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            padding: 4px 0;
        }
        .ticker-content {
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            font-size: 13px;
            font-weight: 500;
            color: #e2e8f0 !important;
            will-change: transform;
            animation: tickerScroll 35s linear infinite;
        }
        #running-text-ticker:hover .ticker-content {
            animation-play-state: paused;
        }
        .ticker-item {
            display: inline-flex;
            align-items: center;
        }
        .ticker-link {
            color: #fcd34d !important;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: color 0.2s ease;
        }
        .ticker-link:hover {
            color: #fef08a !important;
            text-decoration: underline !important;
        }
        .ticker-ext-icon {
            font-size: 10px;
            opacity: 0.85;
        }
        .ticker-text {
            color: #f1f5f9 !important;
        }
        .ticker-dot {
            color: #ef4444 !important;
            font-weight: 900;
            margin: 0 16px;
            font-size: 14px;
        }
        @keyframes tickerScroll {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }
    </style>
    @endif

    <!-- PERBAIKAN: Section About (Sesuai referensi receipt/card dengan garis atas hijau) -->
    <section id="about" class="py-24 bg-white dark:bg-slate-950 text-gray-800 dark:text-gray-100 antialiased">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20 items-center">
                <!-- Kolom Teks -->
                <div class="scroll-reveal order-2 md:order-1">
                    <span class="text-emerald-600 dark:text-emerald-400 font-bold text-xs tracking-widest uppercase mb-3 block">
                        {{ $settings['about_subtitle'] ?? 'Tentang Kami' }}
                    </span>
                    <h2 class="text-3xl md:text-[40px] font-bold text-slate-900 dark:text-white mb-6 leading-tight">
                        {{ $settings['about_title'] ?? 'Profil Desa Cigagade' }}
                    </h2>
                    <div class="prose prose-lg text-slate-600 dark:text-slate-400 leading-relaxed max-w-none">
                        <p>
                            {{ $settings['about_description'] ?? 'Desa Cigagade terletak di Kecamatan Balubur Limbangan, Kabupaten Garut. Memiliki potensi agraris yang subur, keindahan alam perbukitan, serta masyarakat yang gotong royong dan berbudaya.' }}
                        </p>
                    </div>
                </div>
                <!-- Kolom Gambar (Style card putih dengan border-top hijau dan shadow halus) -->
                <div class="scroll-reveal animation-delay-200 order-1 md:order-2">
                    @if ($settings['about_image'] ?? false)
                        <div class="rounded-2xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.08)] bg-white border-t-4 border-emerald-600 dark:bg-slate-900 dark:border-emerald-500 relative">
                            <img src="{{ asset('storage/'. $settings['about_image']) }}" alt="Tentang Desa Cigagade" class="w-full h-auto object-cover aspect-[4/3] p-1 rounded-[1.25rem]">
                        </div>
                    @else
                        <div class="rounded-2xl border-t-4 border-emerald-600 shadow-[0_8px_30px_rgb(0,0,0,0.08)] bg-white dark:bg-slate-900 flex items-center justify-center aspect-[4/3]">
                            <div class="text-center">
                                <i class="fas fa-image text-4xl text-slate-300 dark:text-slate-600 mb-2"></i>
                                <span class="text-slate-400 text-sm block"><span data-t="home.about_no_image"></span></span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Section Galeri Kegiatan Desa (Dynamic Magazine Bento & Lightbox) -->
    <section id="galeri-desa" class="py-24 bg-slate-50 dark:bg-slate-900 transition-colors duration-300"
             x-data="{
                lightboxOpen: false,
                currentIndex: 0,
                items: [
                    @foreach($galleries as $idx => $g)
                    @php
                        $tLower = strtolower($g->title ?? '');
                        if (str_contains($tLower, 'panen') || str_contains($tLower, 'irigasi') || str_contains($tLower, 'tani')) {
                            $catName = 'Pertanian & Alam';
                            $catBadge = 'bg-emerald-600 text-white';
                            $catIcon = 'fa-seedling';
                        } elseif (str_contains($tLower, 'bumdes') || str_contains($tLower, 'wisata') || str_contains($tLower, 'cibalampu') || str_contains($tLower, 'umkm') || str_contains($tLower, 'pangan')) {
                            $catName = 'Ekonomi & Budaya';
                            $catBadge = 'bg-amber-600 text-white';
                            $catIcon = 'fa-store';
                        } elseif (str_contains($tLower, 'pelayanan') || str_contains($tLower, 'musrenbang') || str_contains($tLower, 'pajak') || str_contains($tLower, 'penghargaan') || str_contains($tLower, 'kantor')) {
                            $catName = 'Pemerintahan';
                            $catBadge = 'bg-blue-600 text-white';
                            $catIcon = 'fa-landmark';
                        } else {
                            $catName = 'Sosial & Warga';
                            $catBadge = 'bg-rose-600 text-white';
                            $catIcon = 'fa-people-group';
                        }
                    @endphp
                    {
                        id: {{ $g->id }},
                        title: '{{ addslashes($g->title ?? 'Dokumentasi Kegiatan Desa') }}',
                        src: '{{ asset('storage/' . $g->image) }}',
                        categoryLabel: '{{ $catName }}',
                        categoryBadge: '{{ $catBadge }}',
                        categoryIcon: '{{ $catIcon }}'
                    },
                    @endforeach
                ],
                openLightbox(idx) {
                    this.currentIndex = idx;
                    this.lightboxOpen = true;
                    document.body.style.overflow = 'hidden';
                },
                closeLightbox() {
                    this.lightboxOpen = false;
                    document.body.style.overflow = 'auto';
                },
                nextImage() {
                    this.currentIndex = (this.currentIndex + 1) % this.items.length;
                },
                prevImage() {
                    this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
                }
             }"
             @keydown.escape.window="closeLightbox()"
             @keydown.arrow-right.window="if(lightboxOpen) nextImage()"
             @keydown.arrow-left.window="if(lightboxOpen) prevImage()">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center max-w-3xl mx-auto mb-16 scroll-reveal">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-bold uppercase tracking-wider mb-4 shadow-sm">
                    <i class="fas fa-camera-retro"></i>
                    <span>Dokumentasi Visual Desa</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-4">
                    <span data-t="home.gallery_title">{{ __('home.gallery_title') }}</span>
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-base sm:text-lg leading-relaxed">
                    <span data-t="home.gallery_subtitle">{{ __('home.gallery_subtitle') }}</span>
                </p>
            </div>

            @if ($galleries->isEmpty())
                <div class="text-center py-16 bg-white dark:bg-slate-800 rounded-3xl border border-dashed border-slate-200 dark:border-slate-700 scroll-reveal shadow-sm">
                    <i class="fas fa-images text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                    <p class="text-slate-500 dark:text-slate-400 text-sm"><span data-t="home.gallery_empty"></span></p>
                </div>
            @else
                {{-- Rich Asymmetric Dynamic Bento Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 auto-rows-[220px]">
                    @foreach ($galleries as $index => $gallery)
                        @php
                            $tLower = strtolower($gallery->title ?? '');
                            if (str_contains($tLower, 'panen') || str_contains($tLower, 'irigasi') || str_contains($tLower, 'tani')) {
                                $cLabel = 'Pertanian & Alam';
                                $cIcon = 'fa-seedling';
                                $cBadge = 'bg-emerald-600/90 text-white';
                            } elseif (str_contains($tLower, 'bumdes') || str_contains($tLower, 'wisata') || str_contains($tLower, 'cibalampu') || str_contains($tLower, 'umkm') || str_contains($tLower, 'pangan')) {
                                $cLabel = 'Ekonomi & Budaya';
                                $cIcon = 'fa-store';
                                $cBadge = 'bg-amber-600/90 text-white';
                            } elseif (str_contains($tLower, 'pelayanan') || str_contains($tLower, 'musrenbang') || str_contains($tLower, 'pajak') || str_contains($tLower, 'penghargaan') || str_contains($tLower, 'kantor')) {
                                $cLabel = 'Pemerintahan';
                                $cIcon = 'fa-landmark';
                                $cBadge = 'bg-blue-600/90 text-white';
                            } else {
                                $cLabel = 'Sosial & Warga';
                                $cIcon = 'fa-people-group';
                                $cBadge = 'bg-rose-600/90 text-white';
                            }

                            // Dynamic Bento sizing:
                            // Index 0: 2 cols x 2 rows (Hero Tile)
                            // Index 5 & 6: 2 cols x 1 row (Wide Panoramic)
                            // Index 11: 2 cols x 1 row
                            if ($index === 0) {
                                $spanClass = 'sm:col-span-2 sm:row-span-2';
                            } elseif ($index === 5 || $index === 6 || $index === 11) {
                                $spanClass = 'sm:col-span-2 sm:row-span-1';
                            } else {
                                $spanClass = 'sm:col-span-1 sm:row-span-1';
                            }
                        @endphp

                        <div @click="openLightbox({{ $index }})"
                             class="group relative rounded-3xl overflow-hidden cursor-pointer bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-[0_4px_25px_rgb(0,0,0,0.06)] hover:shadow-2xl hover:shadow-emerald-950/20 transition-all duration-500 {{ $spanClass }}">

                            {{-- Gambar Utama --}}
                            <img src="{{ asset('storage/'. $gallery->image) }}" 
                                 alt="{{ $gallery->title ?? 'Galeri Kegiatan' }}" 
                                 loading="lazy"
                                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">

                            {{-- Dark Gradient Overlay: Selalu sedikit gelap di bawah agar teks terbaca, lebih pekat saat hover --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-black/10 group-hover:from-black/95 group-hover:via-black/40 transition-all duration-500"></div>

                            {{-- Badge Kategori Top-Left --}}
                            <div class="absolute top-4 left-4 z-10 flex items-center gap-1.5">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold shadow-md backdrop-blur-md border border-white/20 {{ $cBadge }}">
                                    <i class="fas {{ $cIcon }} text-[10px]"></i>
                                    <span>{{ $cLabel }}</span>
                                </span>
                                @if($index === 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-amber-500 text-slate-950 shadow-md">
                                        <i class="fas fa-star"></i> Unggulan
                                    </span>
                                @endif
                            </div>

                            {{-- Hover Zoom Icon Center-Right --}}
                            <div class="absolute top-4 right-4 z-10 w-9 h-9 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 group-hover:scale-100 scale-75 transition-all duration-300 shadow-lg">
                                <i class="fas fa-magnifying-glass-plus text-xs"></i>
                            </div>

                            {{-- Caption Bottom --}}
                            <div class="absolute inset-x-0 bottom-0 p-5 sm:p-6 z-10 flex flex-col justify-end translate-y-1 group-hover:translate-y-0 transition-transform duration-300">
                                <h3 class="font-bold text-white text-base {{ $index === 0 ? 'sm:text-2xl sm:leading-snug' : 'sm:text-lg' }} line-clamp-2 drop-shadow-md">
                                    {{ $gallery->title }}
                                </h3>
                                <div class="flex items-center justify-between mt-2 pt-2 border-t border-white/15 text-xs text-slate-300 opacity-90">
                                    <span class="flex items-center gap-1 text-[11px]">
                                        <i class="fas fa-location-dot text-emerald-400"></i> Desa Cigagade
                                    </span>
                                    <span class="font-semibold text-emerald-300 group-hover:text-emerald-200 flex items-center gap-1 text-[11px]">
                                        <span>Perbesar</span>
                                        <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-0.5 transition-transform"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- LIGHTBOX MODAL --}}
        <div x-show="lightboxOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-md p-4 sm:p-6"
             style="display: none;">

            {{-- Close Button --}}
            <button @click="closeLightbox()" 
                    class="absolute top-5 right-5 z-20 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 text-white flex items-center justify-center transition-all duration-200">
                <i class="fas fa-times text-lg"></i>
            </button>

            {{-- Prev Button --}}
            <button @click="prevImage()" 
                    class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/10 hover:bg-white/25 border border-white/20 text-white flex items-center justify-center transition-all duration-200">
                <i class="fas fa-chevron-left text-lg"></i>
            </button>

            {{-- Next Button --}}
            <button @click="nextImage()" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/10 hover:bg-white/25 border border-white/20 text-white flex items-center justify-center transition-all duration-200">
                <i class="fas fa-chevron-right text-lg"></i>
            </button>

            {{-- Content Box --}}
            <div @click.away="closeLightbox()" class="relative max-w-5xl w-full max-h-[90vh] flex flex-col items-center">
                <div class="relative w-full overflow-hidden rounded-2xl bg-black/50 border border-white/10 shadow-2xl flex items-center justify-center">
                    <img :src="items[currentIndex]?.src" 
                         :alt="items[currentIndex]?.title" 
                         class="max-h-[72vh] w-auto max-w-full object-contain mx-auto select-none">
                </div>

                {{-- Lightbox Caption Bar --}}
                <div class="w-full mt-4 flex flex-col sm:flex-row items-center justify-between gap-3 px-2 text-white">
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold"
                              :class="items[currentIndex]?.categoryBadge">
                            <span x-text="items[currentIndex]?.categoryLabel"></span>
                        </span>
                        <h4 class="font-bold text-sm sm:text-base text-slate-100" x-text="items[currentIndex]?.title"></h4>
                    </div>
                    <div class="text-xs text-slate-400 font-medium shrink-0">
                        <span x-text="currentIndex + 1"></span> dari <span x-text="items.length"></span> Foto
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Kementerian (Tetap utuh) -->
    <div class="w-full bg-white dark:bg-slate-950" x-data="{ modalOpen: false, selectedImage: '' }">
        <div class="pt-24 pb-12 px-4 sm:px-6 lg:px-8 text-center scroll-reveal">
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4"><span data-t="home.rubrik_title"></span></h2>
            <p class="text-slate-500 dark:text-slate-400 text-base max-w-2xl mx-auto"><span data-t="home.rubrik_subtitle"></span></p>
        </div>
        
        @if ($ministries->isEmpty())
            <div class="max-w-7xl mx-auto px-4 pb-24">
                <div class="text-center py-16 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-dashed border-slate-200 dark:border-slate-800 scroll-reveal">
                    <i class="fas fa-building text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                    <p class="text-slate-500 dark:text-slate-400 text-sm"><span data-t="home.rubrik_empty"></span></p>
                </div>
            </div>
        @else
            <div class="w-full pb-12">
                <div class="splide scroll-reveal" data-options='{"type":"slide","perPage":4,"perMove":1,"gap":0,"arrows":true,"pagination":true,"breakpoints":{"1024":{"perPage":3},"768":{"perPage":2},"640":{"perPage":1}}}'>
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach ($ministries as $ministry)
                                <li class="splide__slide">
                                    <div class="relative w-full h-[400px] lg:h-[500px] group cursor-pointer border-r border-slate-200 dark:border-slate-800 overflow-hidden"
                                         @click="modalOpen = true; selectedImage = '{{ asset('storage/' . $ministry->image) }}'">
                                        
                                        <img src="{{ $ministry->image ? asset('storage/' . $ministry->image) : 'https://placehold.co/800x1200/064e3b/FFF?text=Perangkat+Desa' }}" 
                                             alt="{{ $ministry->name }}" 
                                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 group-hover:opacity-80 transition-all duration-700">
                                        
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/50 to-black/10"></div>
                                        
                                        <div class="absolute inset-0 p-6 sm:p-8 flex flex-col justify-end">
                                            <span class="text-[10px] sm:text-xs font-bold text-gray-300 tracking-widest uppercase mb-2"><span data-t="home.rubrik_label"></span></span>
                                            <h3 class="text-xl sm:text-2xl font-bold text-white mb-6 group-hover:-translate-y-2 transition-transform duration-500 line-clamp-3">{{ $ministry->name }}</h3>
                                            
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border border-white/50 flex items-center justify-center text-white group-hover:bg-white group-hover:text-black transition-all duration-500 mt-auto">
                                                <i class="fas fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform duration-500"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4" style="display: none;" x-transition.opacity>
            <div @click.away="modalOpen = false" class="relative max-w-4xl w-full">
                <button @click="modalOpen = false" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-3xl"></i>
                </button>
                <img :src="selectedImage" class="rounded-lg shadow-2xl w-full h-auto object-contain">
            </div>
        </div>
    </div>

    <!-- Section Berita (Tetap utuh dengan sedikit penyesuaian warna border) -->
    <div class="py-24 bg-slate-50 dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-10 scroll-reveal">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2"><span data-t="home.news_title"></span></h2>
                    <p class="text-slate-500 dark:text-slate-400 text-base"><span data-t="home.news_subtitle"></span></p>
                </div>
                <a href="{{ route('berita.index') }}" class="hidden sm:inline-flex items-center text-sm font-bold tracking-widest uppercase text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 transition-colors">
                    <span data-t="home.news_see_all"></span> <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            
            @if ($posts->isEmpty())
                <div class="text-center py-16 bg-white dark:bg-slate-800 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700 scroll-reveal shadow-sm">
                    <i class="fas fa-newspaper text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                    <p class="text-slate-500 dark:text-slate-400 text-sm"><span data-t="home.news_empty"></span></p>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6">
                    @if(isset($posts[0]))
                    <div class="lg:col-span-6 xl:col-span-7 h-[400px] lg:h-[600px] rounded-3xl overflow-hidden relative group scroll-reveal shadow-md">
                        <img src="{{ $posts[0]->image ? asset('storage/' . $posts[0]->image) : 'https://placehold.co/800x600/111928/FFF?text=No+Image' }}" alt="{{ $posts[0]->getTitle() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-6 sm:p-10 w-full z-10">
                            <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-bold rounded mb-4 uppercase tracking-wider">
                                {{ $posts[0]->category->name ?? 'BERITA' }}
                            </span>
                            <h3 class="text-2xl sm:text-4xl font-bold text-white leading-tight mb-4 line-clamp-3">
                                <a href="{{ $posts[0]->getShowRoute() }}" class="hover:text-emerald-300 transition-colors">
                                    {{ $posts[0]->getTitle() }}
                                </a>
                            </h3>
                            <div class="flex items-center text-gray-300 text-sm font-medium">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <span>{{ ($posts[0]->published_at ?? $posts[0]->created_at)->format('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="lg:col-span-6 xl:col-span-5 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        @foreach ($posts->slice(1, 4) as $index => $post)
                        <div class="h-[250px] lg:h-[288px] rounded-3xl overflow-hidden relative group scroll-reveal shadow-sm" style="animation-delay: {{ $index * 100 }}ms">
                            <img src="{{ $post->image ? asset('storage/' . $post->image) : 'https://placehold.co/600x400/111928/FFF?text=No+Image' }}" alt="{{ $post->getTitle() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/30 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-5 sm:p-6 w-full z-10">
                                <span class="inline-block px-2 py-1 bg-white/20 backdrop-blur-md text-white text-[10px] font-bold rounded mb-3 uppercase tracking-wider">
                                    {{ $post->category->name ?? 'BERITA' }}
                                </span>
                                <h3 class="text-sm sm:text-lg font-bold text-white leading-snug mb-3 line-clamp-3">
                                    <a href="{{ $post->getShowRoute() }}" class="hover:text-emerald-300 transition-colors">
                                        {{ $post->getTitle() }}
                                    </a>
                                </h3>
                                <div class="flex items-center text-gray-300 text-xs font-medium">
                                    <i class="far fa-calendar-alt mr-1.5"></i>
                                    <span>{{ ($post->published_at ?? $post->created_at)->format('d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-8 text-center sm:hidden scroll-reveal">
                    <a href="{{ route('berita.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-slate-200 dark:border-slate-700 text-sm font-bold tracking-widest uppercase rounded-full text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 shadow-sm">
                        <span data-t="home.news_see_all_mobile"></span>
                    </a>
                </div>
            @endif
    </div>

    {{-- ===== SECTION KATEGORI BERITA (3-Column Magazine Layout) ===== --}}
    @if(isset($magazinePosts) && $magazinePosts->isNotEmpty())
    <div class="py-16 bg-white dark:bg-slate-950 border-t border-slate-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8 scroll-reveal">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-1"><span data-t="home.popular_title"></span></h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm"><span data-t="home.popular_subtitle"></span></p>
                </div>
                <a href="{{ route('berita.index') }}" class="hidden sm:inline-flex items-center text-sm font-bold tracking-widest uppercase text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 transition-colors">
                    <span data-t="home.popular_see_all"></span> <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-6">
                
                {{-- Kiri: 3 List Berita Sedang --}}
                <div class="lg:col-span-3 flex flex-col gap-6 lg:border-r lg:border-slate-100 dark:lg:border-slate-800 lg:pr-6 scroll-reveal">
                    @foreach ($magazinePosts->slice(3, 3) as $post)
                    <div class="group flex flex-col">
                        <a href="{{ $post->getShowRoute() }}" class="block w-full h-36 sm:h-40 relative overflow-hidden mb-3 bg-slate-100 dark:bg-slate-800 rounded-xl">
                            <img src="{{ $post->image ? asset('storage/' . $post->image) : 'https://placehold.co/500x300/1e293b/FFF?text=News' }}" alt="{{ $post->getTitle() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </a>
                        <div class="flex items-center gap-3 mb-1.5">
                            <span class="text-[10px] uppercase font-bold text-red-500 tracking-widest">{{ $post->category->name ?? 'BERITA' }}</span>
                            <span class="flex items-center gap-1 text-[10px] text-slate-400 font-medium">
                                <i class="fas fa-eye text-[9px]"></i> {{ number_format($post->views) }} views
                            </span>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white line-clamp-3 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors leading-snug">
                            <a href="{{ $post->getShowRoute() }}">{{ $post->getTitle() }}</a>
                        </h3>
                    </div>
                    @endforeach
                </div>

                {{-- Tengah: 1 Featured Besar & 2 Sedang di Bawah --}}
                <div class="lg:col-span-6 flex flex-col gap-6 scroll-reveal">
                    @if(isset($magazinePosts[0]))
                    @php $mainPost = $magazinePosts[0]; @endphp
                    <div class="relative group overflow-hidden rounded-2xl">
                        <a href="{{ $mainPost->getShowRoute() }}" class="block w-full h-[350px] sm:h-[450px] relative overflow-hidden bg-slate-100 dark:bg-slate-800">
                            <img src="{{ $mainPost->image ? asset('storage/' . $mainPost->image) : 'https://placehold.co/800x600/1e293b/FFF?text=News' }}" alt="{{ $mainPost->getTitle() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                        </a>
                        <div class="absolute bottom-6 left-6 right-6 z-10 pointer-events-none">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="inline-block bg-red-500 text-white text-[10px] font-bold px-2.5 py-1 uppercase tracking-widest rounded-full shadow-sm">{{ $mainPost->category->name ?? 'BERITA' }}</span>
                                <span class="flex items-center gap-1.5 text-[11px] text-gray-300 font-semibold">
                                    <i class="fas fa-eye text-[10px]"></i> {{ number_format($mainPost->views) }} views
                                </span>
                            </div>
                            <h2 class="text-2xl sm:text-4xl font-extrabold text-white leading-tight mb-2 line-clamp-3 pointer-events-auto">
                                <a href="{{ $mainPost->getShowRoute() }}" class="hover:text-emerald-300 transition-colors">{{ $mainPost->getTitle() }}</a>
                            </h2>
                            <p class="text-gray-300 text-sm line-clamp-2 mb-3 hidden sm:block">{{ $mainPost->getExcerpt() }}</p>
                            <div class="flex items-center text-[11px] text-gray-400 uppercase tracking-widest font-semibold">
                                <span class="text-white mr-2">{{ $mainPost->user->name ?? 'Admin' }}</span> &bull; <span class="ml-2">{{ ($mainPost->published_at ?? $mainPost->created_at)->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                        @foreach ($magazinePosts->slice(1, 2) as $subPost)
                        <div class="group flex flex-col">
                            <a href="{{ $subPost->getShowRoute() }}" class="block w-full h-40 sm:h-48 relative overflow-hidden mb-3 bg-slate-100 dark:bg-slate-800 rounded-xl">
                                <img src="{{ $subPost->image ? asset('storage/' . $subPost->image) : 'https://placehold.co/600x400/1e293b/FFF?text=News' }}" alt="{{ $subPost->getTitle() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </a>
                            <div class="flex items-center gap-3 mb-1.5">
                                <span class="text-[10px] uppercase font-bold text-red-500 tracking-widest">{{ $subPost->category->name ?? 'BERITA' }}</span>
                                <span class="flex items-center gap-1 text-[10px] text-slate-400 font-medium">
                                    <i class="fas fa-eye text-[9px]"></i> {{ number_format($subPost->views) }} views
                                </span>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white line-clamp-2 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors leading-snug">
                                <a href="{{ $subPost->getShowRoute() }}">{{ $subPost->getTitle() }}</a>
                            </h3>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Kanan: 3 List Berita Sedang --}}
                <div class="lg:col-span-3 flex flex-col gap-6 lg:border-l lg:border-slate-100 dark:lg:border-slate-800 lg:pl-6 scroll-reveal">
                    @foreach ($magazinePosts->slice(6, 3) as $post)
                    <div class="group flex flex-col">
                        <a href="{{ $post->getShowRoute() }}" class="block w-full h-36 sm:h-40 relative overflow-hidden mb-3 bg-slate-100 dark:bg-slate-800 rounded-xl">
                            <img src="{{ $post->image ? asset('storage/' . $post->image) : 'https://placehold.co/500x300/1e293b/FFF?text=News' }}" alt="{{ $post->getTitle() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </a>
                        <div class="flex items-center gap-3 mb-1.5">
                            <span class="text-[10px] uppercase font-bold text-red-500 tracking-widest">{{ $post->category->name ?? 'BERITA' }}</span>
                            <span class="flex items-center gap-1 text-[10px] text-slate-400 font-medium">
                                <i class="fas fa-eye text-[9px]"></i> {{ number_format($post->views) }} views
                            </span>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white line-clamp-3 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors leading-snug">
                            <a href="{{ $post->getShowRoute() }}">{{ $post->getTitle() }}</a>
                        </h3>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    @endif

    {{-- ===== SECTION UMKM & PRODUK UNGGULAN DESA ===== --}}
    @if(isset($umkmProducts) && $umkmProducts->isNotEmpty())
    <div class="py-24 bg-gradient-to-b from-emerald-50/40 via-white to-slate-50 dark:from-slate-900/60 dark:via-slate-950 dark:to-slate-900/40 border-y border-emerald-100/50 dark:border-slate-800"
         x-data="{
            umkmModalOpen: false,
            activeUmkm: null,
            openUmkm(data) {
                this.activeUmkm = data;
                this.umkmModalOpen = true;
            }
         }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12 scroll-reveal">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 mb-3">
                        <i class="fas fa-store text-[11px]"></i>
                        <span>Ekonomi Kerakyatan & Potensi Warga</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Produk Unggulan & UMKM <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Desa Cigagade</span>
                    </h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base mt-2 max-w-2xl">
                        Dukung perputaran ekonomi desa dengan berbelanja komoditas pertanian, olahan pangan lokal, dan kerajinan tangan langsung dari tangan warga Cigagade.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('umkm.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-xs font-bold uppercase tracking-wider shadow-sm shadow-emerald-500/20 transition-all hover:scale-105">
                        <span>Lihat Semua Katalog</span>
                        <i class="fas fa-arrow-right text-[11px]"></i>
                    </a>
                </div>
            </div>

            {{-- UMKM Cards Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach ($umkmProducts as $item)
                    @php
                        $umkmJson = [
                            'id' => $item->id,
                            'name' => $item->name,
                            'slug' => $item->slug,
                            'category' => $item->category,
                            'price' => number_format($item->price, 0, ',', '.'),
                            'unit' => $item->unit,
                            'formatted_price' => $item->formatted_price,
                            'seller_name' => $item->seller_name,
                            'phone' => $item->phone,
                            'address' => $item->address,
                            'description' => $item->description,
                            'image_url' => $item->image_url,
                            'whatsapp_url' => $item->whatsapp_url,
                            'detail_url' => route('umkm.show', $item->slug),
                        ];
                    @endphp
                    <div class="group bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200/80 dark:border-slate-800 hover:border-emerald-500/50 dark:hover:border-emerald-500/50 shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col transform hover:-translate-y-1 scroll-reveal">
                        
                        {{-- Image & Badges --}}
                        <div class="relative aspect-4/3 overflow-hidden bg-slate-100 dark:bg-slate-800 cursor-pointer"
                             @click='openUmkm(@json($umkmJson))'>
                            <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            {{-- Category Badge --}}
                            <div class="absolute top-3 left-3">
                                <span class="px-3 py-1 rounded-xl text-xs font-bold bg-white/95 dark:bg-slate-900/95 backdrop-blur-md text-emerald-700 dark:text-emerald-400 shadow-sm border border-slate-200/60 dark:border-slate-700/60">
                                    {{ $item->category }}
                                </span>
                            </div>

                            {{-- Price Tag Badge --}}
                            <div class="absolute bottom-3 right-3">
                                <span class="px-3.5 py-1.5 rounded-xl text-xs font-black bg-emerald-600/95 backdrop-blur-md text-white shadow-md">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                    @if($item->unit)
                                        <span class="text-[10px] font-normal opacity-90">/ {{ $item->unit }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Card Details --}}
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="font-extrabold text-lg text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors line-clamp-1 cursor-pointer"
                                @click='openUmkm(@json($umkmJson))'>
                                {{ $item->name }}
                            </h3>

                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-2 leading-relaxed flex-1">
                                {{ $item->description }}
                            </p>

                            {{-- Seller & Location Info --}}
                            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                                <div class="flex items-center gap-2 truncate">
                                    <div class="w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-bold text-[10px] flex-shrink-0">
                                        {{ strtoupper(substr($item->seller_name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-slate-700 dark:text-slate-300 truncate">{{ $item->seller_name }}</span>
                                </div>
                                @if($item->address)
                                    <div class="text-[11px] text-slate-400 dark:text-slate-500 truncate flex items-center gap-1 ml-2" title="{{ $item->address }}">
                                        <i class="fas fa-map-marker-alt text-emerald-500 text-[10px]"></i>
                                        <span class="truncate">{{ Str::limit($item->address, 18) }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Actions (Detail Popup & WhatsApp) --}}
                            <div class="mt-4 pt-2 grid grid-cols-2 gap-2">
                                <button type="button"
                                        @click='openUmkm(@json($umkmJson))'
                                        class="w-full py-2.5 px-3 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 text-xs font-semibold transition flex items-center justify-center gap-1.5">
                                    <i class="fas fa-eye text-slate-400 text-xs"></i>
                                    Detail
                                </button>

                                <a href="{{ $item->whatsapp_url }}" target="_blank"
                                   class="w-full py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-xs font-semibold shadow-xs shadow-emerald-600/20 transition flex items-center justify-center gap-1.5">
                                    <i class="fab fa-whatsapp text-sm"></i>
                                    Hubungi WA
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>

        {{-- Detail Modal Popup --}}
        <div x-show="umkmModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/75 backdrop-blur-sm"
             style="display: none;"
             @keydown.escape.window="umkmModalOpen = false">

            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-slate-200 dark:border-slate-800 shadow-2xl relative"
                 @click.away="umkmModalOpen = false">

                {{-- Close Button --}}
                <button type="button" @click="umkmModalOpen = false"
                        class="absolute top-4 right-4 z-20 w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-500 dark:text-slate-400 flex items-center justify-center transition">
                    <i class="fas fa-xmark text-sm"></i>
                </button>

                <template x-if="activeUmkm">
                    <div>
                        {{-- Modal Image --}}
                        <div class="relative aspect-16/9 bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            <img :src="activeUmkm.image_url" :alt="activeUmkm.name" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/30 to-transparent"></div>
                            
                            <div class="absolute bottom-4 left-6 right-6 flex items-end justify-between">
                                <div>
                                    <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-500 text-white mb-1.5" x-text="activeUmkm.category"></span>
                                    <h2 class="text-xl sm:text-2xl font-extrabold text-white" x-text="activeUmkm.name"></h2>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-slate-300">Harga</p>
                                    <p class="text-lg sm:text-xl font-black text-emerald-400">
                                        Rp <span x-text="activeUmkm.price"></span>
                                        <template x-if="activeUmkm.unit">
                                            <span class="text-xs font-normal text-slate-300" x-text="'/ ' + activeUmkm.unit"></span>
                                        </template>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Body --}}
                        <div class="p-6 sm:p-8 space-y-6">
                            {{-- Deskripsi --}}
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2 flex items-center gap-1.5">
                                    <i class="fas fa-align-left text-emerald-500"></i>
                                    Deskripsi Produk
                                </h4>
                                <div class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800"
                                     x-text="activeUmkm.description"></div>
                            </div>

                            {{-- Penjual Card --}}
                            <div class="bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/40 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <p class="text-xs text-emerald-800 dark:text-emerald-400 font-semibold uppercase tracking-wider">Pelaku UMKM / Penjual</p>
                                    <p class="text-base font-bold text-slate-900 dark:text-white mt-0.5" x-text="activeUmkm.seller_name"></p>
                                    <template x-if="activeUmkm.address">
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1">
                                            <i class="fas fa-map-marker-alt text-emerald-600"></i>
                                            <span x-text="activeUmkm.address"></span>
                                        </p>
                                    </template>
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    <span class="inline-flex items-center gap-1.5 text-emerald-700 dark:text-emerald-300 font-medium">
                                        <i class="fab fa-whatsapp text-emerald-600"></i>
                                        <span x-text="activeUmkm.phone"></span>
                                    </span>
                                </div>
                            </div>

                            {{-- Direct WhatsApp Button & Page Link --}}
                            <div class="flex flex-col sm:flex-row items-center gap-3 pt-2">
                                <a :href="activeUmkm.whatsapp_url" target="_blank"
                                   class="w-full sm:flex-1 py-3 px-5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-2xl font-bold text-sm shadow-md shadow-emerald-600/20 transition flex items-center justify-center gap-2">
                                    <i class="fab fa-whatsapp text-lg"></i>
                                    <span>Hubungi Penjual via WhatsApp</span>
                                </a>

                                <a :href="activeUmkm.detail_url"
                                   class="w-full sm:w-auto py-3 px-5 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 text-sm font-semibold transition text-center">
                                    Halaman Lengkap
                                </a>
                            </div>
                        </div>
                    </div>
                </template>

            </div>
        </div>

    </div>
    @endif
    {{-- ===== AKHIR SECTION UMKM & PRODUK UNGGULAN DESA ===== --}}

    {{-- ===== SECTION BANNER LANDSCAPE AUTO-SCROLL (SETELAH UMKM) ===== --}}
    @if(isset($landscapeBanners) && $landscapeBanners->isNotEmpty())
    <section id="banner-landscape-section" class="w-full py-8 md:py-12 bg-white dark:bg-slate-950 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-3xl overflow-hidden shadow-xl border border-slate-200/80 dark:border-slate-800 bg-slate-900 group">
                
                @if($landscapeBanners->count() === 1)
                    {{-- Banner Tunggal --}}
                    @php $single = $landscapeBanners->first(); @endphp
                    @if($single->url)
                        <a href="{{ $single->url }}" target="{{ $single->target }}" class="block relative w-full aspect-[21/7] sm:aspect-[24/7] max-h-[440px] overflow-hidden">
                            <img src="{{ asset('storage/' . $single->image) }}" 
                                 alt="{{ $single->title ?? 'Banner Promosi Desa' }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 hover:scale-101">
                        </a>
                    @else
                        <div class="relative w-full aspect-[21/7] sm:aspect-[24/7] max-h-[440px] overflow-hidden">
                            <img src="{{ asset('storage/' . $single->image) }}" 
                                 alt="{{ $single->title ?? 'Banner Promosi Desa' }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @endif
                @else
                    {{-- Banner Multi Slider Auto-Scroll via Splide --}}
                    <div class="splide landscape-banner-splide" 
                         data-options='{"type":"loop","perPage":1,"autoplay":true,"interval":4500,"pauseOnHover":true,"arrows":true,"pagination":true,"speed":900,"easing":"cubic-bezier(0.25, 1, 0.5, 1)"}'>
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach($landscapeBanners as $banner)
                                    <li class="splide__slide">
                                        @if($banner->url)
                                            <a href="{{ $banner->url }}" target="{{ $banner->target }}" 
                                               class="block relative w-full aspect-[21/7] sm:aspect-[24/7] max-h-[440px] overflow-hidden cursor-pointer"
                                               title="{{ $banner->title ?? 'Buka Tautan Banner' }}">
                                                <img src="{{ asset('storage/' . $banner->image) }}" 
                                                     alt="{{ $banner->title ?? 'Banner Landscape Desa Cigagade' }}" 
                                                     class="w-full h-full object-cover transition-transform duration-700 hover:scale-101">
                                                
                                                @if($banner->title)
                                                    <div class="absolute inset-x-0 bottom-0 p-4 sm:p-6 bg-gradient-to-t from-black/85 via-black/35 to-transparent flex items-center justify-between pointer-events-none">
                                                        <span class="text-white text-xs sm:text-base font-bold drop-shadow-md truncate max-w-xl">
                                                            {{ $banner->title }}
                                                        </span>
                                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-white/20 backdrop-blur-md border border-white/30 text-white shrink-0">
                                                            <span>Kunjungi</span>
                                                            <i class="fas fa-arrow-up-right-from-square text-[9px]"></i>
                                                        </span>
                                                    </div>
                                                @endif
                                            </a>
                                        @else
                                            <div class="relative w-full aspect-[21/7] sm:aspect-[24/7] max-h-[440px] overflow-hidden">
                                                <img src="{{ asset('storage/' . $banner->image) }}" 
                                                     alt="{{ $banner->title ?? 'Banner Landscape Desa Cigagade' }}" 
                                                     class="w-full h-full object-cover">
                                                @if($banner->title)
                                                    <div class="absolute inset-x-0 bottom-0 p-4 sm:p-6 bg-gradient-to-t from-black/75 via-black/20 to-transparent">
                                                        <span class="text-white text-xs sm:text-base font-bold drop-shadow-md truncate max-w-xl block">
                                                            {{ $banner->title }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>

    <style>
        /* Custom styling untuk navigasi Splide Banner Landscape */
        .landscape-banner-splide .splide__arrow {
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 2.75rem;
            height: 2.75rem;
            transition: all 0.3s ease;
            opacity: 0;
        }
        .landscape-banner-splide:hover .splide__arrow {
            opacity: 1;
        }
        .landscape-banner-splide .splide__arrow:hover {
            background: #059669;
            border-color: #059669;
            transform: scale(1.1);
        }
        .landscape-banner-splide .splide__arrow svg {
            fill: #ffffff;
            width: 1rem;
            height: 1rem;
        }
        .landscape-banner-splide .splide__pagination {
            bottom: 0.75rem;
        }
        .landscape-banner-splide .splide__pagination__page {
            background: rgba(255, 255, 255, 0.5);
            width: 24px;
            height: 4px;
            border-radius: 9999px;
            margin: 0 4px;
            transition: all 0.3s ease;
        }
        .landscape-banner-splide .splide__pagination__page.is-active {
            background: #10b981;
            width: 42px;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.8);
            transform: none;
        }
    </style>
    @endif
    {{-- ===== AKHIR SECTION BANNER LANDSCAPE AUTO-SCROLL ===== --}}

    {{-- ===== SECTION BENGKEL ILMU ===== --}}
    @if(isset($bengkelIlmuPosts) && $bengkelIlmuPosts->isNotEmpty())
    <div class="py-24 bg-white dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 scroll-reveal">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2"><span data-t="home.bengkel_title"></span></h2>
                    <p class="text-slate-500 dark:text-slate-400 text-base"><span data-t="home.bengkel_subtitle"></span></p>
                </div>
                <a href="{{ route('bengkel-ilmu.list') }}" class="hidden sm:inline-flex items-center text-sm font-bold tracking-widest uppercase text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 transition-colors">
                    <span data-t="home.bengkel_see_all"></span> <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            {{-- Cards Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($bengkelIlmuPosts as $index => $bPost)
                @php
                    $catColors = [
                        'karir-pengembangan-diri' => ['badge' => 'bg-teal-600/80 text-white', 'icon' => 'fa-briefcase'],
                        'riset-inovasi'            => ['badge' => 'bg-green-500/80 text-white', 'icon' => 'fa-microscope'],
                        'hiburan'                  => ['badge' => 'bg-pink-500/80 text-white', 'icon' => 'fa-gamepad'],
                        'institusional'            => ['badge' => 'bg-amber-500/80 text-white', 'icon' => 'fa-university'],
                    ];
                    $slug   = $bPost->category->slug ?? 'riset-inovasi';
                    $colors = $catColors[$slug] ?? $catColors['riset-inovasi'];
                @endphp
                <div class="h-[250px] lg:h-[288px] rounded-3xl overflow-hidden relative group scroll-reveal shadow-sm" style="animation-delay: {{ $index * 100 }}ms">
                    <img src="{{ $bPost->image ? asset('storage/' . $bPost->image) : 'https://placehold.co/600x400/111928/FFF?text=Bengkel+Ilmu' }}" alt="{{ $bPost->getTitle() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-5 sm:p-6 w-full z-10">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 {{ $colors['badge'] }} backdrop-blur-md text-[10px] font-bold rounded mb-3 uppercase tracking-wider">
                            <i class="fas {{ $colors['icon'] }} text-[10px]"></i>
                            {{ $bPost->category->name }}
                        </span>
                        <h3 class="text-sm sm:text-lg font-bold text-white leading-snug mb-3 line-clamp-3">
                            <a href="{{ $bPost->getShowRoute() }}" class="hover:text-emerald-300 transition-colors">
                                {{ $bPost->getTitle() }}
                            </a>
                        </h3>
                        <div class="flex items-center text-gray-300 text-xs font-medium">
                            <i class="far fa-calendar-alt mr-1.5"></i>
                            <span>{{ ($bPost->published_at ?? $bPost->created_at)->format('d F Y') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
    @endif
    {{-- ===== AKHIR SECTION BENGKEL ILMU ===== --}}

    {{-- ===== SECTION SEPUTAR ORMAWA (Magazine Layout) ===== --}}
    @if(isset($ormawaPosts) && $ormawaPosts->isNotEmpty())
    <div class="py-24 bg-slate-50 dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 scroll-reveal">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2"><span data-t="home.ormawa_title"></span></h2>
                    <p class="text-slate-500 dark:text-slate-400 text-base"><span data-t="home.ormawa_subtitle"></span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Featured Post (Kiri) --}}
                @if(isset($ormawaPosts[0]))
                <div class="lg:col-span-7 scroll-reveal">
                    @php 
                        $mainPost = $ormawaPosts[0]; 
                        $isUkm = str_contains($mainPost->category->slug ?? '', 'ukm');
                        $badgeClass = $isUkm ? 'bg-emerald-600 text-white' : 'bg-teal-600 text-white';
                    @endphp
                    <div class="h-[400px] lg:h-[100%] min-h-[450px] rounded-3xl overflow-hidden relative group shadow-md">
                        <a href="{{ $mainPost->getShowRoute() }}" class="absolute inset-0 z-20"></a>
                        <img src="{{ $mainPost->image ? asset('storage/' . $mainPost->image) : 'https://placehold.co/800x600/064e3b/FFF?text=Kelembagaan+Desa' }}" alt="{{ $mainPost->getTitle() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-6 sm:p-10 w-full z-10">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 {{ $badgeClass }} text-[10px] font-bold rounded mb-4 uppercase tracking-wider relative z-30 shadow-sm">
                                <i class="fas {{ $isUkm ? 'fa-users' : 'fa-building' }}"></i>
                                {{ $mainPost->category->name ?? 'KELEMBAGAAN DESA' }}
                            </span>
                            <h3 class="text-2xl sm:text-4xl font-bold text-white leading-tight mb-4 line-clamp-3 relative z-30">
                                <a href="{{ $mainPost->getShowRoute() }}" class="hover:text-emerald-300 transition-colors">
                                    {{ $mainPost->getTitle() }}
                                </a>
                            </h3>
                            <div class="flex items-center text-gray-300 text-sm font-medium relative z-30">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <span>{{ ($mainPost->published_at ?? $mainPost->created_at)->format('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Side Posts List (Kanan) --}}
                <div class="lg:col-span-5 flex flex-col gap-4 sm:gap-6">
                    @foreach ($ormawaPosts->slice(1, 4) as $index => $sidePost)
                    @php 
                        $isUkm = str_contains($sidePost->category->slug ?? '', 'ukm');
                        $badgeColor = $isUkm ? 'text-emerald-600 dark:text-emerald-400' : 'text-teal-600 dark:text-teal-400';
                    @endphp
                    <div class="flex gap-4 group cursor-pointer bg-white dark:bg-slate-800 p-3 sm:p-4 rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 dark:border-slate-700 scroll-reveal" style="animation-delay: {{ $index * 100 }}ms">
                        <a href="{{ $sidePost->getShowRoute() }}" class="w-1/3 sm:w-32 h-24 sm:h-32 rounded-2xl overflow-hidden shrink-0 relative">
                            <img src="{{ $sidePost->image ? asset('storage/' . $sidePost->image) : 'https://placehold.co/400x300/064e3b/FFF?text=Kelembagaan+Desa' }}" alt="{{ $sidePost->getTitle() }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </a>
                        <div class="w-2/3 sm:w-[calc(100%-8rem)] flex flex-col justify-center">
                            <span class="text-[10px] uppercase font-bold {{ $badgeColor }} tracking-wider mb-1.5 flex items-center gap-1.5">
                                <i class="fas {{ $isUkm ? 'fa-users' : 'fa-building' }}"></i> {{ $sidePost->category->name }}
                            </span>
                            <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white line-clamp-2 mb-2 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                <a href="{{ $sidePost->getShowRoute() }}">{{ $sidePost->getTitle() }}</a>
                            </h3>
                            <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                                <i class="far fa-calendar-alt mr-1"></i> {{ ($sidePost->published_at ?? $sidePost->created_at)->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>
    @endif
    {{-- ===== AKHIR SECTION SEPUTAR ORMAWA ===== --}}

    {{-- ===== SECTION PRESTASI & PENGUMUMAN (Magazine Layout) ===== --}}
    @if((isset($prestasiPosts) && $prestasiPosts->isNotEmpty()) || (isset($pengumumanPosts) && $pengumumanPosts->isNotEmpty()))
    <div class="py-24 bg-white dark:bg-slate-950 border-t border-slate-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-12 scroll-reveal">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2"><span data-t="home.prestasi_section_title"></span></h2>
                <p class="text-slate-500 dark:text-slate-400 text-base"><span data-t="home.prestasi_section_subtitle"></span></p>
                <div class="w-16 h-1 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                
                {{-- Kolom Prestasi --}}
                @if(isset($prestasiPosts) && $prestasiPosts->isNotEmpty())
                <div class="scroll-reveal">
                    <div class="flex items-center justify-between mb-6 border-b border-slate-200 dark:border-slate-800 pb-2">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">
                            <span data-t="home.prestasi_col_title"></span>
                        </h3>
                    </div>

                    {{-- Featured Prestasi (1 item) --}}
                    @php $mainPrestasi = $prestasiPosts[0]; @endphp
                    <div class="h-[280px] rounded-3xl overflow-hidden relative group shadow-sm mb-6">
                        <a href="{{ $mainPrestasi->getShowRoute() }}" class="absolute inset-0 z-20"></a>
                        <img src="{{ $mainPrestasi->image ? asset('storage/' . $mainPrestasi->image) : 'https://placehold.co/600x400/1e293b/FFF?text=Prestasi' }}" alt="{{ $mainPrestasi->getTitle() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-5 w-full z-10">
                            <span class="inline-block px-2.5 py-1 bg-indigo-600 text-white text-[10px] font-bold rounded uppercase tracking-wider mb-2 shadow-sm">
                                <span data-t="home.prestasi_badge"></span>
                            </span>
                            <h4 class="text-xl font-bold text-white leading-tight mb-2 line-clamp-2">
                                <a href="{{ $mainPrestasi->getShowRoute() }}" class="hover:text-indigo-300 transition-colors">
                                    {{ $mainPrestasi->getTitle() }}
                                </a>
                            </h4>
                            <div class="text-gray-300 text-xs font-medium">
                                <i class="far fa-calendar-alt mr-1"></i> {{ ($mainPrestasi->published_at ?? $mainPrestasi->created_at)->format('d M Y') }}
                            </div>
                        </div>
                    </div>

                    {{-- List Prestasi (up to 5 items) --}}
                    <div class="flex flex-col gap-4">
                        @foreach ($prestasiPosts->slice(1, 5) as $sidePrestasi)
                        <div class="flex gap-4 group cursor-pointer bg-slate-50 dark:bg-slate-900 p-3 rounded-2xl border border-slate-100 dark:border-slate-800 hover:shadow-sm transition-all duration-300">
                            <a href="{{ $sidePrestasi->getShowRoute() }}" class="w-24 h-20 sm:w-28 sm:h-24 rounded-xl overflow-hidden shrink-0 relative">
                                <img src="{{ $sidePrestasi->image ? asset('storage/' . $sidePrestasi->image) : 'https://placehold.co/300x200/1e293b/FFF?text=Prestasi' }}" alt="{{ $sidePrestasi->getTitle() }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </a>
                            <div class="flex flex-col justify-center flex-1">
                                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-2 mb-1.5 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    <a href="{{ $sidePrestasi->getShowRoute() }}">{{ $sidePrestasi->getTitle() }}</a>
                                </h4>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                                    <i class="far fa-calendar-alt mr-1"></i> {{ ($sidePrestasi->published_at ?? $sidePrestasi->created_at)->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Kolom Pengumuman --}}
                @if(isset($pengumumanPosts) && $pengumumanPosts->isNotEmpty())
                <div class="scroll-reveal">
                    <div class="flex items-center justify-between mb-6 border-b border-slate-200 dark:border-slate-800 pb-2">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">
                            <span data-t="home.pengumuman_col_title"></span>
                        </h3>
                    </div>

                    {{-- Featured Pengumuman (1 item) --}}
                    @php $mainPengumuman = $pengumumanPosts[0]; @endphp
                    <div class="h-[280px] rounded-3xl overflow-hidden relative group shadow-sm mb-6">
                        <a href="{{ $mainPengumuman->getShowRoute() }}" class="absolute inset-0 z-20"></a>
                        <img src="{{ $mainPengumuman->image ? asset('storage/' . $mainPengumuman->image) : 'https://placehold.co/600x400/1e293b/FFF?text=Pengumuman' }}" alt="{{ $mainPengumuman->getTitle() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-5 w-full z-10">
                            <span class="inline-block px-2.5 py-1 bg-indigo-600 text-white text-[10px] font-bold rounded uppercase tracking-wider mb-2 shadow-sm">
                                <span data-t="home.pengumuman_badge"></span>
                            </span>
                            <h4 class="text-xl font-bold text-white leading-tight mb-2 line-clamp-2">
                                <a href="{{ $mainPengumuman->getShowRoute() }}" class="hover:text-indigo-300 transition-colors">
                                    {{ $mainPengumuman->getTitle() }}
                                </a>
                            </h4>
                            <div class="text-gray-300 text-xs font-medium">
                                <i class="far fa-calendar-alt mr-1"></i> {{ ($mainPengumuman->published_at ?? $mainPengumuman->created_at)->format('d M Y') }}
                            </div>
                        </div>
                    </div>

                    {{-- List Pengumuman (up to 5 items) --}}
                    <div class="flex flex-col gap-4">
                        @foreach ($pengumumanPosts->slice(1, 5) as $sidePengumuman)
                        <div class="flex gap-4 group cursor-pointer bg-slate-50 dark:bg-slate-900 p-3 rounded-2xl border border-slate-100 dark:border-slate-800 hover:shadow-sm transition-all duration-300">
                            <a href="{{ $sidePengumuman->getShowRoute() }}" class="w-24 h-20 sm:w-28 sm:h-24 rounded-xl overflow-hidden shrink-0 relative">
                                <img src="{{ $sidePengumuman->image ? asset('storage/' . $sidePengumuman->image) : 'https://placehold.co/300x200/1e293b/FFF?text=Pengumuman' }}" alt="{{ $sidePengumuman->getTitle() }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </a>
                            <div class="flex flex-col justify-center flex-1">
                                <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100 line-clamp-2 mb-1.5 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    <a href="{{ $sidePengumuman->getShowRoute() }}">{{ $sidePengumuman->getTitle() }}</a>
                                </h4>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                                    <i class="far fa-calendar-alt mr-1"></i> {{ ($sidePengumuman->published_at ?? $sidePengumuman->created_at)->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
            </div>
        </div>
    </div>
    @endif
    {{-- ===== AKHIR SECTION PRESTASI & PENGUMUMAN ===== --}}

    <!-- Section Kerjasama (hanya tampil jika ada data) -->
    @if (!$partners_kerjasama->isEmpty() || !$partners_media->isEmpty())
    <div class="py-20 bg-white dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 scroll-reveal">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2"><span data-t="home.partner_title"></span></h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm"><span data-t="home.partner_subtitle"></span></p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Kerjasama -->
                @if (!$partners_kerjasama->isEmpty())
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 text-center"><span data-t="home.partner_kerjasama"></span></h3>
                    <div class="flex flex-wrap justify-center gap-6">
                        @foreach ($partners_kerjasama as $partner)
                            <div class="bg-white dark:bg-slate-900 p-4 border border-slate-100 dark:border-slate-800 rounded-xl flex items-center justify-center w-32 h-20 grayscale hover:grayscale-0 transition-all duration-300 shadow-sm">
                                <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="max-w-full max-h-full object-contain">
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Media Partner -->
                @if (!$partners_media->isEmpty())
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 text-center"><span data-t="home.partner_media"></span></h3>
                    <div class="flex flex-wrap justify-center gap-6">
                        @foreach ($partners_media as $partner)
                            <div class="bg-white dark:bg-slate-900 p-4 border border-slate-100 dark:border-slate-800 rounded-xl flex items-center justify-center w-32 h-20 grayscale hover:grayscale-0 transition-all duration-300 shadow-sm">
                                <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="max-w-full max-h-full object-contain">
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Section Visi Misi (hanya tampil jika sudah diatur) -->
    @if (!empty($settings['visi']) || !empty($settings['misi']))
    @php
        $rawMisi = $settings['misi'] ?? '';
        $misiLines = array_values(array_filter(array_map('trim', explode("\n", $rawMisi))));
        $hasVisi = !empty($settings['visi']);
        $hasMisi = !empty($misiLines);
    @endphp
    <section id="visi-misi" class="relative py-20 lg:py-24 overflow-hidden bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800">
        {{-- Decorative Ambient Elements --}}
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- Header --}}
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-14 scroll-reveal">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-emerald-800 dark:text-emerald-300 text-xs font-bold uppercase tracking-wider mb-4 shadow-sm"
                     style="background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.3);">
                    <i class="fas fa-compass text-emerald-600 dark:text-emerald-400"></i>
                    <span data-t="home.visimisi_badge">{{ __('home.visimisi_badge') }}</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    <span data-t="home.visimisi_title">{{ __('home.visimisi_title') }}</span>
                </h2>
                <p class="mt-4 text-base sm:text-lg text-slate-600 dark:text-slate-400 leading-relaxed font-normal">
                    <span data-t="home.visimisi_subtitle">{{ __('home.visimisi_subtitle') }}</span>
                </p>
            </div>

            {{-- Main Layout Grid --}}
            <div class="grid grid-cols-1 {{ $hasVisi && $hasMisi ? 'lg:grid-cols-12 gap-8 lg:gap-10' : 'max-w-4xl mx-auto' }} items-stretch">
                {{-- Card Visi (Spotlight Visual Card) --}}
                @if ($hasVisi)
                <div class="{{ $hasMisi ? 'lg:col-span-5' : 'w-full' }} flex flex-col scroll-reveal">
                    <div class="relative overflow-hidden rounded-3xl text-white p-7 sm:p-9 shadow-xl flex flex-col justify-between h-full group"
                         style="background: linear-gradient(145deg, #022c22 0%, #064e3b 45%, #0f172a 100%); border: 1px solid rgba(52, 211, 153, 0.35);">
                        {{-- Background Glow & Watermark --}}
                        <div class="absolute -top-20 -right-20 w-60 h-60 rounded-full blur-2xl pointer-events-none group-hover:scale-110 transition-transform duration-700"
                             style="background: rgba(16, 185, 129, 0.2);"></div>
                        <i class="fas fa-quote-right absolute -bottom-6 -right-6 text-emerald-400/10 text-8xl sm:text-9xl pointer-events-none select-none transition-transform duration-700 group-hover:scale-105"></i>

                        {{-- Card Header --}}
                        <div>
                            <div class="flex items-center justify-between gap-4 mb-6">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-emerald-300 text-xs font-bold uppercase tracking-wider"
                                     style="background: rgba(16, 185, 129, 0.18); border: 1px solid rgba(52, 211, 153, 0.4);">
                                    <i class="fas fa-bullseye text-emerald-400"></i>
                                    <span data-t="home.visi_label">{{ __('home.visi_label') }}</span>
                                </div>
                                <span class="text-[11px] font-semibold tracking-wider uppercase text-emerald-300/90 px-2.5 py-1 rounded-lg"
                                      style="background: rgba(2, 44, 34, 0.85); border: 1px solid rgba(4, 120, 87, 0.5);">
                                    <i class="fas fa-calendar-alt mr-1"></i> <span data-t="home.visi_period">{{ __('home.visi_period') }}</span>
                                </span>
                            </div>

                            {{-- Vision Quote Icon & Text --}}
                            <div class="w-11 h-11 rounded-2xl flex items-center justify-center text-emerald-300 mb-5 shadow-inner"
                                 style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(52, 211, 153, 0.4);">
                                <i class="fas fa-quote-left text-lg"></i>
                            </div>

                            <blockquote class="text-lg sm:text-xl font-bold leading-relaxed text-white tracking-tight mb-8 relative z-10">
                                “{{ $settings['visi'] }}”
                            </blockquote>
                        </div>

                        {{-- Strategic Values / Key Pillars --}}
                        <div class="pt-6 relative z-10 mt-auto" style="border-top: 1px solid rgba(16, 185, 129, 0.25);">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold uppercase tracking-wider text-emerald-300 flex items-center gap-1.5">
                                    <i class="fas fa-shapes text-emerald-400"></i> <span data-t="home.visi_pillars_title">{{ __('home.visi_pillars_title') }}</span>
                                </span>
                                <span class="text-[11px] text-emerald-300/70 font-medium">RPJMDes</span>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-emerald-100"
                                      style="background: rgba(2, 44, 34, 0.7); border: 1px solid rgba(16, 185, 129, 0.3);">
                                    <i class="fas fa-arrow-trend-up text-emerald-400 text-[10px]"></i> Maju
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-emerald-100"
                                      style="background: rgba(2, 44, 34, 0.7); border: 1px solid rgba(16, 185, 129, 0.3);">
                                    <i class="fas fa-store text-emerald-400 text-[10px]"></i> Mandiri
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-emerald-100"
                                      style="background: rgba(2, 44, 34, 0.7); border: 1px solid rgba(16, 185, 129, 0.3);">
                                    <i class="fas fa-mosque text-emerald-400 text-[10px]"></i> Agamis
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-emerald-100"
                                      style="background: rgba(2, 44, 34, 0.7); border: 1px solid rgba(16, 185, 129, 0.3);">
                                    <i class="fas fa-scale-balanced text-emerald-400 text-[10px]"></i> Berkeadilan
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-emerald-100"
                                      style="background: rgba(2, 44, 34, 0.7); border: 1px solid rgba(16, 185, 129, 0.3);">
                                    <i class="fas fa-heart-pulse text-emerald-400 text-[10px]"></i> Sejahtera
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Column Misi (Clean, Consistent Agenda Cards) --}}
                @if ($hasMisi)
                <div class="{{ $hasVisi ? 'lg:col-span-7' : 'w-full' }} flex flex-col justify-between scroll-reveal animation-delay-200">
                    <div>
                        {{-- Misi Header Bar --}}
                        <div class="flex items-center justify-between gap-4 mb-4 pb-3 border-b border-slate-200 dark:border-slate-800">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-emerald-800 dark:text-emerald-300 text-xs font-bold uppercase tracking-wider"
                                 style="background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.3);">
                                <i class="fas fa-list-check text-emerald-600 dark:text-emerald-400"></i>
                                <span data-t="home.misi_label">{{ __('home.misi_label') }}</span>
                            </div>
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                                <i class="fas fa-flag text-emerald-600 dark:text-emerald-400"></i>
                                <span>{{ count($misiLines) }} Agenda Prioritas</span>
                            </span>
                        </div>

                        {{-- Mission List Cards --}}
                        <div class="space-y-3">
                            @foreach($misiLines as $index => $line)
                                @php
                                    $cleanText = preg_replace('/^\d+[\.\)\-]?\s*/', '', $line);
                                    $numStr = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                                @endphp
                                <div class="group bg-white dark:bg-slate-800 rounded-2xl p-4 sm:p-5 border border-slate-200/90 dark:border-slate-700/80 shadow-[0_2px_8px_rgb(0,0,0,0.03)] hover:shadow-md hover:border-emerald-500/50 dark:hover:border-emerald-500/50 transition-all duration-200 flex items-start gap-4">
                                    {{-- Unified Number Badge --}}
                                    <div class="shrink-0 pt-0.5">
                                        <div class="w-9 h-9 rounded-xl font-bold text-sm flex items-center justify-center transition-colors duration-200"
                                             style="background: rgba(16, 185, 129, 0.12); color: #047857; border: 1px solid rgba(16, 185, 129, 0.3);">
                                            {{ $numStr }}
                                        </div>
                                    </div>

                                    {{-- Content Text --}}
                                    <p class="text-sm sm:text-[15px] text-slate-700 dark:text-slate-200 leading-relaxed font-normal flex-1">
                                        {{ $cleanText }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- ========== SECTION VIDEO YOUTUBE ========== --}}
    @php $latestVideos = \App\Models\Video::latest('published_at')->take(4)->get(); @endphp
    @if($latestVideos->isNotEmpty())
    <div id="video" class="pt-24 pb-12 bg-white dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12 scroll-reveal">
                <div>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight"><span data-t="home.video_title"></span></h2>
                    <p class="mt-3 text-slate-500 dark:text-slate-400 text-lg"><span data-t="home.video_subtitle"></span></p>
                </div>
                <a href="{{ route('video.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 font-bold rounded-full transition duration-300 shadow-sm border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 whitespace-nowrap">
                    <span data-t="home.video_see_all"></span> <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestVideos as $vid)
                <a href="{{ route('video.detail', $vid) }}"
                   class="group bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-slate-100 dark:border-slate-700 scroll-reveal flex flex-col">
                    <div class="relative aspect-video bg-slate-900 overflow-hidden">
                        <img src="{{ $vid->youtube_thumbnail }}"
                             alt="{{ $vid->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-80 group-hover:opacity-60 transition-opacity duration-300 flex items-center justify-center">
                            <div class="w-14 h-14 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-play text-indigo-600 ml-1 text-xl"></i>
                            </div>
                        </div>
                        @if($vid->is_featured)
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center px-3 py-1 bg-amber-400 text-amber-900 text-[10px] font-bold rounded-full uppercase tracking-widest shadow-sm">
                                <i class="fas fa-star mr-1.5 text-[10px]"></i> <span data-t="home.video_featured"></span>
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm leading-snug line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors mb-3 flex-1">
                            {{ $vid->title }}
                        </h3>
                        <div class="flex items-center text-xs text-slate-400 font-medium mt-auto">
                            <i class="far fa-calendar-alt mr-2"></i>
                            {{ $vid->published_at ? \Carbon\Carbon::parse($vid->published_at)->translatedFormat('d M Y') : '' }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    {{-- ========== AKHIR SECTION VIDEO ========== --}}

    {{-- ========== SECTION INSTAGRAM REELS ========== --}}
    @if(isset($instagramReels) && $instagramReels->isNotEmpty())
    <div id="reels" class="pt-12 pb-24 bg-white dark:bg-slate-950 border-t border-slate-100 dark:border-slate-800" x-data="{ reelModalOpen: false, selectedReelUrl: '' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 scroll-reveal">
                <div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                        <span class="text-slate-900 dark:text-white font-black italic tracking-tighter">9/16</span> 
                        <span>Reels</span>
                    </h2>
                    <p class="mt-3 text-slate-500 dark:text-slate-400 text-lg"><span data-t="home.reels_subtitle"></span></p>
                </div>
            </div>

            {{-- Splide Carousel --}}
            <section class="splide" id="reels-carousel" data-options='{"type":"slide","perPage":5,"perMove":1,"gap":"1.5rem","pagination":false,"arrows":true,"breakpoints":{"1024":{"perPage":4},"768":{"perPage":3},"640":{"perPage":2}}}'>
                <div class="splide__track px-2 py-4">
                    <ul class="splide__list">
                        @foreach($instagramReels as $reel)
                        <li class="splide__slide">
                            <button type="button" @click="reelModalOpen = true; selectedReelUrl = '{{ $reel->embed_url }}'" class="block w-full text-left group relative aspect-[9/16] rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl hover:shadow-slate-500/20 transition-all duration-300 transform hover:-translate-y-2 border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800">
                                
                                {{-- Thumbnail --}}
                                <img src="{{ $reel->thumbnail_url }}" alt="{{ $reel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                
                                {{-- Gradient Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                                
                                {{-- Play Icon overlay (Center) --}}
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm border border-white/50 rounded-full flex items-center justify-center transform scale-75 group-hover:scale-100 transition-all duration-300">
                                        <i class="fas fa-play text-white text-2xl ml-1"></i>
                                    </div>
                                </div>
                                
                                {{-- Content (Bottom) --}}
                                <div class="absolute bottom-0 left-0 p-4 w-full z-20">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-6 h-6 bg-white rounded-full flex items-center justify-center shadow">
                                            <i class="fab fa-instagram text-black text-[12px]"></i>
                                        </div>
                                    </div>
                                    <h3 class="text-white font-bold text-sm leading-snug line-clamp-3 group-hover:text-slate-300 transition-colors drop-shadow-md">
                                        {{ $reel->title }}
                                    </h3>
                                </div>
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        </div>

        {{-- Modal Player --}}
        <div x-show="reelModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4" style="display: none;" x-transition.opacity>
            <div class="relative w-full max-w-sm aspect-[9/16] bg-black rounded-xl overflow-hidden shadow-2xl" @click.away="reelModalOpen = false; selectedReelUrl = ''">
                <button @click="reelModalOpen = false; selectedReelUrl = ''" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors z-[110]">
                    <i class="fas fa-times text-3xl"></i>
                </button>
                <template x-if="selectedReelUrl">
                    <iframe :src="selectedReelUrl" class="w-full h-full" frameborder="0" scrolling="no" allowtransparency="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowfullscreen></iframe>
                </template>
            </div>
        </div>
    </div>
    @endif
    {{-- ========== AKHIR SECTION INSTAGRAM REELS ========== --}}

    <style>
        /* Typography & Utilities */

        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { transform: scaleX(0); }
            to { transform: scaleX(1); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
        .animate-scale-in { animation: scaleIn 0.8s ease-out forwards; transform-origin: center; }
        .animation-delay-200 { animation-delay: 200ms; }
        .animation-delay-400 { animation-delay: 400ms; }

        /* Scroll Reveal Animation */
        .scroll-reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease-out, transform 0.8s ease-out; }
        .scroll-reveal.revealed { opacity: 1; transform: translateY(0); }

        /* Splide Customization */
        .splide__arrow { background: white !important; border: 1px solid #e5e7eb; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        .dark .splide__arrow { background: #1e293b !important; border-color: #334155; }
        .splide__arrow:hover { background: #f8fafc !important; transform: scale(1.05); }
        
        .splide__pagination__page { background: #e5e7eb !important; }
        .dark .splide__pagination__page { background: #334155 !important; }
        .splide__pagination__page.is-active { background: #2563eb !important; transform: scale(1.1); }
        .dark .splide__pagination__page.is-active { background: #3b82f6 !important; }

        html { scroll-behavior: smooth; }
        
        /* Prose Styling */
        .prose { color: #475569; }
        .dark .prose { color: #94a3b8; }
        .prose p { margin-top: 1.25em; margin-bottom: 1.25em; }
        .prose h1, .prose h2, .prose h3 { color: #0f172a; }
        .dark .prose h1, .dark .prose h2, .dark .prose h3 { color: #f8fafc; }
        .prose a { color: #2563eb; text-decoration: none; font-weight: 500; }
        .prose a:hover { text-decoration: underline; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Scroll Reveal
            const revealElements = document.querySelectorAll('.scroll-reveal');
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) { entry.target.classList.add('revealed'); }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -20px 0px' });
            revealElements.forEach(element => { revealObserver.observe(element); });

            // Counters
            const counters = document.querySelectorAll('.counter');
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = parseInt(counter.getAttribute('data-target'));
                        const duration = 1500;
                        const increment = target / (duration / 16);
                        let current = 0;
                        const updateCounter = () => {
                            current += increment;
                            if (current < target) {
                                counter.textContent = Math.ceil(current) + '+';
                                requestAnimationFrame(updateCounter);
                            } else {
                                counter.textContent = target + '+';
                            }
                        };
                        updateCounter();
                        counterObserver.unobserve(counter);
                    }
                });
            }, { threshold: 0.5 });
            counters.forEach(counter => { counterObserver.observe(counter); });
        });
    </script>
</x-public-layout>
