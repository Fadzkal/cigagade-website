<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hero Slides') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        <a href="{{ route('hero-slides.create') }}" class="inline-flex items-center px-4 py-2 bg-slate-800 hover:bg-slate-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition">
                            + Tambah Slide
                        </a>
                        <a href="{{ route('running-texts.index') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition">
                            <i class="fas fa-bullhorn mr-1.5"></i> Kelola Teks Berjalan (Running Text)
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Urutan</th>
                                    <th scope="col" class="px-6 py-3">Tipe</th>
                                    <th scope="col" class="px-6 py-3">Judul</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($slides as $slide)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $slide->order }}
                                    </th>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded {{ $slide->type == 'youtube' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ strtoupper($slide->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $slide->type == 'post' ? ($slide->post->title ?? 'Post tidak ditemukan') : $slide->title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded {{ $slide->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $slide->is_active ? 'Aktif' : 'Non-aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('hero-slides.edit', $slide->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('hero-slides.destroy', $slide->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus slide ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:underline ms-3">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr class="bg-white border-b">
                                        <td colspan="5" class="px-6 py-4 text-center">
                                            Belum ada slide.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
