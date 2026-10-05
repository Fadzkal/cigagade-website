<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Artikel Potensi & Literasi Desa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <a href="{{ route('bengkel-ilmu.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 transition mb-4">
                        + Tulis Artikel Baru
                    </a>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Filter by kategori --}}
                    <div class="mb-4 flex flex-wrap gap-2">
                        <span class="text-sm font-medium text-gray-600 self-center">Filter:</span>
                        <a href="{{ route('bengkel-ilmu.index') }}"
                           class="px-3 py-1 rounded-full text-xs font-semibold border {{ !request('kategori') ? 'bg-blue-600 text-white border-blue-600' : 'text-gray-600 border-gray-300 hover:border-blue-400' }}">
                           Semua
                        </a>
                        @foreach ($categories as $cat)
                        <a href="{{ route('bengkel-ilmu.index', ['kategori' => $cat->slug]) }}"
                           class="px-3 py-1 rounded-full text-xs font-semibold border {{ request('kategori') === $cat->slug ? 'bg-blue-600 text-white border-blue-600' : 'text-gray-600 border-gray-300 hover:border-blue-400' }}">
                           {{ $cat->name }}
                        </a>
                        @endforeach
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Judul Artikel</th>
                                    <th scope="col" class="px-6 py-3">Sub-Kategori</th>
                                    <th scope="col" class="px-6 py-3">Penulis</th>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $filtered = request('kategori')
                                        ? $posts->filter(fn($p) => $p->category->slug === request('kategori'))
                                        : $posts;
                                @endphp

                                @foreach ($filtered as $post)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $post->title }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">
                                            {{ $post->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $post->user->name }}</td>
                                    <td class="px-6 py-4 text-xs text-gray-400">
                                        {{ ($post->published_at ?? $post->created_at)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-3">
                                        @can('update', $post)
                                        <a href="{{ route('bengkel-ilmu.edit', $post->id) }}"
                                           class="font-medium text-blue-600 hover:underline">Edit</a>
                                        @endcan

                                        @can('delete', $post)
                                        <form action="{{ route('bengkel-ilmu.destroy', $post->id) }}" method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="font-medium text-red-600 hover:underline">Hapus</button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach

                                @if($filtered->isEmpty())
                                    <tr class="bg-white border-b">
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                            Belum ada artikel Bengkel Ilmu.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
