<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
                    @if($isRw)
                        Panel Warta <span class="text-amber-600">{{ Auth::user()->getRwLabel() }}</span>
                    @elseif($isPkk)
                        Panel <span class="text-pink-600">Kader TP-PKK & Posyandu</span>
                    @else
                        Dashboard <span class="text-indigo-600">Statistik Desa</span>
                    @endif
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    @if($isRw)
                        Selamat bertugas, {{ Auth::user()->name }}. Publikasikan kegiatan dan kabar warga wilayah Anda.
                    @elseif($isPkk)
                        Selamat bertugas, Kader PKK! Kelola publikasi kegiatan Posyandu, kesehatan keluarga, dan 10 Program Pokok PKK Desa Cigagade.
                    @else
                        Pusat kendali dan monitoring informasi Desa Cigagade, Balubur Limbangan, Garut.
                    @endif
                </p>
            </div>
            <div class="text-sm text-gray-500 font-medium bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100 hidden sm:flex items-center">
                <i class="fas fa-calendar-alt mr-2 text-emerald-500"></i> {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">

            @if($isRw)
                {{-- ─── RW HERO BANNER ─────────────────────────────────────────── --}}
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-800 via-teal-800 to-slate-900 text-white p-6 sm:p-8 shadow-xl">
                    <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-emerald-500/20 blur-3xl pointer-events-none"></div>
                    <div class="relative flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                        <div class="space-y-2 max-w-2xl">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-400 text-amber-950 uppercase tracking-wider shadow-sm">
                                <i class="fas fa-map-marker-alt mr-1.5"></i> Akun Resmi {{ Auth::user()->getRwLabel() }}
                            </span>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">
                                Selamat Datang, Pengurus {{ Auth::user()->getRwLabel() }}!
                            </h3>
                            <p class="text-emerald-100/90 text-sm leading-relaxed">
                                Anda memiliki akses untuk mengunggah dan mengelola kabar berita seputar kegiatan warga, gotong royong, posyandu, dan pengumuman di lingkungan <strong>{{ Auth::user()->getRwLabel() }}</strong>. Berita Anda akan langsung tampil di portal utama Desa Cigagade dengan tanda khusus.
                            </p>
                        </div>
                        <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 shrink-0">
                            <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center px-5 py-3 bg-amber-400 hover:bg-amber-300 text-slate-900 font-bold text-sm rounded-xl shadow-md transition whitespace-nowrap">
                                <i class="fas fa-pen-nib mr-2"></i> + Tulis Berita {{ Auth::user()->getRwLabel() }}
                            </a>
                            <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center px-5 py-3 bg-white/15 hover:bg-white/25 text-white font-semibold text-sm rounded-xl backdrop-blur-sm border border-white/20 transition whitespace-nowrap">
                                <i class="fas fa-list mr-2"></i> Kelola Berita
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ─── RW SUMMARY STATS ───────────────────────────────────────── --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="bg-white rounded-2xl p-6 border border-amber-100 shadow-sm flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl shadow-inner">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Berita {{ Auth::user()->getRwLabel() }}</p>
                            <p class="text-3xl font-black text-gray-800 mt-1">{{ $rwPostCount }}</p>
                            <span class="text-[11px] text-amber-600 font-medium">Artikel dipublikasikan</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-blue-100 shadow-sm flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shadow-inner">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pembaca</p>
                            <p class="text-3xl font-black text-gray-800 mt-1">{{ number_format($rwViewsCount) }}</p>
                            <span class="text-[11px] text-blue-600 font-medium">Kali dibaca warga</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-emerald-100 shadow-sm flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shadow-inner">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Berita Desa</p>
                            <p class="text-3xl font-black text-gray-800 mt-1">{{ $totalPosts }}</p>
                            <span class="text-[11px] text-emerald-600 font-medium">Seluruh Desa Cigagade</span>
                        </div>
                    </div>
                </div>

                {{-- ─── RW LATEST POSTS TABLE ─────────────────────────────────── --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-bullhorn text-amber-500"></i>
                                Berita Lingkungan {{ Auth::user()->getRwLabel() }} Terbaru
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">Daftar artikel yang diterbitkan atas nama {{ Auth::user()->getRwLabel() }}.</p>
                        </div>
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition">
                            <i class="fas fa-plus mr-1.5"></i> Tambah Berita Baru
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50/75 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Judul Berita</th>
                                    <th class="px-6 py-4 font-semibold">Kategori</th>
                                    <th class="px-6 py-4 font-semibold">Tanggal</th>
                                    <th class="px-6 py-4 font-semibold text-center">Views</th>
                                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($rwPosts as $p)
                                <tr class="hover:bg-gray-50/60 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <a href="{{ $p->getShowRoute() }}" target="_blank" class="hover:text-emerald-600 transition flex items-center gap-2">
                                            <span>{{ $p->title }}</span>
                                            <i class="fas fa-external-link-alt text-[10px] text-gray-400"></i>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-0.5 rounded text-xs bg-gray-100 text-gray-700">
                                            {{ $p->category->name ?? 'Kabar Desa' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                        {{ ($p->published_at ?? $p->created_at)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-xs font-semibold text-gray-700">
                                        {{ number_format($p->views) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                                        <a href="{{ route('posts.edit', $p->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-blue-600 hover:bg-blue-50 rounded-lg border border-blue-200 transition">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('posts.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50 rounded-lg border border-red-200 transition">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                        <i class="fas fa-newspaper text-3xl mb-2 text-gray-300"></i>
                                        <p class="text-sm font-medium">Belum ada berita yang diterbitkan oleh {{ Auth::user()->getRwLabel() }}.</p>
                                        <a href="{{ route('posts.create') }}" class="inline-block mt-3 text-xs text-emerald-600 font-bold hover:underline">
                                            + Mulai Tulis Berita Pertama
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @elseif($isPkk)
                {{-- ─── PKK HERO BANNER ─────────────────────────────────────────── --}}
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-rose-800 via-pink-800 to-slate-900 text-white p-6 sm:p-8 shadow-xl">
                    <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-pink-500/20 blur-3xl pointer-events-none"></div>
                    <div class="relative flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                        <div class="space-y-2 max-w-2xl">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-pink-100 text-pink-950 uppercase tracking-wider shadow-sm">
                                <i class="fas fa-heart mr-1.5 text-pink-600"></i> Akun Resmi TP-PKK Desa Cigagade
                            </span>
                            <h3 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">
                                Selamat Datang, Tim Penggerak PKK & Kader Posyandu!
                            </h3>
                            <p class="text-pink-100/90 text-sm leading-relaxed">
                                Anda memiliki akses untuk mengunggah dan mempublikasikan agenda <strong>10 Program Pokok PKK</strong>, kegiatan rutin Posyandu balita & lansia, edukasi gizi & pencegahan stunting, ketahanan pangan keluarga (HATINYA PKK), serta inovasi pemberdayaan perempuan di Desa Cigagade.
                            </p>
                        </div>
                        <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 shrink-0">
                            <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center px-5 py-3 bg-pink-500 hover:bg-pink-400 text-white font-bold text-sm rounded-xl shadow-lg shadow-pink-500/30 transition whitespace-nowrap">
                                <i class="fas fa-pen-nib mr-2"></i> + Tulis Kabar PKK & Posyandu
                            </a>
                            <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center px-5 py-3 bg-white/15 hover:bg-white/25 text-white font-semibold text-sm rounded-xl backdrop-blur-sm border border-white/20 transition whitespace-nowrap">
                                <i class="fas fa-list mr-2"></i> Kelola Artikel
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ─── PKK SUMMARY STATS ───────────────────────────────────────── --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="bg-white rounded-2xl p-6 border border-pink-100 shadow-sm flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center text-2xl shadow-inner">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Artikel PKK & Posyandu</p>
                            <p class="text-3xl font-black text-gray-800 mt-1">{{ $pkkPostCount }}</p>
                            <span class="text-[11px] text-pink-600 font-medium">Artikel dipublikasikan</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-rose-100 shadow-sm flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl shadow-inner">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pembaca</p>
                            <p class="text-3xl font-black text-gray-800 mt-1">{{ number_format($pkkViewsCount) }}</p>
                            <span class="text-[11px] text-rose-600 font-medium">Kali dibaca warga</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-emerald-100 shadow-sm flex items-center gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shadow-inner">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Berita Desa</p>
                            <p class="text-3xl font-black text-gray-800 mt-1">{{ $totalPosts }}</p>
                            <span class="text-[11px] text-emerald-600 font-medium">Seluruh Desa Cigagade</span>
                        </div>
                    </div>
                </div>

                {{-- ─── 4 POKJA PKK PROGRAM HIGHLIGHTS ─────────────────────────────── --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-8 h-8 rounded-xl bg-pink-100 text-pink-700 flex items-center justify-center text-xs font-extrabold">I</span>
                            <span class="text-xs font-bold text-gray-800">Pokja I</span>
                        </div>
                        <p class="text-[11px] text-gray-500 leading-tight">Penghayatan Pancasila, Pola Asuh Anak & Remaja, Gotong Royong</p>
                    </div>
                    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-xs font-extrabold">II</span>
                            <span class="text-xs font-bold text-gray-800">Pokja II</span>
                        </div>
                        <p class="text-[11px] text-gray-500 leading-tight">Pendidikan, Keterampilan Keluarga & Usaha Peningkatan Pendapatan (UP2K)</p>
                    </div>
                    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-extrabold">III</span>
                            <span class="text-xs font-bold text-gray-800">Pokja III</span>
                        </div>
                        <p class="text-[11px] text-gray-500 leading-tight">Ketahanan Pangan Rumah Tangga (HATINYA PKK), Sandang & Perumahan Sehat</p>
                    </div>
                    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center text-xs font-extrabold">IV</span>
                            <span class="text-xs font-bold text-gray-800">Pokja IV</span>
                        </div>
                        <p class="text-[11px] text-gray-500 leading-tight">Kesehatan Ibu & Anak, Penimbangan Posyandu, Cegah Stunting, Kelestarian LH</p>
                    </div>
                </div>

                {{-- ─── PKK LATEST POSTS TABLE ─────────────────────────────────── --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-bullhorn text-pink-500"></i>
                                Publikasi Kegiatan TP-PKK & Posyandu Terbaru
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">Daftar artikel yang diterbitkan oleh Akun Resmi TP-PKK Desa Cigagade.</p>
                        </div>
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-pink-600 text-white rounded-xl text-xs font-bold hover:bg-pink-700 transition">
                            <i class="fas fa-plus mr-1.5"></i> Tambah Artikel Baru
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50/75 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Judul Berita</th>
                                    <th class="px-6 py-4 font-semibold">Kategori</th>
                                    <th class="px-6 py-4 font-semibold">Tanggal</th>
                                    <th class="px-6 py-4 font-semibold text-center">Views</th>
                                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($pkkPosts as $p)
                                <tr class="hover:bg-gray-50/60 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <a href="{{ $p->getShowRoute() }}" target="_blank" class="hover:text-pink-600 transition flex items-center gap-2">
                                            <span>{{ $p->title }}</span>
                                            <i class="fas fa-external-link-alt text-[10px] text-gray-400"></i>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-0.5 rounded text-xs bg-pink-50 text-pink-700 font-medium border border-pink-100">
                                            {{ $p->category->name ?? 'TP-PKK Desa' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                        {{ ($p->published_at ?? $p->created_at)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-xs font-semibold text-gray-700">
                                        {{ number_format($p->views) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                                        <a href="{{ route('posts.edit', $p->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-blue-600 hover:bg-blue-50 rounded-lg border border-blue-200 transition">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('posts.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50 rounded-lg border border-red-200 transition">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                        <i class="fas fa-heart text-3xl mb-2 text-pink-300"></i>
                                        <p class="text-sm font-medium">Belum ada artikel yang diterbitkan oleh Tim Penggerak PKK.</p>
                                        <a href="{{ route('posts.create') }}" class="inline-block mt-3 text-xs text-pink-600 font-bold hover:underline">
                                            + Mulai Tulis Berita Pertama
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            @else
                {{-- ─── SUPERADMIN DASHBOARD ──────────────────────────────────────── --}}

                {{-- Permohonan Surat Quick Banner --}}
                <div class="rounded-3xl bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 text-white p-6 shadow-xl border border-emerald-500/20 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-48 h-48 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>
                    <div class="relative space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                <i class="fas fa-file-signature mr-1"></i> Layanan Surat Mandiri KKN
                            </span>
                            @if(isset($pendingSurat) && $pendingSurat > 0)
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-white animate-pulse">
                                    {{ $pendingSurat }} Menunggu Verifikasi
                                </span>
                            @endif
                        </div>
                        <h3 class="text-xl sm:text-2xl font-black text-white">
                            Pusat Pelayanan & Cetak Surat Desa Cigagade
                        </h3>
                        <p class="text-xs text-slate-300 max-w-2xl leading-relaxed">
                            Kelola 7 template surat resmi (SKU, SKBB, SKD, SKTM, SKM, SKBM, SKP). Unduh langsung dalam format <strong>Word (.docx)</strong> dan <strong>PDF Resmi</strong> serta pantau statistiknya secara real-time.
                        </p>
                    </div>
                    <div class="relative flex items-center gap-3 shrink-0">
                        <a href="{{ route('surat.admin.create') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs border border-white/20 transition-all flex items-center gap-1.5">
                            <i class="fas fa-plus"></i> + Buat Surat
                        </a>
                        <a href="{{ route('surat.admin.index') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-500/30 transition-all flex items-center gap-1.5">
                            <i class="fas fa-folder-open"></i> Kelola Surat ({{ $totalSurat ?? 0 }})
                        </a>
                    </div>
                </div>

                {{-- Summary Cards --}}
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-8 gap-4">
                    @php
                        $cards = [
                            ['label' => 'Permohonan Surat', 'value' => $totalSurat ?? 0, 'icon' => 'fa-file-signature', 'color' => 'teal', 'link' => route('surat.admin.index')],
                            ['label' => 'Pengaduan Warga',  'value' => $totalPengaduan ?? 0, 'icon' => 'fa-bullhorn',       'color' => 'amber', 'link' => route('pengaduan.admin.index')],
                            ['label' => 'Total Artikel',    'value' => $totalPosts,      'icon' => 'fa-newspaper',  'color' => 'blue',    'link' => route('posts.index')],
                            ['label' => 'Total Views',      'value' => number_format($totalViews), 'icon' => 'fa-eye', 'color' => 'indigo',  'link' => null],
                            ['label' => 'Produk UMKM',      'value' => $totalUmkm,       'icon' => 'fa-store',      'color' => 'emerald', 'link' => route('umkm.admin.index')],
                            ['label' => 'Kategori',         'value' => $totalCategories, 'icon' => 'fa-tags',       'color' => 'purple',  'link' => route('categories.index')],
                            ['label' => 'Galeri Desa',      'value' => $totalGalleries,  'icon' => 'fa-images',     'color' => 'pink',    'link' => route('galleries.index')],
                            ['label' => 'Perangkat Desa',   'value' => $totalMinistries, 'icon' => 'fa-users-gear', 'color' => 'orange',  'link' => route('ministries.index')],
                            ['label' => 'Mitra & Instansi', 'value' => $totalPartners,   'icon' => 'fa-handshake',  'color' => 'green',   'link' => route('partners.index')],
                        ];
                        $colorMap = [
                            'teal'   => ['bg' => 'bg-teal-50',   'icon' => 'bg-teal-100 text-teal-600',   'val' => 'text-teal-700',   'border' => 'border-teal-100'],
                            'amber'  => ['bg' => 'bg-amber-50',  'icon' => 'bg-amber-100 text-amber-600',  'val' => 'text-amber-700',  'border' => 'border-amber-100'],
                            'blue'   => ['bg' => 'bg-blue-50',   'icon' => 'bg-blue-100 text-blue-600',   'val' => 'text-blue-700',   'border' => 'border-blue-100'],
                            'indigo' => ['bg' => 'bg-indigo-50', 'icon' => 'bg-indigo-100 text-indigo-600','val' => 'text-indigo-700', 'border' => 'border-indigo-100'],
                            'emerald'=> ['bg' => 'bg-emerald-50','icon' => 'bg-emerald-100 text-emerald-600','val' => 'text-emerald-700','border' => 'border-emerald-100'],
                            'purple' => ['bg' => 'bg-purple-50', 'icon' => 'bg-purple-100 text-purple-600','val' => 'text-purple-700', 'border' => 'border-purple-100'],
                            'pink'   => ['bg' => 'bg-pink-50',   'icon' => 'bg-pink-100 text-pink-600',   'val' => 'text-pink-700',   'border' => 'border-pink-100'],
                            'orange' => ['bg' => 'bg-orange-50', 'icon' => 'bg-orange-100 text-orange-600','val' => 'text-orange-700', 'border' => 'border-orange-100'],
                            'green'  => ['bg' => 'bg-green-50',  'icon' => 'bg-green-100 text-green-600',  'val' => 'text-green-700',  'border' => 'border-green-100'],
                        ];
                    @endphp
                    @foreach($cards as $card)
                    @php $c = $colorMap[$card['color']]; @endphp
                    <{{ $card['link'] ? 'a href=' . $card['link'] : 'div' }} class="relative overflow-hidden rounded-2xl p-5 {{ $c['bg'] }} border {{ $c['border'] }} shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 flex flex-col gap-3 group {{ $card['link'] ? 'cursor-pointer' : '' }}">
                        <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full opacity-40 {{ $c['icon'] }} blur-2xl group-hover:blur-xl transition-all duration-300"></div>
                        <div class="relative w-12 h-12 rounded-xl flex items-center justify-center {{ $c['icon'] }} shadow-inner">
                            <i class="fas {{ $card['icon'] }} text-lg"></i>
                        </div>
                        <div class="relative mt-1">
                            <p class="text-sm text-gray-500 font-semibold mb-1">{{ $card['label'] }}</p>
                            <p class="text-3xl font-black {{ $c['val'] }} tracking-tight">{{ $card['value'] }}</p>
                        </div>
                    </{{ $card['link'] ? 'a' : 'div' }}>
                    @endforeach
                </div>

                {{-- Charts Row --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Posts per Category Chart --}}
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <i class="fas fa-chart-bar text-sm"></i>
                                </div>
                                Artikel per Kategori
                            </h3>
                        </div>
                        <div class="relative h-[250px]">
                            <canvas id="chartPostsByCategory"></canvas>
                        </div>
                    </div>

                    {{-- Views per Category Chart --}}
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center">
                                    <i class="fas fa-chart-pie text-sm"></i>
                                </div>
                                Views per Kategori
                            </h3>
                        </div>
                        <div class="relative h-[250px] flex justify-center">
                            <canvas id="chartViewsByCategory"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Tables Row --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Top 10 Popular Posts --}}
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 flex flex-col">
                        <div class="p-6 border-b border-gray-50">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center">
                                    <i class="fas fa-fire text-sm"></i>
                                </div>
                                Top 10 Artikel Terpopuler
                            </h3>
                        </div>
                        <div class="overflow-x-auto flex-1 p-2">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-100 bg-gray-50/50">
                                        <th class="text-center py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-lg">Rank</th>
                                        <th class="text-left py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Judul</th>
                                        <th class="text-left py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Wilayah</th>
                                        <th class="text-right py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-lg">Views</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($popularPosts as $i => $post)
                                    <tr class="hover:bg-indigo-50/30 transition-colors group">
                                        <td class="py-3 px-4">
                                            @php
                                                $rankBadge = match($i) {
                                                    0 => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                                    1 => 'bg-gray-200 text-gray-700 border-gray-300',
                                                    2 => 'bg-orange-100 text-orange-800 border-orange-200',
                                                    default => 'bg-slate-50 text-slate-500 border-slate-100'
                                                };
                                            @endphp
                                            <div class="w-7 h-7 mx-auto rounded-full border flex items-center justify-center font-bold text-xs {{ $rankBadge }} shadow-sm">
                                                {{ $i + 1 }}
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <a href="{{ route('berita.show', $post->slug) }}" target="_blank"
                                               class="text-gray-700 font-semibold group-hover:text-indigo-600 transition-colors line-clamp-1">
                                                {{ $post->title }}
                                            </a>
                                        </td>
                                        <td class="py-3 px-4 whitespace-nowrap">
                                            @if($post->rw)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-amber-100 text-amber-800">
                                                    RW {{ str_pad($post->rw, 2, '0', STR_PAD_LEFT) }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-gray-100 text-gray-600">
                                                    Umum
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <i class="fas fa-eye text-gray-300 text-[10px]"></i>
                                                <span class="font-bold text-gray-700">{{ number_format($post->views) }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="py-8 text-center text-gray-400 text-sm">Belum ada data views.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Latest 5 Posts --}}
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 flex flex-col">
                        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center">
                                    <i class="fas fa-clock text-sm"></i>
                                </div>
                                5 Berita Terbaru
                            </h3>
                            <a href="{{ route('posts.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold">Lihat Semua →</a>
                        </div>
                        <div class="divide-y divide-gray-50 flex-1">
                            @forelse($latestPosts as $post)
                            <div class="p-4 hover:bg-gray-50/50 transition-colors flex items-center justify-between gap-4">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        @if($post->rw)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">
                                                RW {{ str_pad($post->rw, 2, '0', STR_PAD_LEFT) }}
                                            </span>
                                        @endif
                                        <span class="text-xs text-gray-400 font-medium">
                                            {{ ($post->published_at ?? $post->created_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                    <a href="{{ route('berita.show', $post->slug) }}" target="_blank"
                                       class="text-sm font-semibold text-gray-800 hover:text-indigo-600 transition-colors line-clamp-1">
                                        {{ $post->title }}
                                    </a>
                                    <p class="text-xs text-gray-400 mt-0.5">Oleh: {{ $post->user->name ?? 'Admin' }}</p>
                                </div>
                                <a href="{{ route('posts.edit', $post->id) }}" class="text-gray-400 hover:text-indigo-600 text-xs font-semibold px-2.5 py-1 rounded-md border border-gray-200 hover:border-indigo-300 transition-colors">
                                    Edit
                                </a>
                            </div>
                            @empty
                            <p class="p-8 text-center text-gray-400 text-sm">Belum ada artikel.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Permohonan Surat Warga Terbaru Table --}}
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                                    <i class="fas fa-file-signature text-sm"></i>
                                </div>
                                Permohonan Surat Warga Terbaru
                            </h3>
                            <p class="text-xs text-gray-500 mt-0.5">5 permohonan surat masuk paling mutakhir dari warga Desa Cigagade.</p>
                        </div>
                        <a href="{{ route('surat.admin.index') }}" class="text-xs text-teal-600 hover:text-teal-800 font-semibold flex items-center gap-1">
                            <span>Buka Semua Permohonan ({{ $totalSurat ?? 0 }})</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left text-gray-600">
                            <thead class="text-[10px] text-gray-500 uppercase bg-gray-50/75 border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Kode Lacak</th>
                                    <th class="px-6 py-3 font-semibold">Jenis Template</th>
                                    <th class="px-6 py-3 font-semibold">Nama Pemohon</th>
                                    <th class="px-6 py-3 font-semibold">Wilayah</th>
                                    <th class="px-6 py-3 font-semibold">Status</th>
                                    <th class="px-6 py-3 font-semibold text-center">Unduh Cepat</th>
                                    <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($latestSurats ?? [] as $s)
                                <tr class="hover:bg-gray-50/60 transition">
                                    <td class="px-6 py-3 font-mono font-bold text-gray-900">{{ $s->tracking_code }}</td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded font-bold text-[10px] bg-slate-100 text-slate-800">
                                            {{ $s->jenis_info['short'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 font-bold text-gray-800">{{ $s->nama_lengkap }}</td>
                                    <td class="px-6 py-3 text-gray-500">RT {{ $s->rt }} / RW {{ $s->rw }}</td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $s->status_badge['bg'] }}">
                                            <i class="fas {{ $s->status_badge['icon'] }} text-[9px]"></i>
                                            <span>{{ $s->status_badge['label'] }}</span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <div class="inline-flex items-center gap-1">
                                            <a href="{{ route('surat.admin.print', $s->id) }}" target="_blank" class="w-6 h-6 rounded bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-700" title="Pratinjau / Print">
                                                <i class="fas fa-print text-[10px]"></i>
                                            </a>
                                            <a href="{{ route('surat.admin.word', $s->id) }}" class="w-6 h-6 rounded bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-blue-600" title="Unduh Word (.docx)">
                                                <i class="fas fa-file-word text-[10px]"></i>
                                            </a>
                                            <a href="{{ route('surat.admin.pdf', $s->id) }}" class="w-6 h-6 rounded bg-rose-50 hover:bg-rose-100 flex items-center justify-center text-rose-600" title="Unduh PDF">
                                                <i class="fas fa-file-pdf text-[10px]"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-right">
                                        <a href="{{ route('surat.admin.show', $s->id) }}" class="text-xs text-teal-600 hover:text-teal-800 font-semibold">
                                            Kelola →
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="py-6 text-center text-gray-400">Belum ada permohonan surat masuk.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

    </div>

    {{-- Charts Scripts (hanya jika superadmin) --}}
    @if(!$isRw)
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const catLabels = @json($postsByCategory->pluck('name'));
        const catCounts = @json($postsByCategory->pluck('posts_count'));

        new Chart(document.getElementById('chartPostsByCategory'), {
            type: 'bar',
            data: {
                labels: catLabels,
                datasets: [{
                    label: 'Jumlah Artikel',
                    data: catCounts,
                    backgroundColor: 'rgba(59, 130, 246, 0.85)',
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { stepSize: 1, padding: 10 }, 
                        grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false } 
                    },
                    x: { 
                        grid: { display: false, drawBorder: false },
                        ticks: { padding: 10 }
                    }
                }
            }
        });

        const viewLabels  = @json($viewsByCategory->pluck('name'));
        const viewCounts  = @json($viewsByCategory->pluck('total_views'));
        const bgColors = [
            'rgba(99, 102, 241, 0.85)',
            'rgba(236, 72, 153, 0.85)',
            'rgba(16, 185, 129, 0.85)',
            'rgba(245, 158, 11, 0.85)',
            'rgba(239, 68, 68, 0.85)',
            'rgba(59, 130, 246, 0.85)',
            'rgba(168, 85, 247, 0.85)',
            'rgba(20, 184, 166, 0.85)',
        ];

        new Chart(document.getElementById('chartViewsByCategory'), {
            type: 'doughnut',
            data: {
                labels: viewLabels,
                datasets: [{
                    data: viewCounts,
                    backgroundColor: bgColors,
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: { 
                        position: 'right', 
                        labels: { 
                            font: { size: 12 }, 
                            padding: 16,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        } 
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        padding: 12,
                        cornerRadius: 8
                    }
                }
            }
        });
    </script>
    @endif
</x-app-layout>