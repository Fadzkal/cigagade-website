<x-public-layout>
    <x-slot name="title">
        Prestasi & Pengumuman - Desa Cigagade
    </x-slot>

    <div class="relative min-h-screen pb-20 pt-12 bg-white dark:bg-slate-950 antialiased selection:bg-emerald-100 selection:text-emerald-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-12 md:mb-16 border-b border-slate-200 dark:border-slate-800 pb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 dark:text-white mb-4 tracking-tight" data-t="infoCenter">
                    Pusat Informasi Desa
                </h1>
                <p class="text-slate-600 dark:text-slate-400 max-w-2xl text-lg font-normal" data-t="infoCenterDesc">
                    Pantau terus pencapaian membanggakan dan pengumuman resmi dari Pemerintah Desa Cigagade.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">
                
                <!-- KOLOM POJOK PRESTASI -->
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-3">
                        <span class="w-1 h-6 bg-emerald-600 rounded-full"></span>
                        <span data-t="achievement">Prestasi Desa</span>
                    </h2>

                    <div class="flex flex-col">
                        @forelse($prestasiPosts as $post)
                            <div class="group relative block border-b border-slate-200 dark:border-slate-800/60 py-6 first:pt-0 last:border-0 transition-colors duration-300">
                                <a href="{{ $post->getShowRoute() }}" class="absolute inset-0 z-20"></a>
                                <article class="flex flex-col sm:flex-row gap-6 items-start">
                                    
                                    <!-- Image Wrapper -->
                                    <div class="w-full sm:w-56 aspect-[16/10] flex-shrink-0 rounded-xl overflow-hidden relative bg-slate-100 dark:bg-slate-800">
                                        @if ($post->image)
                                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->getTitle() }}" class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-105">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="fas fa-image text-slate-300 dark:bg-slate-800 text-2xl"></i>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 dark:group-hover:bg-white/5 transition-colors duration-500 ease-out z-10 pointer-events-none"></div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-grow flex flex-col py-1">
                                        <span class="text-xs font-bold tracking-widest uppercase text-blue-700 dark:text-blue-400 mb-2" data-t="prestasiLabel">
                                            Prestasi
                                        </span>
                                        
                                        <h3 class="text-lg md:text-xl font-bold text-slate-900 dark:text-slate-100 mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 ease-out line-clamp-3 leading-snug">
                                            {{ $post->getTitle() }}
                                        </h3>
                                        
                                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-auto">
                                            {{ ($post->published_at ?? $post->created_at)->translatedFormat('d F Y') }}
                                        </p>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="py-12 text-center">
                                <i class="fas fa-trophy text-4xl text-slate-200 dark:text-slate-700 mb-4"></i>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1" data-t="noAchievement">Belum Ada Prestasi</h3>
                                <p class="text-slate-500 text-sm" data-t="noAchievementDesc">Jadilah yang pertama menorehkan prestasi!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- KOLOM PENGUMUMAN -->
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-3">
                        <span class="w-1 h-6 bg-emerald-600 rounded-full"></span>
                        <span data-t="announcement">Pengumuman</span>
                    </h2>

                    <div class="flex flex-col">
                        @forelse($pengumumanPosts as $post)
                            <div class="group relative block border-b border-slate-200 dark:border-slate-800/60 py-6 first:pt-0 last:border-0 transition-colors duration-300">
                                <a href="{{ $post->getShowRoute() }}" class="absolute inset-0 z-20"></a>
                                <article class="flex flex-col sm:flex-row gap-6 items-start">
                                    
                                    <div class="w-full sm:w-56 aspect-[16/10] flex-shrink-0 rounded-xl overflow-hidden relative bg-slate-100 dark:bg-slate-800">
                                        @if ($post->image)
                                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->getTitle() }}" class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-105">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="fas fa-image text-slate-300 dark:text-slate-600 text-2xl"></i>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 dark:group-hover:bg-white/5 transition-colors duration-500 ease-out z-10 pointer-events-none"></div>
                                    </div>

                                    <div class="flex-grow flex flex-col py-1">
                                        <span class="text-xs font-bold tracking-widest uppercase text-emerald-700 dark:text-emerald-400 mb-2" data-t="infoPenting">
                                            Info Penting
                                        </span>
                                        
                                        <h3 class="text-lg md:text-xl font-bold text-slate-900 dark:text-slate-100 mb-3 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300 ease-out line-clamp-3 leading-snug">
                                            {{ $post->getTitle() }}
                                        </h3>
                                        
                                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-auto">
                                            {{ ($post->published_at ?? $post->created_at)->diffForHumans() }}
                                        </p>
                                    </div>
                                </article>
                            </a>
                        @empty
                            <div class="py-12 text-center">
                                <i class="fas fa-bullhorn text-4xl text-slate-200 dark:text-slate-700 mb-4"></i>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1" data-t="noAnnouncement">Tidak Ada Pengumuman</h3>
                                <p class="text-slate-500 text-sm" data-t="noAnnouncementDesc">Belum ada informasi terbaru saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-public-layout>