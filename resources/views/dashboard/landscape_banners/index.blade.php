<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight">
                    {{ __('Kelola Banner Landscape (Auto-Scroll)') }}
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Banner promosi landscape lebar yang bergulir otomatis tepat di bawah section Produk Unggulan & UMKM pada beranda.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('umkm.admin.index') }}" class="inline-flex items-center px-3.5 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-semibold rounded-xl transition">
                    <i class="fas fa-store mr-1.5 text-emerald-600"></i>
                    <span>Katalog UMKM</span>
                </a>
                <a href="{{ url('/') }}#banner-landscape-section" target="_blank" class="inline-flex items-center px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                    <i class="fas fa-external-link-alt mr-1.5"></i>
                    <span>Lihat di Beranda</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 rounded-2xl flex items-center justify-between text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-circle-check text-emerald-600 text-base"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-rose-50 dark:bg-rose-950/40 border border-rose-300 dark:border-rose-800 text-rose-800 dark:text-rose-200 rounded-2xl text-sm shadow-sm">
                    <div class="font-bold flex items-center gap-2 mb-1">
                        <i class="fas fa-circle-exclamation text-rose-600"></i>
                        <span>Terdapat kesalahan pengisian form:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- PANDUAN UKURAN GAMBAR (PENTING) --}}
            <div class="p-5 rounded-2xl bg-gradient-to-r from-emerald-500/10 via-teal-500/10 to-transparent border border-emerald-500/30 dark:border-emerald-500/20 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-md">
                        <i class="fas fa-panorama text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-900 dark:text-white flex items-center gap-2">
                            <span>Panduan Ukuran & Format Banner Landscape</span>
                            <span class="text-[10px] uppercase font-extrabold px-2 py-0.5 rounded-full bg-emerald-600 text-white">Wajib Diperhatikan</span>
                        </h4>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                            Rekomendasi dimensi: <strong class="text-emerald-700 dark:text-emerald-400">1920 x 500 px</strong> (atau rasio lebar <strong class="text-emerald-700 dark:text-emerald-400">16:5 sampai 21:9</strong>). Format: <strong>JPG, PNG, WEBP</strong>, maksimal <strong>4 MB</strong>.
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 shrink-0">
                    <i class="fas fa-circle-info text-emerald-600"></i>
                    <span>Posisi: Tepat setelah section UMKM di Homepage</span>
                </div>
            </div>

            {{-- LIVE PREVIEW WIDGET --}}
            @if($banners->where('is_active', true)->isNotEmpty())
            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 flex items-center gap-2">
                        <i class="fas fa-eye text-emerald-600"></i>
                        <span>Live Preview Slider Banner Landscape</span>
                    </span>
                    <span class="text-[11px] text-slate-400">Otomatis bergulir setiap 4 detik</span>
                </div>

                {{-- Splide Auto-Slide Preview --}}
                <div class="splide rounded-2xl overflow-hidden shadow-inner border border-slate-200 dark:border-slate-700" 
                     data-options='{"type":"loop","perPage":1,"autoplay":true,"interval":4000,"pauseOnHover":true,"arrows":true,"pagination":true,"speed":800}'>
                    <div class="splide__track">
                        <ul class="splide__list">
                            @foreach($banners->where('is_active', true) as $banner)
                                <li class="splide__slide">
                                    <div class="relative w-full aspect-[21/6] sm:aspect-[24/7] max-h-[360px] bg-slate-900 overflow-hidden">
                                        <img src="{{ asset('storage/' . $banner->image) }}" 
                                             alt="{{ $banner->title ?? 'Banner Landscape' }}" 
                                             class="w-full h-full object-cover">
                                        @if($banner->title)
                                            <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black/80 via-black/30 to-transparent flex items-center justify-between">
                                                <span class="text-white text-xs sm:text-sm font-semibold truncate">{{ $banner->title }}</span>
                                                @if($banner->url)
                                                    <span class="text-[10px] text-emerald-300 font-bold px-2 py-0.5 rounded bg-black/40 border border-emerald-500/30">
                                                        <i class="fas fa-link mr-1"></i> {{ $banner->url }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            {{-- GRID FORM TAMBAH & DAFTAR BANNER --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                {{-- FORM UPLOAD BANNER BARU (4 Cols) --}}
                <div class="lg:col-span-4">
                    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm sticky top-6">
                        <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-700 pb-3 mb-5">
                            <span class="w-2.5 h-5 bg-emerald-600 rounded-sm"></span>
                            <h3 class="font-bold text-base text-slate-900 dark:text-white">
                                + Tambah Banner Landscape
                            </h3>
                        </div>

                        <form action="{{ route('landscape-banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            {{-- File Gambar --}}
                            <div>
                                <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                    File Gambar Banner <span class="text-rose-500">*</span>
                                </label>
                                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp" required
                                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 dark:border-slate-700 rounded-xl cursor-pointer focus:outline-none dark:bg-slate-900"
                                       onchange="previewImage(this)">
                                <p class="text-[11px] text-slate-400 mt-1">
                                    Rasio ~ 21:9 atau 16:5 (1920 x 500 px disarankan). Max 4MB.
                                </p>

                                {{-- Image preview container --}}
                                <div id="preview-wrapper" class="hidden mt-3 relative rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700 aspect-[21/7] bg-slate-100 dark:bg-slate-900">
                                    <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-cover">
                                    <span class="absolute top-2 right-2 text-[10px] font-bold px-2 py-0.5 rounded bg-black/60 text-white backdrop-blur-sm">Pratinjau</span>
                                </div>
                            </div>

                            {{-- Judul / Caption --}}
                            <div>
                                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                    Judul / Keterangan Banner
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                       placeholder="Contoh: Promo Produk Olahan Pangan BUMDes"
                                       class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                            </div>

                            {{-- Link / URL --}}
                            <div>
                                <label for="url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                    Link Tujuan Banner <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span>
                                </label>
                                <input type="text" name="url" id="url" value="{{ old('url') }}"
                                       placeholder="Contoh: /umkm atau https://..."
                                       class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                <p class="text-[11px] text-slate-400 mt-1">
                                    Bila diisi, pengunjung dapat mengeklik banner untuk membuka tautan ini.
                                </p>
                            </div>

                            {{-- Target Link --}}
                            <div>
                                <label for="target" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                    Target Tautan
                                </label>
                                <select name="target" id="target"
                                        class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                    <option value="_self" {{ old('target') === '_self' ? 'selected' : '' }}>Tab yang Sama (_self)</option>
                                    <option value="_blank" {{ old('target') === '_blank' ? 'selected' : '' }}>Tab Baru (_blank)</option>
                                </select>
                            </div>

                            {{-- Urutan & Status Aktif --}}
                            <div class="grid grid-cols-2 gap-3 pt-2">
                                <div>
                                    <label for="order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                        Urutan
                                    </label>
                                    <input type="number" name="order" id="order" value="{{ old('order', $banners->count() + 1) }}" min="1"
                                           class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                </div>
                                <div class="flex items-center pt-6">
                                    <label class="relative flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                               class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                                        <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Langsung Aktif</span>
                                    </label>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="pt-3">
                                <button type="submit"
                                        class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center justify-center gap-2">
                                    <i class="fas fa-cloud-arrow-up"></i>
                                    <span>Unggah & Simpan Banner</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- DAFTAR BANNER LANDSCAPE (8 Cols) --}}
                <div class="lg:col-span-8">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                        <div class="p-5 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-images text-emerald-600"></i>
                                <h3 class="font-bold text-base text-slate-900 dark:text-white">
                                    Daftar Banner Landscape
                                </h3>
                            </div>
                            <span class="text-xs px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-700 font-bold text-slate-600 dark:text-slate-300">
                                Total: {{ $banners->count() }} Banner
                            </span>
                        </div>

                        @if($banners->isEmpty())
                            <div class="p-12 text-center text-slate-400">
                                <i class="fas fa-panorama text-5xl mb-3 text-slate-300 dark:text-slate-600"></i>
                                <p class="text-sm font-semibold">Belum ada banner landscape yang diunggah.</p>
                                <p class="text-xs mt-1">Gunakan form di samping kiri untuk mengunggah banner pertama.</p>
                            </div>
                        @else
                            <div class="divide-y divide-slate-100 dark:divide-slate-700">
                                @foreach($banners as $banner)
                                    <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/70 dark:hover:bg-slate-750 transition">
                                        
                                        {{-- Thumbnail & Details --}}
                                        <div class="flex items-start sm:items-center gap-4 flex-grow min-w-0">
                                            {{-- Thumbnail --}}
                                            <div class="relative w-28 sm:w-36 aspect-[21/8] rounded-xl overflow-hidden bg-slate-900 shrink-0 border border-slate-200 dark:border-slate-700 shadow-sm">
                                                <img src="{{ asset('storage/' . $banner->image) }}" 
                                                     alt="{{ $banner->title ?? 'Banner' }}" 
                                                     class="w-full h-full object-cover">
                                                <span class="absolute bottom-1 right-1 px-1.5 py-0.5 rounded bg-black/70 text-[9px] text-white font-mono">
                                                    #{{ $banner->order }}
                                                </span>
                                            </div>

                                            {{-- Text Info --}}
                                            <div class="min-w-0 flex-grow">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <h4 class="font-bold text-sm text-slate-900 dark:text-white truncate">
                                                        {{ $banner->title ?: 'Tanpa Judul' }}
                                                    </h4>
                                                    @if($banner->is_active)
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">
                                                            <i class="fas fa-circle text-[6px]"></i> Aktif
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-700 text-slate-500">
                                                            Nonaktif
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 dark:text-slate-400">
                                                    @if($banner->url)
                                                        <span class="flex items-center gap-1 truncate max-w-xs text-emerald-600 dark:text-emerald-400">
                                                            <i class="fas fa-link text-[10px]"></i>
                                                            <a href="{{ $banner->url }}" target="_blank" class="hover:underline truncate">{{ $banner->url }}</a>
                                                        </span>
                                                    @else
                                                        <span class="text-slate-400 italic">Tidak ada tautan</span>
                                                    @endif

                                                    <span>Target: <strong class="font-mono">{{ $banner->target }}</strong></span>
                                                    <span>Urutan: <strong>{{ $banner->order }}</strong></span>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Actions: Toggle, Edit, Delete --}}
                                        <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                                            {{-- Toggle Switch --}}
                                            <form action="{{ route('landscape-banners.toggle', $banner->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        title="{{ $banner->is_active ? 'Klik untuk nonaktifkan' : 'Klik untuk aktifkan' }}"
                                                        class="p-2 rounded-xl text-xs font-semibold transition {{ $banner->is_active ? 'bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-200' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 hover:bg-slate-200' }}">
                                                    <i class="fas {{ $banner->is_active ? 'fa-toggle-on text-base' : 'fa-toggle-off text-base' }}"></i>
                                                </button>
                                            </form>

                                            {{-- Edit Button --}}
                                            <a href="{{ route('landscape-banners.edit', $banner->id) }}"
                                               class="p-2 bg-slate-100 hover:bg-amber-100 dark:bg-slate-700 dark:hover:bg-amber-950/40 text-slate-600 hover:text-amber-600 dark:text-slate-300 rounded-xl text-xs font-semibold transition"
                                               title="Edit Banner">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            {{-- Delete Button --}}
                                            <form action="{{ route('landscape-banners.destroy', $banner->id) }}" method="POST"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 bg-slate-100 hover:bg-rose-100 dark:bg-slate-700 dark:hover:bg-rose-950/40 text-slate-600 hover:text-rose-600 dark:text-slate-300 rounded-xl text-xs font-semibold transition"
                                                        title="Hapus Banner">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Script Image Preview --}}
    <script>
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            const wrapper = document.getElementById('preview-wrapper');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    wrapper.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                wrapper.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
