<x-public-layout>
    <x-slot name="title">
        Galeri Video & Dokumentasi - Desa Cigagade
    </x-slot>

    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 py-24 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-500 rounded-full filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-teal-500 rounded-full filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 scroll-reveal tracking-tight" data-t="latestVideos">
                Video & Liputan Desa
            </h1>
            <p class="text-xl md:text-2xl text-emerald-100/80 max-w-3xl mx-auto mb-8 scroll-reveal animation-delay-200" data-t="videoSubtitle">
                Dokumentasi kegiatan, pelayanan, dan potensi kearifan lokal Desa Cigagade
            </p>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                <path d="M0 0L60 8C120 16 240 32 360 42.7C480 53 600 59 720 58.7C840 59 960 53 1080 48C1200 43 1320 37 1380 34.7L1440 32V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V0Z" class="fill-white dark:fill-slate-900"/>
            </svg>
        </div>
    </section>

    <div class="bg-white dark:bg-gradient-to-b dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 py-20 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Featured Video --}}
            @if($featuredVideo)
            <div class="mb-20 scroll-reveal">
                <div class="flex items-center gap-3 mb-6">
                    <span class="inline-flex items-center px-4 py-1.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded-full text-xs font-bold uppercase tracking-widest shadow-sm">
                        <i class="fas fa-star mr-2"></i> <span data-t="featuredVideo">Video Unggulan</span>
                    </span>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-sm border border-slate-100 dark:border-slate-700 group hover:shadow-xl transition-all duration-300">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                        {{-- Embed / Thumbnail --}}
                        <div class="relative aspect-video bg-slate-900 overflow-hidden">
                            <a href="{{ route('video.detail', $featuredVideo) }}" class="block w-full h-full relative group">
                                <img src="{{ $featuredVideo->youtube_thumbnail }}"
                                     alt="{{ $featuredVideo->title }}"
                                     class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-80 group-hover:opacity-60 transition-opacity duration-300 flex items-center justify-center">
                                    <div class="w-16 h-16 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-play text-indigo-600 text-xl ml-1"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        {{-- Info --}}
                        <div class="p-8 lg:p-12 flex flex-col justify-center">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="inline-flex items-center px-3 py-1 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 text-[10px] font-bold rounded-full uppercase tracking-widest shadow-sm">
                                    <i class="fas fa-play-circle mr-1.5"></i> Video
                                </span>
                                <span class="text-slate-400 text-xs font-semibold">
                                    {{ $featuredVideo->published_at ? \Carbon\Carbon::parse($featuredVideo->published_at)->translatedFormat('d M Y') : '' }}
                                </span>
                            </div>
                            <h2 class="text-2xl lg:text-3xl font-bold text-slate-900 dark:text-white mb-4 leading-snug">
                                {{ $featuredVideo->title }}
                            </h2>
                            @if($featuredVideo->description)
                            <p class="text-slate-500 dark:text-slate-400 mb-8 leading-relaxed">{{ Str::limit($featuredVideo->description, 150) }}</p>
                            @endif
                            <a href="{{ route('video.detail', $featuredVideo) }}"
                               class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-full transition duration-300 shadow-sm w-fit">
                                <i class="fas fa-play mr-2"></i> <span data-t="watchNow">Tonton Sekarang</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Video Grid --}}
            @if($videos->isEmpty())
                <div class="text-center py-20 scroll-reveal">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-slate-100 dark:bg-slate-800 mb-6">
                        <i class="fas fa-video text-4xl text-slate-300 dark:text-slate-600"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-slate-900 dark:text-white mb-4 tracking-tight" data-t="noVideos">Belum Ada Video</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-lg mb-8 max-w-md mx-auto" data-t="noVideosDesc">
                        Saat ini belum ada video yang dipublikasikan.
                    </p>
                    <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 transition duration-300 shadow-sm">
                        <i class="fas fa-home mr-3"></i> <span data-t="backToHome">Kembali ke Beranda</span>
                    </a>
                </div>
            @else
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight" data-t="allVideos">Semua Video</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($videos as $video)
                    <a href="{{ route('video.detail', $video) }}"
                       class="group bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 scroll-reveal border border-slate-100 dark:border-slate-700 flex flex-col">
                        {{-- Thumbnail --}}
                        <div class="relative aspect-video bg-slate-900 overflow-hidden">
                            <img src="{{ $video->youtube_thumbnail }}"
                                 alt="{{ $video->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-80 group-hover:opacity-60 transition-opacity duration-300 flex items-center justify-center">
                                <div class="w-14 h-14 bg-white/90 backdrop-blur-md rounded-full flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-play text-indigo-600 ml-1 text-xl"></i>
                                </div>
                            </div>
                            @if($video->is_featured)
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-3 py-1 bg-amber-400 text-amber-900 text-[10px] font-bold rounded-full uppercase tracking-widest shadow-sm">
                                    <i class="fas fa-star mr-1.5 text-[10px]"></i> <span data-t="featured">Unggulan</span>
                                </span>
                            </div>
                            @endif
                        </div>
                        {{-- Info --}}
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="font-bold text-slate-900 dark:text-white text-sm leading-snug line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors mb-3 flex-1">
                                {{ $video->title }}
                            </h3>
                            <div class="flex items-center text-xs text-slate-400 font-medium mt-auto">
                                <i class="far fa-calendar-alt mr-2"></i>
                                {{ $video->published_at ? \Carbon\Carbon::parse($video->published_at)->translatedFormat('d M Y') : 'Tanpa Tanggal' }}
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($videos->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $videos->links() }}
                </div>
                @endif
            @endif
        </div>
    </div>
</x-public-layout>
