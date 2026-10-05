<x-public-layout>
    <x-slot name="title">Potensi Desa — Desa Cigagade</x-slot>

    <div class="py-12 md:py-20 min-h-screen bg-white dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Header --}}
            <div class="mb-12 pt-8 text-center max-w-3xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    {{ $activeCategory ? $activeCategory->name : 'Potensi Desa Cigagade' }}
                </h1>
                
                <p class="text-slate-500 dark:text-slate-400 text-lg" data-t="bengkelIlmuSubtitle">
                    Ruang informasi potensi pertanian, perkebunan, UMKM, kearifan lokal, dan inovasi Desa Cigagade.
                </p>
            </div>

            {{-- Sub-Category Tabs --}}
            <div class="flex flex-wrap justify-center gap-2 mb-16">
                <a href="{{ route('bengkel-ilmu.list') }}"
                   class="px-5 py-2 rounded-lg text-sm font-medium transition-colors {{ !request('kategori') ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}"
                   data-t="all">
                    Semua
                </a>
                @foreach ($bengkelCategories as $cat)
                <a href="{{ route('bengkel-ilmu.list', ['kategori' => $cat->slug]) }}"
                   class="px-5 py-2 rounded-lg text-sm font-medium transition-colors {{ request('kategori') === $cat->slug ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                    {{ $cat->name }}
                </a>
                @endforeach
            </div>

            {{-- Articles Grid --}}
            @if ($posts->isEmpty())
                <div class="text-center py-24 border border-dashed border-slate-200 dark:border-slate-800 rounded-2xl">
                    <p class="text-slate-500 dark:text-slate-400" data-t="noContent">Belum ada konten di kategori ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12 mb-16">
                    @foreach ($posts as $post)
                    <article class="group flex flex-col">
                        {{-- Thumbnail --}}
                        <a href="{{ $post->getShowRoute() }}" class="block aspect-[4/3] w-full overflow-hidden rounded-xl bg-slate-100 dark:bg-slate-800 mb-4 relative">
                            <img src="{{ $post->image ? asset('storage/' . $post->image) : 'https://placehold.co/600x400/064e3b/ffffff?text=Potensi+Desa' }}"
                                 alt="{{ $post->getTitle() }}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            
                            {{-- Category Badge --}}
                            <div class="absolute top-3 left-3">
                                <span class="px-3 py-1 bg-white/95 dark:bg-slate-900/95 text-slate-900 dark:text-white text-[11px] font-semibold rounded-md uppercase tracking-wider">
                                    {{ $post->category->name }}
                                </span>
                            </div>
                        </a>

                        {{-- Content --}}
                        <div class="flex flex-col flex-1">
                            <h2 class="font-bold text-xl text-slate-900 dark:text-white leading-tight mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                <a href="{{ $post->getShowRoute() }}">{{ $post->getTitle() }}</a>
                            </h2>

                            <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-2 mb-4 flex-1">
                                {{ $post->getExcerpt() }}
                            </p>

                            <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 pt-3 border-t border-slate-100 dark:border-slate-800">
                                <span class="font-medium text-slate-700 dark:text-slate-300">{{ $post->user->name ?? 'Admin' }}</span>
                                <span>{{ ($post->published_at ?? $post->created_at)->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $posts->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>
</x-public-layout>
