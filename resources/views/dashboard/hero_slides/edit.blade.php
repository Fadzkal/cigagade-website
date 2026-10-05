<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Hero Slide') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('hero-slides.update', $heroSlide->id) }}" method="POST" enctype="multipart/form-data" x-data="{ type: '{{ $heroSlide->type }}' }">
                        @csrf
                        @method('PUT')

                        <!-- Tipe Slide -->
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Tipe Slide</label>
                            <select name="type" id="type" x-model="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="post">Berita (Otomatis dari Post)</option>
                                <option value="youtube">YouTube Video</option>
                            </select>
                        </div>

                        <!-- Untuk Tipe Post -->
                        <div x-show="type === 'post'" class="mb-4 p-4 border rounded bg-gray-50" x-cloak>
                            <label for="post_id" class="block text-sm font-medium text-gray-700">Pilih Berita</label>
                            <select name="post_id" id="post_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Berita --</option>
                                @foreach($posts as $post)
                                    <option value="{{ $post->id }}" {{ $heroSlide->post_id == $post->id ? 'selected' : '' }}>{{ $post->title }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Judul, gambar, dan link akan otomatis diambil dari berita yang dipilih.</p>
                        </div>

                        <!-- Untuk Tipe YouTube -->
                        <div x-show="type === 'youtube'" class="p-4 border rounded bg-gray-50 space-y-4 mb-4" x-cloak>
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul Custom</label>
                                <input type="text" name="title" id="title" value="{{ $heroSlide->title }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            
                            <div>
                                <label for="youtube_url" class="block text-sm font-medium text-gray-700">Link YouTube</label>
                                <input type="url" name="youtube_url" id="youtube_url" value="{{ $heroSlide->youtube_url }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="https://www.youtube.com/watch?v=...">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="order" class="block text-sm font-medium text-gray-700">Urutan Tampil (Order)</label>
                                <input type="number" name="order" id="order" value="{{ $heroSlide->order }}" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div class="mb-4 flex items-center mt-6">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $heroSlide->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktif (Tampilkan di web)</label>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('hero-slides.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
