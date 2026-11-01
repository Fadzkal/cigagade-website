<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Daftar Kabar & Berita Desa') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Kelola seluruh warta dan publikasi berita Desa Cigagade, warta RW, serta validasi berita dari pengurus wilayah.
                </p>
            </div>
            <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-wider hover:bg-emerald-700 active:bg-emerald-800 shadow-sm transition">
                <i class="fas fa-plus mr-2"></i> Tulis Berita Baru
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-2xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 bg-rose-50 border border-rose-300 text-rose-800 rounded-2xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-rose-600 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800">
                        <i class="fas fa-times"></i>
                    </button>
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
                                Setiap berita yang Anda kirim akan diperiksa oleh <strong>Super Admin</strong> terlebih dahulu. Setelah disetujui, berita akan otomatis tampil di portal publik dengan tanda <strong>{{ Auth::user()->getRwLabel() }}</strong>.
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
                                Berita posyandu & kegiatan keluarga yang Anda kirimkan akan diverifikasi oleh <strong>Super Admin</strong> sebelum dipublikasikan ke seluruh warga.
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

            {{-- ─── TAB FILTER STATUS VALIDASI ─── --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                {{-- Semua --}}
                <a href="{{ route('posts.index', array_merge(request()->except(['status', 'page']), [])) }}"
                   class="p-4 rounded-2xl bg-white border {{ empty($status) ? 'ring-2 ring-emerald-500 border-emerald-400' : 'border-slate-200/80 hover:border-slate-300' }} shadow-sm transition group">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Semua Berita</span>
                        <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-xs">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    </div>
                    <p class="text-xl font-black text-slate-800 mt-1.5">{{ $stats['all'] }}</p>
                    <span class="text-[11px] text-slate-400">Total publikasi</span>
                </a>

                {{-- Menunggu Validasi --}}
                <a href="{{ route('posts.index', array_merge(request()->except(['status', 'page']), ['status' => 'pending'])) }}"
                   class="p-4 rounded-2xl bg-white border {{ $status === 'pending' ? 'ring-2 ring-amber-500 border-amber-400' : 'border-slate-200/80 hover:border-amber-300' }} shadow-sm transition group relative">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-600 uppercase tracking-wider">Menunggu Validasi</span>
                        <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <p class="text-xl font-black text-amber-600 mt-1.5">{{ $stats['pending'] }}</p>
                    <span class="text-[11px] text-amber-600 font-medium">Perlu review & persetujuan</span>
                    @if($stats['pending'] > 0)
                        <span class="absolute top-2 right-2 w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                    @endif
                </a>

                {{-- Tayang / Disetujui --}}
                <a href="{{ route('posts.index', array_merge(request()->except(['status', 'page']), ['status' => 'published'])) }}"
                   class="p-4 rounded-2xl bg-white border {{ $status === 'published' ? 'ring-2 ring-emerald-500 border-emerald-400' : 'border-slate-200/80 hover:border-emerald-300' }} shadow-sm transition group">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Tayang di Website</span>
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                            <i class="fas fa-circle-check"></i>
                        </div>
                    </div>
                    <p class="text-xl font-black text-emerald-700 mt-1.5">{{ $stats['published'] }}</p>
                    <span class="text-[11px] text-emerald-600 font-medium">Aktif tampil ke publik</span>
                </a>

                {{-- Ditolak / Revisi --}}
                <a href="{{ route('posts.index', array_merge(request()->except(['status', 'page']), ['status' => 'rejected'])) }}"
                   class="p-4 rounded-2xl bg-white border {{ $status === 'rejected' ? 'ring-2 ring-rose-500 border-rose-400' : 'border-slate-200/80 hover:border-rose-300' }} shadow-sm transition group">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-rose-600 uppercase tracking-wider">Ditolak / Revisi</span>
                        <div class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xs">
                            <i class="fas fa-circle-xmark"></i>
                        </div>
                    </div>
                    <p class="text-xl font-black text-rose-700 mt-1.5">{{ $stats['rejected'] }}</p>
                    <span class="text-[11px] text-rose-600 font-medium">Perlu perbaikan pembuat</span>
                </a>
            </div>

            {{-- Filter Bar Wilayah & Search --}}
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <form action="{{ route('posts.index') }}" method="GET" class="flex flex-wrap items-center gap-2 flex-1">
                    @if($status)
                        <input type="hidden" name="status" value="{{ $status }}">
                    @endif

                    {{-- Search Input --}}
                    <div class="relative min-w-[200px] flex-1 max-w-xs">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" name="search" value="{{ $search }}"
                               placeholder="Cari judul berita..."
                               class="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl border-gray-200 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400 mx-1">Wilayah:</span>
                    <a href="{{ route('posts.index', array_merge(request()->except(['rw', 'page']), [])) }}"
                       class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ empty($selectedRw) ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Semua
                    </a>
                    <a href="{{ route('posts.index', array_merge(request()->except(['rw', 'page']), ['rw' => 'umum'])) }}"
                       class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $selectedRw === 'umum' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Umum Desa
                    </a>
                    @foreach (range(1, 10) as $r)
                        <a href="{{ route('posts.index', array_merge(request()->except(['rw', 'page']), ['rw' => $r])) }}"
                           class="px-2.5 py-1.5 rounded-lg text-xs font-semibold transition {{ (string)$selectedRw === (string)$r ? 'bg-amber-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            RW {{ str_pad($r, 2, '0', STR_PAD_LEFT) }}
                        </a>
                    @endforeach

                    @if($search || $selectedRw || $status)
                        <a href="{{ route('posts.index') }}" class="px-2.5 py-1.5 rounded-lg text-xs bg-gray-200 text-gray-700 hover:bg-gray-300 font-semibold transition" title="Reset Semua Filter">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </form>
            </div>

            {{-- Table Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50/75 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-5 py-4 font-semibold w-12 text-center">No</th>
                                <th scope="col" class="px-5 py-4 font-semibold">Judul Berita</th>
                                <th scope="col" class="px-5 py-4 font-semibold">Status Validasi</th>
                                <th scope="col" class="px-5 py-4 font-semibold">Wilayah / RW</th>
                                <th scope="col" class="px-5 py-4 font-semibold">Penulis</th>
                                <th scope="col" class="px-5 py-4 font-semibold">Tanggal Kirim</th>
                                <th scope="col" class="px-5 py-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($posts as $post)
                            <tr class="hover:bg-gray-50/60 transition {{ $post->isPending() ? 'bg-amber-50/20' : '' }}">
                                {{-- Nomor --}}
                                <td class="px-5 py-4 text-xs font-medium text-gray-400 text-center">
                                    {{ $loop->iteration + ($posts->currentPage() - 1) * $posts->perPage() }}
                                </td>

                                {{-- Judul Berita --}}
                                <td class="px-5 py-4 font-medium text-gray-900 max-w-sm">
                                    <div>
                                        <a href="{{ $post->getShowRoute() }}" target="_blank" class="hover:text-emerald-600 transition font-bold text-slate-800 line-clamp-2">
                                            {{ $post->title }}
                                            <i class="fas fa-external-link-alt text-[10px] text-gray-400 ml-1"></i>
                                        </a>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold bg-gray-100 text-gray-600">
                                                {{ $post->category->name }}
                                            </span>
                                            @if($post->views > 0)
                                                <span class="text-[11px] text-gray-400">
                                                    <i class="fas fa-eye text-[10px]"></i> {{ number_format($post->views) }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Catatan Penolakan jika ada --}}
                                        @if($post->isRejected() && $post->rejection_note)
                                            <div class="mt-2 p-2.5 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800">
                                                <p class="font-bold flex items-center gap-1.5 text-rose-900">
                                                    <i class="fas fa-triangle-exclamation text-rose-600"></i> Catatan Revisi Super Admin:
                                                </p>
                                                <p class="mt-0.5 text-rose-700 italic">"{{ $post->rejection_note }}"</p>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                {{-- Status Validasi --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($post->isPending())
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">
                                            <i class="fas fa-clock text-amber-500"></i> Menunggu Validasi
                                        </span>
                                    @elseif($post->isPublished())
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <i class="fas fa-circle-check text-emerald-500"></i> Tayang di Web
                                        </span>
                                    @elseif($post->isRejected())
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <i class="fas fa-circle-xmark text-rose-500"></i> Ditolak / Revisi
                                        </span>
                                    @endif
                                </td>

                                {{-- Wilayah RW --}}
                                <td class="px-5 py-4 whitespace-nowrap">
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

                                {{-- Penulis --}}
                                <td class="px-5 py-4 whitespace-nowrap text-xs text-gray-700 font-medium">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold text-[10px]">
                                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $post->user->name }}</span>
                                    </div>
                                </td>

                                {{-- Tanggal Kirim / Terbit --}}
                                <td class="px-5 py-4 whitespace-nowrap text-xs text-gray-500">
                                    <div>
                                        <span class="font-medium text-gray-700">{{ $post->created_at->format('d M Y') }}</span>
                                        <p class="text-[10px] text-gray-400">{{ $post->created_at->format('H:i') }} WIB</p>
                                    </div>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-5 py-4 whitespace-nowrap text-right space-x-1">
                                    {{-- AKSI KHUSUS SUPER ADMIN: Validasi & Konfirmasi --}}
                                    @can('isSuperAdmin')
                                        @if($post->isPending())
                                            {{-- Tombol Setujui --}}
                                            <form action="{{ route('posts.approve', $post->id) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menyetujui berita ini? Berita akan langsung tayang di portal website.');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-sm transition"
                                                        title="Setujui dan Publikasikan">
                                                    <i class="fas fa-check"></i> Setujui
                                                </button>
                                            </form>

                                            {{-- Tombol Tolak (Buka Modal) --}}
                                            <button type="button"
                                                    data-action="{{ route('posts.reject', $post->id) }}"
                                                    data-title="{{ $post->title }}"
                                                    onclick="openRejectModal(this)"
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold transition"
                                                    title="Tolak / Minta Revisi">
                                                <i class="fas fa-xmark"></i> Tolak
                                            </button>
                                        @endif
                                    @endcan

                                    {{-- Tombol Edit --}}
                                    @can('update', $post)
                                    <a href="{{ route('posts.edit', $post->id) }}"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-blue-600 hover:text-white hover:bg-blue-600 rounded-lg border border-blue-200 transition"
                                       title="Edit Berita">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @endcan

                                    {{-- Tombol Hapus --}}
                                    @can('delete', $post)
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-2 py-1.5 text-xs font-semibold text-red-500 hover:text-white hover:bg-red-600 rounded-lg border border-red-200 transition"
                                                title="Hapus Berita">
                                            <i class="fas fa-trash-alt"></i>
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
                                        <p class="text-sm font-semibold text-gray-600">Tidak ada berita yang ditemukan.</p>
                                        <p class="text-xs text-gray-400 mt-1">Sesuaikan filter status atau wilayah untuk melihat data lainnya.</p>
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

        {{-- ─── MODAL TOLAK BERITA (SUPER ADMIN) ─── --}}
        <div id="rejectModal"
             class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 relative">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                            <i class="fas fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-base text-slate-800">Tolak & Minta Revisi Berita</h3>
                            <p class="text-xs text-slate-400">Berikan catatan perbaikan kepada pembuat berita</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeRejectModal()" class="text-slate-400 hover:text-slate-600">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <form id="rejectModalForm" method="POST" action="" class="mt-4 space-y-4" onsubmit="return validateRejectForm(this)">
                    @csrf
                    @method('PATCH')

                    <div>
                        <p class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Berita:</p>
                        <p id="rejectModalTitle" class="text-sm font-semibold text-slate-800 bg-slate-50 p-3 rounded-xl border border-slate-200">-</p>
                    </div>

                    <div>
                        <label for="rejection_note" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Alasan Penolakan / Catatan Perbaikan <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="rejection_note" id="rejection_note" rows="4"
                                  placeholder="Contoh: Mohon lengkapi foto dokumentasi gotong royong dan cantumkan tanggal pelaksanaan kegiatan dengan jelas..."
                                  class="w-full text-xs sm:text-sm rounded-xl border-slate-200 focus:border-rose-500 focus:ring-rose-500 text-slate-800"
                                  required></textarea>
                        <p class="text-[11px] text-slate-400 mt-1">Catatan ini akan langsung terlihat oleh pembuat berita di dashboard mereka agar dapat diperbaiki.</p>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
                        <button type="button" onclick="closeRejectModal()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold shadow-md shadow-rose-600/20 transition flex items-center gap-2">
                            <i class="fas fa-xmark"></i> Konfirmasi Penolakan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function openRejectModal(button) {
            const action = button.getAttribute('data-action');
            const title = button.getAttribute('data-title');

            const form = document.getElementById('rejectModalForm');
            const titleDisplay = document.getElementById('rejectModalTitle');
            const modal = document.getElementById('rejectModal');

            if (form && action) {
                form.action = action;
            }
            if (titleDisplay && title) {
                titleDisplay.textContent = title;
            }
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        function validateRejectForm(form) {
            if (!form.action || form.action === window.location.href || form.action.endsWith('/dashboard/posts')) {
                alert('Peringatan: URL tindakan penolakan belum ditentukan. Silakan klik tombol Tolak kembali.');
                return false;
            }
            return true;
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRejectModal();
            }
        });
    </script>
</x-app-layout>
