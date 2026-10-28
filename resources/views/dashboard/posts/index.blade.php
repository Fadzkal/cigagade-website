<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Daftar Kabar & Berita Desa') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Kelola seluruh warta dan publikasi berita Desa Cigagade serta warta khusus RW.
                </p>
            </div>
            <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-emerald-700 active:bg-emerald-800 shadow-sm transition">
                <i class="fas fa-plus mr-2"></i> Tulis Berita Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Role info banner untuk akun RW / PKK --}}
            @if(Auth::check() && Auth::user()->isRw())
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-xl">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-base leading-tight">Panel Pengurus {{ Auth::user()->getRwLabel() }}</h3>
                            <p class="text-xs text-amber-100 mt-0.5">
                                Berita yang Anda terbitkan akan otomatis diberi tanda <strong>{{ Auth::user()->getRwLabel() }}</strong> dan tampil di portal utama.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('posts.index', ['rw' => Auth::user()->rw]) }}" class="px-3.5 py-1.5 bg-white text-amber-700 hover:bg-amber-50 text-xs font-bold rounded-lg shadow-sm transition">
                            Lihat Berita {{ Auth::user()->getRwLabel() }} Saja
                        </a>
                    </div>
                </div>
            @elseif(Auth::check() && Auth::user()->isPkk())
                <div class="bg-gradient-to-r from-rose-600 via-pink-600 to-pink-700 text-white rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-xl">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-base leading-tight">Panel Kader TP-PKK Desa Cigagade</h3>
                            <p class="text-xs text-pink-100 mt-0.5">
                                Publikasikan warta 10 Program Pokok PKK, kegiatan Posyandu rutin balita & lansia, serta inovasi ketahanan pangan keluarga.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('posts.create') }}" class="px-3.5 py-1.5 bg-white text-pink-700 hover:bg-pink-50 text-xs font-bold rounded-lg shadow-sm transition">
                            <i class="fas fa-pen-nib mr-1"></i> Tulis Kabar PKK Baru
                        </a>
                    </div>
                </div>
            @endif

            {{-- Filter Bar --}}
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <i class="fas fa-filter text-gray-400 text-sm"></i>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-600">Filter Wilayah:</span>
                </div>
                <form action="{{ route('posts.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('posts.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ empty($selectedRw) ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Semua Wilayah
                    </a>
                    <a href="{{ route('posts.index', ['rw' => 'umum']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $selectedRw === 'umum' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Umum Desa
                    </a>
                    @foreach (range(1, 10) as $r)
                        <a href="{{ route('posts.index', ['rw' => $r]) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ (string)$selectedRw === (string)$r ? 'bg-amber-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            RW {{ str_pad($r, 2, '0', STR_PAD_LEFT) }}
                        </a>
                    @endforeach
                </form>
            </div>

            {{-- Table Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50/75 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">No</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Judul Berita</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Wilayah / RW</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Kategori</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Penulis</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Tanggal Terbit</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($posts as $post)
                            <tr class="hover:bg-gray-50/60 transition">
                                <td class="px-6 py-4 text-xs font-medium text-gray-400">
                                    {{ $loop->iteration + ($posts->currentPage() - 1) * $posts->perPage() }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 max-w-md">
                                    <a href="{{ $post->getShowRoute() }}" target="_blank" class="hover:text-emerald-600 transition flex items-start gap-2">
                                        <span>{{ $post->title }}</span>
                                        <i class="fas fa-external-link-alt text-[10px] text-gray-400 mt-1"></i>
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($post->rw)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                            <i class="fas fa-map-marker-alt mr-1 text-amber-600"></i> RW {{ str_pad($post->rw, 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                            <i class="fas fa-globe mr-1 text-slate-400"></i> Umum / Desa
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-block px-2.5 py-0.5 rounded text-xs bg-gray-100 text-gray-700">
                                        {{ $post->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600">
                                    {{ $post->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ ($post->published_at ?? $post->created_at)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                                    @can('update', $post)
                                    <a href="{{ route('posts.edit', $post->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-blue-600 hover:text-white hover:bg-blue-600 rounded-lg border border-blue-200 transition">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    @endcan

                                    @can('delete', $post)
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-red-600 hover:text-white hover:bg-red-600 rounded-lg border border-red-200 transition">
                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-newspaper text-3xl mb-2 text-gray-300"></i>
                                        <p class="text-sm">Tidak ada berita yang ditemukan untuk filter ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($posts->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
