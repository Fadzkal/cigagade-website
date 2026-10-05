<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengaturan Website') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Berhasil!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Oops! Ada kesalahan:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-12">

                            <div class="border-b border-gray-900/10 dark:border-gray-700 pb-12">
                                <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">Pengaturan Umum</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">Atur logo utama dan video hero.</p>

                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="col-span-full">
                                        <label for="logo" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Logo Utama</label>
                                        <input type="file" name="logo" id="logo" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-gray-700 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-gray-600"/>
                                        <input type="hidden" name="oldLogo" value="{{ $settings['logo_path'] ?? '' }}">
                                        @if ($settings['logo_path'] ?? false)
                                            <div class="mt-4">
                                                <p class="text-sm text-gray-500">Logo saat ini:</p>
                                                <img src="{{ asset('storage/' . $settings['logo_path']) }}" alt="Logo" class="mt-2 h-16 w-auto bg-gray-200 p-2 rounded">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-span-full">
                                        <label for="video_url" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">URL Video Hero</label>
                                        <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $settings['video_url'] ?? '') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900">
                                        <p class="mt-2 text-xs text-gray-500">Contoh: https://www.youtube.com/watch?v=xxxxxxxxxxx</p>
                                    </div>
                                </div>
                            </div>

                            <div class="border-b border-gray-900/10 dark:border-gray-700 pb-12">
                                <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">Bagian 'About' (Tentang Kami)</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">Atur konten untuk bagian 'About' di halaman depan.</p>

                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="col-span-full">
                                        <label for="about_title" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Judul</label>
                                        <input type="text" name="about_title" id="about_title" value="{{ old('about_title', $settings['about_title'] ?? '') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900">
                                    </div>

                                    <div class="col-span-full">
                                        <label for="about_subtitle" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Sub Judul</label>
                                        <input type="text" name="about_subtitle" id="about_subtitle" value="{{ old('about_subtitle', $settings['about_subtitle'] ?? '') }}" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900">
                                    </div>

                                    <div class="col-span-full">
                                        <label for="about_description" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Deskripsi</label>
                                        <textarea id="about_description" name="about_description" rows="5" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900">{{ old('about_description', $settings['about_description'] ?? '') }}</textarea>
                                    </div>

                                    <div class="col-span-full">
                                        <label for="about_image" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Gambar 'About'</label>
                                        <input type="file" name="about_image" id="about_image" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-gray-700 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-gray-600"/>
                                        <input type="hidden" name="old_about_image" value="{{ $settings['about_image'] ?? '' }}">
                                        @if ($settings['about_image'] ?? false)
                                            <div class="mt-4">
                                                <p class="text-sm text-gray-500">Gambar saat ini:</p>
                                                <img src="{{ asset('storage/' . $settings['about_image']) }}" alt="About Image" class="mt-2 w-auto h-48 object-cover bg-gray-200 p-2 rounded">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="border-b border-gray-900/10 dark:border-gray-700 pb-12">
                                <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-gray-100">Visi & Misi</h2>
                                <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">Atur visi dan misi organisasi.</p>

                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="col-span-full">
                                        <label for="visi" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Visi</label>
                                        <textarea id="visi" name="visi" rows="5" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900">{{ old('visi', $settings['visi'] ?? '') }}</textarea>
                                    </div>
                                    <div class="col-span-full">
                                        <label for="misi" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Misi</label>
                                        <textarea id="misi" name="misi" rows="5" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 bg-white dark:bg-gray-900">{{ old('misi', $settings['misi'] ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>



                        </div>

                        <div class="mt-8 flex items-center justify-end gap-x-6">
                            <button type="submit" class="rounded-md bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
