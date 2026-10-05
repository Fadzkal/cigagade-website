<x-public-layout>
    <x-slot name="title">
        {{ $umkm->name }} - UMKM Desa Cigagade
    </x-slot>

    <div class="relative pt-28 pb-16 bg-gradient-to-b from-slate-50 via-white to-slate-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 min-h-screen">

        {{-- Background decorative glows --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/10 dark:bg-emerald-500/5 rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 -right-32 w-96 h-96 bg-teal-500/10 dark:bg-teal-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            {{-- Breadcrumb --}}
            <nav class="flex items-center text-xs font-medium text-slate-500 dark:text-slate-400 mb-6">
                <a href="{{ route('home') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">Beranda</a>
                <span class="mx-2 text-slate-300 dark:text-slate-600">/</span>
                <a href="{{ route('umkm.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">Katalog UMKM</a>
                <span class="mx-2 text-slate-300 dark:text-slate-600">/</span>
                <span class="text-slate-800 dark:text-slate-200 truncate">{{ $umkm->name }}</span>
            </nav>

            {{-- Main Product Card --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-xl overflow-hidden mb-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">

                    {{-- Product Image (5 cols) --}}
                    <div class="lg:col-span-5 bg-slate-100 dark:bg-slate-800 relative">
                        <div class="aspect-4/3 lg:aspect-auto lg:h-full w-full overflow-hidden">
                            <img src="{{ $umkm->image_url }}" alt="{{ $umkm->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-xl text-xs font-bold bg-white/95 dark:bg-slate-900/95 backdrop-blur-md text-emerald-700 dark:text-emerald-400 shadow-sm border border-slate-200/50 dark:border-slate-700/50">
                                {{ $umkm->category }}
                            </span>
                        </div>
                    </div>

                    {{-- Product Info & Contact (7 cols) --}}
                    <div class="lg:col-span-7 p-6 sm:p-8 lg:p-10 flex flex-col justify-between space-y-6">
                        <div class="space-y-4">
                            <div>
                                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                                    {{ $umkm->name }}
                                </h1>
                                @if($umkm->address)
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 flex items-center gap-1.5">
                                        <i class="fas fa-map-marker-alt text-emerald-500"></i>
                                        <span>{{ $umkm->address }}</span>
                                    </p>
                                @endif
                            </div>

                            {{-- Price Box --}}
                            <div class="bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-100 dark:border-emerald-900/40 rounded-2xl p-4 sm:p-5 flex items-baseline justify-between">
                                <div>
                                    <span class="text-xs font-semibold text-emerald-800 dark:text-emerald-400 uppercase tracking-wider block">Harga Produk</span>
                                    <div class="text-2xl sm:text-3xl font-black text-emerald-700 dark:text-emerald-400 mt-0.5">
                                        Rp {{ number_format($umkm->price, 0, ',', '.') }}
                                        @if($umkm->unit)
                                            <span class="text-sm font-medium text-slate-500 dark:text-slate-400">/ {{ $umkm->unit }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right text-xs text-slate-400">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/60 text-emerald-800 dark:text-emerald-200 font-semibold text-[11px]">
                                        <i class="fas fa-check-circle text-emerald-600 dark:text-emerald-400"></i>
                                        Produk Lokal Asli
                                    </span>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2 flex items-center gap-1.5">
                                    <i class="fas fa-circle-info text-emerald-500"></i>
                                    Deskripsi Produk & Ketentuan Pemesanan
                                </h3>
                                <div class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line bg-slate-50/70 dark:bg-slate-800/40 p-4 sm:p-5 rounded-2xl border border-slate-100 dark:border-slate-800">
                                    {{ $umkm->description }}
                                </div>
                            </div>

                            {{-- Seller Profile Card --}}
                            <div class="bg-slate-50 dark:bg-slate-800/60 rounded-2xl p-4 sm:p-5 border border-slate-200/60 dark:border-slate-700/60 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-bold text-lg flex-shrink-0">
                                        {{ strtoupper(substr($umkm->seller_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Pelaku UMKM / Penjual</p>
                                        <h4 class="font-bold text-base text-slate-800 dark:text-white">{{ $umkm->seller_name }}</h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1 mt-0.5">
                                            <i class="fab fa-whatsapp text-emerald-500"></i>
                                            {{ $umkm->phone }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Action Button: Hubungi Penjual via WhatsApp --}}
                        <div class="pt-2">
                            <a href="{{ $umkm->whatsapp_url }}" target="_blank"
                               class="w-full py-4 px-6 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 active:scale-98 text-white rounded-2xl font-bold text-base shadow-lg shadow-emerald-600/25 transition-all flex items-center justify-center gap-3 group">
                                <i class="fab fa-whatsapp text-2xl group-hover:scale-110 transition-transform"></i>
                                <span>Hubungi Penjual via WhatsApp</span>
                            </a>
                            <p class="text-[11px] text-center text-slate-400 dark:text-slate-500 mt-2">
                                Klik tombol di atas untuk membuka obrolan langsung di WhatsApp dengan format pesan otomatis mengenai ketersediaan produk.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Related Products --}}
            @if ($related->count() > 0)
                <div class="mt-12 space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white">
                                Produk UMKM Lainnya di Cigagade
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Komoditas dan kreasi warga desa Cigagade yang layak Anda coba</p>
                        </div>
                        <a href="{{ route('umkm.index') }}" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-1">
                            Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach ($related as $rel)
                            <div class="group bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col">
                                <a href="{{ route('umkm.show', $rel->slug) }}" class="relative aspect-4/3 overflow-hidden bg-slate-100 dark:bg-slate-800 block">
                                    <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute top-2 left-2">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold bg-white/90 dark:bg-slate-900/90 text-emerald-700 dark:text-emerald-400">
                                            {{ $rel->category }}
                                        </span>
                                    </div>
                                </a>
                                <div class="p-4 flex flex-col flex-1">
                                    <a href="{{ route('umkm.show', $rel->slug) }}" class="font-bold text-sm text-slate-800 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 transition line-clamp-1">
                                        {{ $rel->name }}
                                    </a>
                                    <div class="font-bold text-sm text-emerald-600 dark:text-emerald-400 mt-1">
                                        Rp {{ number_format($rel->price, 0, ',', '.') }}
                                        @if($rel->unit)
                                            <span class="text-[10px] text-slate-400 font-normal">/ {{ $rel->unit }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-3 pt-2 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                                        <span class="text-slate-500 dark:text-slate-400 truncate text-[11px]">{{ $rel->seller_name }}</span>
                                        <a href="{{ $rel->whatsapp_url }}" target="_blank"
                                           class="text-emerald-600 hover:text-emerald-700 font-semibold text-xs flex items-center gap-1"
                                           title="Chat WhatsApp">
                                            <i class="fab fa-whatsapp"></i> Chat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    </div>
</x-public-layout>
