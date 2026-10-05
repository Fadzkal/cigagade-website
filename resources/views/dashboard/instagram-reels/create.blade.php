<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('instagram-reels.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Instagram Reel</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('instagram-reels.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
                    @csrf

                    <div class="space-y-6">

                        {{-- Judul --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Judul Reel <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm"
                                   placeholder="Contoh: Semarak Karnaval HUT RI Warga Desa Cigagade">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Instagram URL --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                <i class="fab fa-instagram text-pink-500 mr-1"></i> URL Instagram Reel <span class="text-red-500">*</span>
                            </label>
                            <input type="url" name="instagram_url" value="{{ old('instagram_url') }}" required
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm"
                                   placeholder="https://www.instagram.com/reel/...">
                            <p class="mt-1 text-xs text-gray-500">Gunakan link dari Instagram web (misal: https://www.instagram.com/reel/XXXXXX/)</p>
                            @error('instagram_url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Urutan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Urutan Tampil (Opsional)</label>
                            <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                                   class="w-full sm:w-1/3 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm">
                            <p class="mt-1 text-xs text-gray-500">Angka lebih kecil tampil lebih dulu (0 = otomatis)</p>
                            @error('order') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Thumbnail Kustom --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Gambar Cover/Thumbnail Kustom <span class="text-red-500">*</span></label>
                            <p class="text-xs text-gray-500 mb-2">Rekomendasi rasio portrait 9:16 (Contoh: 1080x1920px).</p>
                            <input type="file" name="thumbnail" accept="image/*" required
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 transition">
                            @error('thumbnail') <span class="block mt-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Active --}}
                        <div class="flex items-center">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <label for="is_active" class="ml-2 text-sm text-gray-700 font-medium">
                                Aktifkan (Tampilkan di halaman depan)
                            </label>
                        </div>

                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('instagram-reels.index') }}"
                           class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">Batal</a>
                        <button type="submit"
                                class="px-5 py-2.5 bg-pink-600 text-white font-semibold rounded-lg hover:bg-pink-700 transition">
                            <i class="fas fa-save mr-2"></i> Simpan Reel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
