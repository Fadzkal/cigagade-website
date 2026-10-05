<x-public-layout>
    <x-slot name="title">
        Katalog UMKM & Produk Unggulan - Desa Cigagade
    </x-slot>

    <div class="relative pt-28 pb-16 bg-gradient-to-b from-slate-50 via-white to-slate-50 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 min-h-screen"
         x-data="{
            modalOpen: false,
            activeProduct: null,
            openDetail(product) {
                this.activeProduct = product;
                this.modalOpen = true;
            }
         }">

        {{-- Background decorative elements --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/10 dark:bg-emerald-500/5 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 -right-32 w-96 h-96 bg-teal-500/10 dark:bg-teal-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            {{-- Breadcrumb --}}
            <nav class="flex items-center text-xs font-medium text-slate-500 dark:text-slate-400 mb-6">
                <a href="{{ route('home') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">Beranda</a>
                <span class="mx-2 text-slate-300 dark:text-slate-600">/</span>
                <span class="text-slate-800 dark:text-slate-200">Katalog UMKM</span>
            </nav>

            {{-- Header Section --}}
            <div class="max-w-3xl mb-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60 mb-3">
                    <i class="fas fa-store text-[11px]"></i>
                    Ekonomi & Produk Komoditas Warga
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                    Sentra UMKM & Produk Unggulan <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Desa Cigagade</span>
                </h1>
                <p class="mt-3 text-base text-slate-600 dark:text-slate-300 leading-relaxed">
                    Dukung kemandirian ekonomi warga dengan membeli produk lokal, hasil tani segar, olahan makanan tradisional, dan kerajinan khas Balubur Limbangan.
                </p>
            </div>

            {{-- Search & Filter Bar --}}
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-2xl p-4 sm:p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm mb-10">
                <form action="{{ route('umkm.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 items-center justify-between">
                    <div class="relative w-full md:w-96">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-search text-xs"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari produk, komoditas, atau penjual..."
                               class="w-full pl-9 pr-4 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-slate-800 dark:text-white placeholder-slate-400 transition">
                    </div>

                    <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                        <a href="{{ route('umkm.index') }}"
                           class="px-3.5 py-2 rounded-xl text-xs font-semibold transition border {{ !request('category') ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-emerald-400' }}">
                            Semua ({{ $totalAll }})
                        </a>
                        @foreach ($categories as $cat)
                            <a href="{{ route('umkm.index', array_merge(request()->query(), ['category' => $cat])) }}"
                               class="px-3.5 py-2 rounded-xl text-xs font-semibold transition border {{ request('category') === $cat ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs' : 'bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700 hover:border-emerald-400' }}">
                                {{ $cat }}
                            </a>
                        @endforeach
                    </div>
                </form>
            </div>

            {{-- Product Grid --}}
            @if ($umkms->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach ($umkms as $item)
                        @php
                            $productData = [
                                'id' => $item->id,
                                'name' => $item->name,
                                'slug' => $item->slug,
                                'seller_name' => $item->seller_name,
                                'phone' => $item->phone,
                                'category' => $item->category,
                                'price' => number_format($item->price, 0, ',', '.'),
                                'unit' => $item->unit,
                                'formatted_price' => $item->formatted_price,
                                'description' => $item->description,
                                'address' => $item->address,
                                'image_url' => $item->image_url,
                                'whatsapp_url' => $item->whatsapp_url,
                                'detail_url' => route('umkm.show', $item->slug),
                            ];
                        @endphp
                        <div class="group bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-800/80 hover:border-emerald-400 dark:hover:border-emerald-600 shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col transform hover:-translate-y-1">
                            
                            {{-- Image Container --}}
                            <div class="relative aspect-4/3 overflow-hidden bg-slate-100 dark:bg-slate-800 cursor-pointer"
                                 @click='openDetail(@json($productData))'>
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                
                                {{-- Category Tag --}}
                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-emerald-700 dark:text-emerald-400 border border-slate-200/50 dark:border-slate-700/50 shadow-xs">
                                        {{ $item->category }}
                                    </span>
                                </div>

                                {{-- Price Badge Overlay --}}
                                <div class="absolute bottom-3 right-3">
                                    <span class="px-3 py-1.5 rounded-xl text-xs font-black bg-emerald-600/95 backdrop-blur-md text-white shadow-md">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                        @if($item->unit)
                                            <span class="text-[10px] font-normal opacity-90">/ {{ $item->unit }}</span>
                                        @endif
                                    </span>
                                </div>
                            </div>

                            {{-- Product Body --}}
                            <div class="p-5 flex flex-col flex-1">
                                <h3 class="font-bold text-lg text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors line-clamp-1 cursor-pointer"
                                    @click='openDetail(@json($productData))'>
                                    {{ $item->name }}
                                </h3>

                                <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-2 leading-relaxed flex-1">
                                    {{ $item->description }}
                                </p>

                                {{-- Seller Info --}}
                                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                                    <div class="flex items-center gap-1.5 truncate">
                                        <div class="w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-bold text-[10px] flex-shrink-0">
                                            {{ strtoupper(substr($item->seller_name, 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-slate-700 dark:text-slate-300 truncate">{{ $item->seller_name }}</span>
                                    </div>
                                    @if($item->address)
                                        <div class="text-[11px] text-slate-400 dark:text-slate-500 truncate flex items-center gap-1 ml-2" title="{{ $item->address }}">
                                            <i class="fas fa-map-marker-alt text-emerald-500 text-[10px]"></i>
                                            <span class="truncate">{{ Str::limit($item->address, 20) }}</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Action Buttons --}}
                                <div class="mt-4 pt-2 grid grid-cols-2 gap-2">
                                    <button type="button"
                                            @click='openDetail(@json($productData))'
                                            class="w-full py-2.5 px-3 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 text-xs font-semibold transition flex items-center justify-center gap-1.5">
                                        <i class="fas fa-eye text-slate-400 text-xs"></i>
                                        Detail
                                    </button>

                                    <a href="{{ $item->whatsapp_url }}" target="_blank"
                                       class="w-full py-2.5 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-xs font-semibold shadow-xs shadow-emerald-600/20 transition flex items-center justify-center gap-1.5">
                                        <i class="fab fa-whatsapp text-sm"></i>
                                        Pesan WA
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($umkms->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $umkms->links() }}
                    </div>
                @endif
            @else
                <div class="bg-white/60 dark:bg-slate-900/60 backdrop-blur-md rounded-3xl p-12 text-center border border-slate-200/80 dark:border-slate-800 max-w-lg mx-auto">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mx-auto text-2xl mb-4">
                        <i class="fas fa-store-slash"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">Tidak Ada Produk Ditemukan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                        @if(request('search') || request('category'))
                            Tidak ada produk yang cocok dengan pencarian kata kunci atau kategori yang Anda pilih. Silakan reset filter.
                        @else
                            Saat ini belum ada produk UMKM yang dipublikasikan.
                        @endif
                    </p>
                    <div class="mt-5">
                        <a href="{{ route('umkm.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-700 transition">
                            <i class="fas fa-rotate-left"></i>
                            Tampilkan Semua Produk
                        </a>
                    </div>
                </div>
            @endif

        </div>

        {{-- Detail Modal Popup (Accessible on click) --}}
        <div x-show="modalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-sm"
             style="display: none;"
             @keydown.escape.window="modalOpen = false">

            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-slate-200 dark:border-slate-800 shadow-2xl relative"
                 @click.away="modalOpen = false">

                {{-- Close Button --}}
                <button type="button" @click="modalOpen = false"
                        class="absolute top-4 right-4 z-20 w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-500 dark:text-slate-400 flex items-center justify-center transition">
                    <i class="fas fa-xmark text-sm"></i>
                </button>

                <template x-if="activeProduct">
                    <div>
                        {{-- Modal Image Banner --}}
                        <div class="relative aspect-16/9 bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            <img :src="activeProduct.image_url" :alt="activeProduct.name" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                            
                            <div class="absolute bottom-4 left-6 right-6 flex items-end justify-between">
                                <div>
                                    <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-500 text-white mb-1.5" x-text="activeProduct.category"></span>
                                    <h2 class="text-xl sm:text-2xl font-extrabold text-white" x-text="activeProduct.name"></h2>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-slate-300">Harga</p>
                                    <p class="text-lg sm:text-xl font-black text-emerald-400">
                                        Rp <span x-text="activeProduct.price"></span>
                                        <template x-if="activeProduct.unit">
                                            <span class="text-xs font-normal text-slate-300" x-text="'/ ' + activeProduct.unit"></span>
                                        </template>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Content --}}
                        <div class="p-6 sm:p-8 space-y-6">
                            {{-- Deskripsi Produk --}}
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2 flex items-center gap-1.5">
                                    <i class="fas fa-align-left text-emerald-500"></i>
                                    Deskripsi Produk
                                </h4>
                                <div class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-line bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800"
                                     x-text="activeProduct.description"></div>
                            </div>

                            {{-- Seller & Location Card --}}
                            <div class="bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/40 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <p class="text-xs text-emerald-800 dark:text-emerald-400 font-semibold uppercase tracking-wider">Pelaku UMKM / Penjual</p>
                                    <p class="text-base font-bold text-slate-900 dark:text-white mt-0.5" x-text="activeProduct.seller_name"></p>
                                    <template x-if="activeProduct.address">
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-1">
                                            <i class="fas fa-map-marker-alt text-emerald-600"></i>
                                            <span x-text="activeProduct.address"></span>
                                        </p>
                                    </template>
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    <span class="inline-flex items-center gap-1 text-emerald-700 dark:text-emerald-300 font-medium">
                                        <i class="fab fa-whatsapp"></i>
                                        <span x-text="activeProduct.phone"></span>
                                    </span>
                                </div>
                            </div>

                            {{-- Modal Action Buttons --}}
                            <div class="flex flex-col sm:flex-row items-center gap-3 pt-2">
                                <a :href="activeProduct.whatsapp_url" target="_blank"
                                   class="w-full sm:flex-1 py-3 px-5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-2xl font-bold text-sm shadow-md shadow-emerald-600/20 transition flex items-center justify-center gap-2">
                                    <i class="fab fa-whatsapp text-lg"></i>
                                    <span>Hubungi Penjual via WhatsApp</span>
                                </a>

                                <a :href="activeProduct.detail_url"
                                   class="w-full sm:w-auto py-3 px-5 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 text-sm font-semibold transition text-center">
                                    Buka Halaman Lengkap
                                </a>
                            </div>
                        </div>
                    </div>
                </template>

            </div>
        </div>

    </div>
</x-public-layout>
