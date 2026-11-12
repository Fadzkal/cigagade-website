<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('tiktok-videos.index') }}" class="w-9 h-9 rounded-xl bg-white border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 flex items-center justify-center transition">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">Edit Video TikTok</h2>
                <p class="text-xs text-gray-500 mt-0.5">Perbarui informasi dan tampilan video TikTok</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('tiktok-videos.update', $tiktokVideo) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">

                        {{-- Judul --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                Judul / Keterangan Singkat Video <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title', $tiktokVideo->title) }}" required
                                   class="w-full rounded-xl border-gray-300 focus:border-slate-800 focus:ring-slate-800 transition shadow-sm text-sm"
                                   placeholder="Contoh: Keseruan Bazar UMKM Desa Cigagade 2026">
                            @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- TikTok URL --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                <i class="fab fa-tiktok text-slate-900"></i>
                                <span>URL / Tautan Video TikTok <span class="text-red-500">*</span></span>
                            </label>
                            <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $tiktokVideo->tiktok_url) }}" required
                                   class="w-full rounded-xl border-gray-300 focus:border-slate-800 focus:ring-slate-800 transition shadow-sm text-sm"
                                   placeholder="https://www.tiktok.com/@username/video/7382910293847561829">
                            <p class="mt-1.5 text-xs text-gray-500">
                                Salin tautan video dari aplikasi atau website TikTok
                            </p>
                            @error('tiktok_url') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Urutan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Urutan Tampil (Opsional)</label>
                            <input type="number" name="order" value="{{ old('order', $tiktokVideo->order) }}" min="0"
                                   class="w-full sm:w-1/3 rounded-xl border-gray-300 focus:border-slate-800 focus:ring-slate-800 transition shadow-sm text-sm">
                            <p class="mt-1 text-xs text-gray-500">Angka lebih kecil tampil paling kiri/awal</p>
                            @error('order') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Thumbnail Kustom --}}
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Cover / Thumbnail Saat Ini</label>
                            
                            <div class="flex items-center gap-4 mb-4">
                                <div class="h-28 w-16 rounded-xl overflow-hidden shadow border border-gray-200 bg-black flex-shrink-0">
                                    <img class="h-full w-full object-cover" src="{{ $tiktokVideo->thumbnail_url }}" alt="{{ $tiktokVideo->title }}">
                                </div>
                                <div class="text-xs text-gray-500">
                                    <p class="font-medium text-gray-700">Ganti Thumbnail (Opsional)</p>
                                    <p class="mt-0.5">Biarkan kosong jika tidak ingin mengubah gambar thumbnail saat ini.</p>
                                </div>
                            </div>

                            <input type="file" name="thumbnail" accept="image/*"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-slate-800 transition">
                            @error('thumbnail') <span class="block mt-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Active Switch --}}
                        <div class="flex items-center gap-3 pt-2">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $tiktokVideo->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-gray-300 text-slate-900 shadow-sm focus:ring-slate-800">
                            <label for="is_active" class="text-sm text-gray-800 font-medium cursor-pointer">
                                Aktifkan langsung (Tampilkan di beranda website)
                            </label>
                        </div>

                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('tiktok-videos.index') }}"
                           class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 text-sm transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-5 py-2.5 bg-slate-900 text-white font-semibold rounded-xl hover:bg-slate-800 text-sm shadow-sm transition flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            <span>Perbarui Video TikTok</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
