<x-public-layout>
    <x-slot name="title">
        {{ $video->title }} - Galeri Video Desa Cigagade
    </x-slot>

    <div class="bg-gray-950 min-h-screen">

        {{-- Video Player Section --}}
        <div class="bg-black">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {{-- Back button --}}
                <a href="{{ route('video.index') }}"
                   class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition mb-6 group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                    <span data-t="backToVideoList">Kembali ke Daftar Video</span>
                </a>

                {{-- YouTube Embed --}}
                <div class="relative w-full rounded-2xl overflow-hidden shadow-2xl" style="padding-top: 56.25%;">
                    <iframe
                        src="{{ $video->embed_url }}?rel=0&modestbranding=1"
                        title="{{ $video->title }}"
                        class="absolute top-0 left-0 w-full h-full"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                    </iframe>
                </div>

                {{-- Video Info --}}
                <div class="mt-8 pb-8 border-b border-slate-800">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="inline-flex items-center px-3 py-1 bg-indigo-500/20 text-indigo-300 text-[10px] font-bold rounded-full uppercase tracking-widest shadow-sm">
                            <i class="fas fa-play-circle mr-1.5"></i> Video
                        </span>
                        @if($video->is_featured)
                        <span class="inline-flex items-center px-3 py-1 bg-amber-500/20 text-amber-400 text-[10px] font-bold rounded-full uppercase tracking-widest shadow-sm">
                            <i class="fas fa-star mr-1.5"></i> <span data-t="featured">Unggulan</span>
                        </span>
                        @endif
                        <span class="text-slate-400 text-sm font-medium">
                            <i class="far fa-calendar-alt mr-1.5"></i>
                            {{ $video->published_at ? \Carbon\Carbon::parse($video->published_at)->translatedFormat('d F Y') : '' }}
                        </span>
                    </div>

                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-4 leading-tight">
                        {{ $video->title }}
                    </h1>

                    @if($video->description)
                    <div class="mt-4 p-4 bg-gray-900 rounded-xl border border-gray-800">
                        <h3 class="text-sm font-semibold text-gray-400 mb-2 uppercase tracking-wider" data-t="description">Deskripsi</h3>
                        <p class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $video->description }}</p>
                    </div>
                    @endif

                    {{-- Watch on YouTube button --}}
                    <div class="mt-8">
                        <a href="{{ $video->youtube_url }}" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-full transition duration-300 transform hover:scale-105 shadow-lg">
                            <i class="fab fa-youtube text-xl"></i>
                            <span data-t="watchOnYoutube">Tonton di YouTube</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Videos --}}
        @if($relatedVideos->isNotEmpty())
        <div class="bg-slate-950 py-16">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-white tracking-tight" data-t="otherVideos">Video Lainnya</h2>
                    <div class="w-16 h-1 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-full mt-3"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedVideos as $related)
                    <a href="{{ route('video.detail', $related) }}"
                       class="group flex gap-4 bg-slate-900 rounded-2xl overflow-hidden hover:bg-slate-800 transition duration-300 border border-slate-800/50 shadow-sm hover:shadow-lg">
                        {{-- Thumbnail --}}
                        <div class="relative w-36 flex-shrink-0 bg-slate-800">
                            <img src="{{ $related->youtube_thumbnail }}"
                                 alt="{{ $related->title }}"
                                 class="w-full h-full object-cover group-hover:opacity-75 transition duration-300">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 shadow-lg">
                                    <i class="fas fa-play text-indigo-600 ml-1"></i>
                                </div>
                            </div>
                        </div>
                        {{-- Info --}}
                        <div class="py-3 pr-4 flex-1 min-w-0 flex flex-col justify-center">
                            <h3 class="text-sm font-bold text-white line-clamp-2 leading-snug group-hover:text-indigo-400 transition-colors mb-2">
                                {{ $related->title }}
                            </h3>
                            <p class="text-xs text-slate-500 font-medium">
                                {{ $related->published_at ? \Carbon\Carbon::parse($related->published_at)->translatedFormat('d M Y') : '' }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</x-public-layout>
