<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tulis Pengumuman Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            <strong>Oops! Ada yang salah:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul Pengumuman</label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('title') }}" required>
                            </div>



                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Gambar Thumbnail</label>
                                <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>

                            <div>
                                <label for="excerpt" class="block text-sm font-medium text-gray-700">Ringkasan (Excerpt)</label>
                                <textarea name="excerpt" id="excerpt" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>{{ old('excerpt') }}</textarea>
                                <p class="mt-2 text-sm text-gray-500">Ringkasan singkat yang akan tampil di halaman daftar Pengumuman.</p>
                            </div>

                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700">Isi Konten</label>
                                <div id="quill-editor" class="mt-1 bg-white rounded-b-md" style="height: 400px;">{!! old('content') !!}</div>
                                <input type="hidden" name="content" id="content" value="{{ old('content') }}">
                            </div>

                            <div>
                                <label for="published_at" class="block text-sm font-medium text-gray-700">Tanggal Publish</label>
                                <input type="datetime-local" name="published_at" id="published_at"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                                <p class="mt-2 text-sm text-gray-500">Tanggal dan waktu Pengumuman ini akan tampil. Defaultnya adalah waktu saat ini.</p>
                            </div>

                        </div>

                        <div class="mt-6 flex items-center">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                                Publikasikan
                            </button>

                            <a href="{{ route('pengumuman.index') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-200 active:bg-gray-200 disabled:opacity-25 transition">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
