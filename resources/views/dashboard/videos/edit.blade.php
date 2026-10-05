<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('videos.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Video YouTube</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('videos.update', $video) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">

                        {{-- Judul --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Judul Video <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $video->title) }}" required
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- YouTube URL --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">
                                <i class="fab fa-youtube text-red-500 mr-1"></i> URL YouTube <span class="text-red-500">*</span>
                            </label>
                            <input type="url" name="youtube_url" value="{{ old('youtube_url', $video->youtube_url) }}" required
                                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm">
                            @error('youtube_url') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi (Opsional)</label>
                            <textarea name="description" rows="3"
                                      class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm">{{ old('description', $video->description) }}</textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Thumbnail --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Thumbnail Kustom (Opsional)</label>

                            {{-- Preview thumbnail saat ini --}}
                            <div class="mb-3">
                                <p class="text-xs text-gray-500 mb-2">Thumbnail saat ini:</p>
                                <img src="{{ $video->youtube_thumbnail }}"
                                     class="h-32 rounded-lg border border-gray-200 object-cover"
                                     alt="Thumbnail">
                            </div>

                            <input type="file" name="thumbnail" accept="image/*"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                            <p class="mt-1 text-xs text-gray-500">Upload baru hanya jika ingin mengganti thumbnail.</p>
                            @error('thumbnail') <span class="block mt-1 text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Tanggal Publish --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Tanggal Publish</label>
                            <input type="date" name="published_at"
                                   value="{{ old('published_at', $video->published_at ? $video->published_at->format('Y-m-d') : now()->format('Y-m-d')) }}"
                                   class="rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 transition shadow-sm">
                            @error('published_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Featured --}}
                        <div class="flex items-center">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                   {{ old('is_featured', $video->is_featured) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <label for="is_featured" class="ml-2 text-sm text-gray-700 font-medium">
                                <i class="fas fa-star text-yellow-500 mr-1"></i> Tandai sebagai Video Unggulan (Featured)
                            </label>
                        </div>

                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('videos.index') }}"
                           class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">Batal</a>
                        <button type="submit"
                                class="px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i> Update Video
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
