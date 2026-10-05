<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Gambar Galeri') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul/Caption (Opsional)</label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('title', $gallery->title) }}">
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Ganti File Gambar</Labe></label>
                                <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <input type="hidden" name="oldImage" value="{{ $gallery->image }}">
                                @if ($gallery->image)
                                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" class="mt-2 w-48 h-auto rounded">
                                    <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengganti gambar.</p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 flex items-center">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                                Update
                            </button>
                            <a href="{{ route('galleries.index') }}" class="ml-4 text-sm text-gray-600 hover:underline">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
