<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('media.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Media</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('media.update', $media) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Tipe Media (Readonly on Edit) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Tipe Media</label>
                            <div class="flex gap-4">
                                <label class="cursor-not-allowed opacity-70">
                                    <input type="radio" disabled name="type" value="image" class="peer sr-only" {{ $media->type === 'image' ? 'checked' : '' }}>
                                    <div class="px-4 py-2 rounded-lg border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition font-medium">
                                        <i class="fas fa-image mr-2"></i> Gambar / Majalah
                                    </div>
                                </label>
                                <label class="cursor-not-allowed opacity-70">
                                    <input type="radio" disabled name="type" value="social" class="peer sr-only" {{ $media->type === 'social' ? 'checked' : '' }}>
                                    <div class="px-4 py-2 rounded-lg border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition font-medium">
                                        <i class="fas fa-share-alt mr-2"></i> Social Media
                                    </div>
                                </label>
                            </div>
                            <input type="hidden" name="type" value="{{ $media->type }}">
                        </div>

                        <!-- Platform (Hanya untuk Social) -->
                        @if($media->type === 'social')
                        <div id="platform-group">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Platform</label>
                            <select name="platform" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm">
                                <option value="instagram" {{ $media->platform === 'instagram' ? 'selected' : '' }}>Instagram</option>
                                <option value="tiktok" {{ $media->platform === 'tiktok' ? 'selected' : '' }}>TikTok</option>
                                <option value="other" {{ $media->platform === 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('platform') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        @endif

                        <!-- Judul -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Judul</label>
                            <input type="text" name="title" value="{{ old('title', $media->title) }}" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- URL -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">URL (Link Tujuan / Social Media)</label>
                            <input type="url" name="url" value="{{ old('url', $media->url) }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm">
                            @error('url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi (Opsional)</label>
                            <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm">{{ old('description', $media->description) }}</textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Gambar (Hanya untuk Gambar) -->
                        @if($media->type === 'image')
                        <div id="image-group">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Upload Gambar / Cover Baru (Opsional)</label>
                            @if($media->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $media->image) }}" class="h-32 rounded-lg border border-gray-200">
                            </div>
                            @endif
                            <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                            @error('image') <span class="block mt-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        @endif

                        <!-- Featured & Order -->
                        <div class="flex flex-col sm:flex-row gap-6">
                            <div class="flex items-center">
                                <input type="hidden" name="is_featured" value="0">
                                <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $media->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="is_featured" class="ml-2 text-sm text-gray-700 font-medium">Tandai sebagai Unggulan (Featured)</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <label class="text-sm font-semibold text-gray-900">Urutan (Opsional)</label>
                                <input type="number" name="order" value="{{ old('order', $media->order) }}" class="w-24 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('media.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
