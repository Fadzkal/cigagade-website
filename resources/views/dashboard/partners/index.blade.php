<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Rekan (Kerjasama & Media Partner)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <a href="{{ route('partners.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition mb-4">
                        + Tambah Rekan
                    </a>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-4">Kerjasama</h3>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-8">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Logo</th>
                                    <th scope="col" class="px-6 py-3">Nama Rekan</th>
                                    <th scope="col" class="px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($partners->where('type', 'kerjasama') as $partner)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="w-24 h-auto object-contain">
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $partner->name }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('partners.edit', $partner->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('partners.destroy', $partner->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:underline ms-3">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr class="bg-white border-b">
                                        <td colspan="3" class="px-6 py-4 text-center">
                                            Data kerjasama masih kosong.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-4">Media Partner</h3>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Logo</th>
                                    <th scope="col" class="px-6 py-3">Nama Rekan</th>
                                    <th scope="col" class="px-6 py-3"><span class="sr-only">Aksi</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($partners->where('type', 'media_partner') as $partner)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="w-24 h-auto object-contain">
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $partner->name }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('partners.edit', $partner->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('partners.destroy', $partner->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 hover:underline ms-3">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr class="bg-white border-b">
                                        <td colspan="3" class="px-6 py-4 text-center">
                                            Data media partner masih kosong.
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
