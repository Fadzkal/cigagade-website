<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight">
                    {{ __('Edit Banner Landscape') }}
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Ubah rincian, tautan, urutan, atau ganti file gambar banner landscape.
                </p>
            </div>
            <a href="{{ route('landscape-banners.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-semibold transition">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 p-6 sm:p-8 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                
                @if ($errors->any())
                    <div class="p-4 mb-6 bg-rose-50 dark:bg-rose-950/40 border border-rose-300 dark:border-rose-800 text-rose-800 dark:text-rose-200 rounded-2xl text-sm shadow-sm">
                        <div class="font-bold flex items-center gap-2 mb-1">
                            <i class="fas fa-circle-exclamation text-rose-600"></i>
                            <span>Terdapat kesalahan:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('landscape-banners.update', $landscapeBanner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Gambar Saat Ini --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                            Gambar Banner Saat Ini
                        </label>
                        <div class="relative rounded-2xl overflow-hidden aspect-[21/7] max-h-[300px] bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-sm">
                            <img src="{{ asset('storage/' . $landscapeBanner->image) }}" 
                                 alt="{{ $landscapeBanner->title ?? 'Banner' }}" 
                                 id="current-image"
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                    {{-- Upload Ganti Gambar --}}
                    <div>
                        <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Ganti File Gambar <span class="text-slate-400 font-normal text-[11px]">(Kosongkan jika tidak ingin mengubah gambar)</span>
                        </label>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 dark:border-slate-700 rounded-xl cursor-pointer focus:outline-none dark:bg-slate-900"
                               onchange="previewNewImage(this)">
                        <p class="text-[11px] text-slate-400 mt-1">
                            Ukuran rekomendasi: <strong>1920 x 500 px</strong> (rasio ~ 21:9 atau 16:5). Format: JPG, PNG, WEBP. Max 4MB.
                        </p>
                    </div>

                    {{-- Judul / Caption --}}
                    <div>
                        <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Judul / Keterangan Banner
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $landscapeBanner->title) }}"
                               class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                    </div>

                    {{-- Link / URL --}}
                    <div>
                        <label for="url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Link Tujuan Banner <span class="text-slate-400 font-normal text-[11px]">(Opsional)</span>
                        </label>
                        <input type="text" name="url" id="url" value="{{ old('url', $landscapeBanner->url) }}"
                               placeholder="Contoh: /umkm atau https://..."
                               class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                    </div>

                    {{-- Target Link & Urutan --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="target" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                Target Tautan
                            </label>
                            <select name="target" id="target"
                                    class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                <option value="_self" {{ old('target', $landscapeBanner->target) === '_self' ? 'selected' : '' }}>Tab yang Sama (_self)</option>
                                <option value="_blank" {{ old('target', $landscapeBanner->target) === '_blank' ? 'selected' : '' }}>Tab Baru (_blank)</option>
                            </select>
                        </div>

                        <div>
                            <label for="order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                Urutan Tampil
                            </label>
                            <input type="number" name="order" id="order" value="{{ old('order', $landscapeBanner->order) }}" min="1"
                                   class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                        </div>
                    </div>

                    {{-- Checkbox Status Aktif --}}
                    <div class="pt-2">
                        <label class="relative flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $landscapeBanner->is_active) ? 'checked' : '' }}
                                   class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Status Aktif (Tampilkan di Beranda)</span>
                        </label>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                        <a href="{{ route('landscape-banners.index') }}" 
                           class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 text-sm font-semibold transition">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        function previewNewImage(input) {
            const preview = document.getElementById('current-image');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
