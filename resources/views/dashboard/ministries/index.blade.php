<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Perangkat & Aparatur Desa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <a href="{{ route('ministries.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 focus:outline-none focus:border-emerald-700 focus:ring focus:ring-emerald-200 active:bg-emerald-600 disabled:opacity-25 transition mb-4">
                        + Tambah Perangkat Desa
                    </a>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Foto / Profil</th>
                                    <th scope="col" class="px-6 py-3">Nama & Jabatan</th>
                                    <th scope="col" class="px-6 py-3">Tugas / Deskripsi</th>
                                    <th scope="col" class="px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ministries as $ministry)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="px-6 py-4">
                                        @if ($ministry->image)
                                            <img src="{{ asset('storage/' . $ministry->image) }}" alt="{{ $ministry->name }}" class="w-24 h-16 object-cover rounded">
                                        @else
                                            <span class="text-gray-400">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $ministry->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ Str::limit($ministry->description, 50) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('ministries.edit', $ministry->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('ministries.destroy', $ministry->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:underline ms-3">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr class="bg-white border-b">
                                        <td colspan="5" class="px-6 py-4 text-center">
                                            Data perangkat desa masih kosong.
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
