<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('media.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Media</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Tipe Media -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Tipe Media</label>
                            <div class="flex gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="type" value="image" class="peer sr-only" checked onchange="toggleType(this.value)">
                                    <div class="px-4 py-2 rounded-lg border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition font-medium">
                                        <i class="fas fa-image mr-2"></i> Gambar / Majalah
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="type" value="social" class="peer sr-only" onchange="toggleType(this.value)">
                                    <div class="px-4 py-2 rounded-lg border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition font-medium">
                                        <i class="fas fa-share-alt mr-2"></i> Social Media
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Platform (Hanya untuk Social) -->
                        <div id="platform-group" class="hidden">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Platform</label>
                            <select name="platform" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm">
                                <option value="">Pilih Platform</option>
                                <option value="instagram">Instagram</option>
                                <option value="tiktok">TikTok</option>
                                <option value="other">Lainnya</option>
                            </select>
                            @error('platform') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Judul -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Judul</label>
                            <input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm" placeholder="Masukkan judul media">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- URL -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">URL (Link Tujuan / Social Media)</label>
                            <input type="url" name="url" value="{{ old('url') }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm" placeholder="https://...">
                            @error('url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi (Opsional)</label>
                            <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm" placeholder="Tulis deskripsi singkat...">{{ old('description') }}</textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Gambar (Hanya untuk Gambar) -->
                        <div id="image-group">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Upload Gambar / Cover Majalah</label>
                            <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                            @error('image') <span class="block mt-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Featured & Order -->
                        <div class="flex flex-col sm:flex-row gap-6">
                            <div class="flex items-center">
                                <input type="hidden" name="is_featured" value="0">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="is_featured" class="ml-2 text-sm text-gray-700 font-medium">Tandai sebagai Unggulan (Featured)</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <label class="text-sm font-semibold text-gray-900">Urutan (Opsional)</label>
                                <input type="number" name="order" value="{{ old('order', 0) }}" class="w-24 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('media.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleType(type) {
            const platformGroup = document.getElementById('platform-group');
            const imageGroup = document.getElementById('image-group');
            
            if(type === 'social') {
                platformGroup.classList.remove('hidden');
                imageGroup.classList.add('hidden');
            } else {
                platformGroup.classList.add('hidden');
                imageGroup.classList.remove('hidden');
            }
        }
        // Run on load
        toggleType(document.querySelector('input[name="type"]:checked').value);
    </script>
    @endpush
</x-app-layout>
