<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Pengaduan & Aspirasi <span class="text-emerald-600">Masyarakat</span>
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Kelola laporan, keluhan, dan aspirasi yang dikirimkan warga Desa Cigagade secara terpusat.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('pengaduan.index') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-slate-700 hover:text-emerald-600 text-xs font-bold border border-slate-200 shadow-sm transition">
                    <i class="fas fa-external-link-alt text-slate-400"></i> Buka Portal Warga
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- Flash Alert --}}
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fas fa-circle-check text-emerald-600 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 text-base">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        {{-- ─── KPI METRIC CARDS ────────────────────────────────────────────────── --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            <a href="{{ route('pengaduan.admin.index') }}" class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:border-emerald-400 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Aduan</span>
                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center text-sm group-hover:bg-slate-200 transition">
                        <i class="fas fa-inbox"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-slate-800 mt-2">{{ $stats['total'] }}</p>
                <span class="text-[11px] text-slate-400">Semua laporan masuk</span>
            </a>

            <a href="{{ route('pengaduan.admin.index', ['status' => 'menunggu']) }}" class="p-5 rounded-2xl bg-white border {{ request('status') === 'menunggu' ? 'ring-2 ring-amber-500 border-amber-300' : 'border-slate-200/80' }} shadow-sm hover:border-amber-400 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-amber-600 uppercase tracking-wider">Menunggu</span>
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm group-hover:bg-amber-100 transition">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-amber-600 mt-2">{{ $stats['menunggu'] }}</p>
                <span class="text-[11px] text-amber-600 font-medium">Perlu verifikasi & telaah</span>
            </a>

            <a href="{{ route('pengaduan.admin.index', ['status' => 'diproses']) }}" class="p-5 rounded-2xl bg-white border {{ request('status') === 'diproses' ? 'ring-2 ring-blue-500 border-blue-300' : 'border-slate-200/80' }} shadow-sm hover:border-blue-400 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Diproses</span>
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm group-hover:bg-blue-100 transition">
                        <i class="fas fa-spinner"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-blue-600 mt-2">{{ $stats['diproses'] }}</p>
                <span class="text-[11px] text-blue-600 font-medium">Sedang ditindaklanjuti</span>
            </a>

            <a href="{{ route('pengaduan.admin.index', ['status' => 'selesai']) }}" class="p-5 rounded-2xl bg-white border {{ request('status') === 'selesai' ? 'ring-2 ring-emerald-500 border-emerald-300' : 'border-slate-200/80' }} shadow-sm hover:border-emerald-400 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Selesai</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm group-hover:bg-emerald-100 transition">
                        <i class="fas fa-circle-check"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-emerald-600 mt-2">{{ $stats['selesai'] }}</p>
                <span class="text-[11px] text-emerald-600 font-medium">Tuntas terjawab</span>
            </a>

            <a href="{{ route('pengaduan.admin.index', ['status' => 'ditolak']) }}" class="p-5 rounded-2xl bg-white border {{ request('status') === 'ditolak' ? 'ring-2 ring-rose-500 border-rose-300' : 'border-slate-200/80' }} shadow-sm hover:border-rose-400 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-rose-600 uppercase tracking-wider">Ditolak</span>
                    <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-sm group-hover:bg-rose-100 transition">
                        <i class="fas fa-circle-xmark"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-rose-600 mt-2">{{ $stats['ditolak'] }}</p>
                <span class="text-[11px] text-rose-500">Tidak valid / spam</span>
            </a>
        </div>

        {{-- ─── FILTER & SEARCH ────────────────────────────────────────────────── --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/80">
            <form action="{{ route('pengaduan.admin.index') }}" method="GET" class="flex flex-col md:flex-row items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                    {{-- Filter Status --}}
                    <select name="status" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-slate-50 focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>

                    {{-- Filter Kategori --}}
                    <select name="kategori" onchange="this.form.submit()" class="px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-slate-50 focus:ring-2 focus:ring-emerald-500 outline-none">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriList as $kName => $kData)
                            <option value="{{ $kName }}" {{ request('kategori') === $kName ? 'selected' : '' }}>{{ $kName }}</option>
                        @endforeach
                    </select>

                    @if(request()->anyFilled(['status', 'kategori', 'q']))
                        <a href="{{ route('pengaduan.admin.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition">
                            <i class="fas fa-rotate-left mr-1"></i> Reset Filter
                        </a>
                    @endif
                </div>

                {{-- Search Box --}}
                <div class="relative w-full md:w-72">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari tiket, nama, judul..."
                           class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-800 bg-slate-50 focus:ring-2 focus:ring-emerald-500 outline-none">
                    <i class="fas fa-search text-slate-400 absolute left-3 top-2.5 text-xs"></i>
                </div>
            </form>
        </div>

        {{-- ─── TABEL PENGADUAN ───────────────────────────────────────────────── --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-200 text-slate-500 text-[11px] font-bold uppercase tracking-wider">
                            <th class="py-3.5 px-4">Kode Tiket</th>
                            <th class="py-3.5 px-4">Pelapor</th>
                            <th class="py-3.5 px-4">Kategori & Judul</th>
                            <th class="py-3.5 px-4">Lokasi</th>
                            <th class="py-3.5 px-4">Bukti Foto</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4">Tanggal Masuk</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pengaduans as $pgd)
                            <tr class="hover:bg-slate-50/80 transition">
                                {{-- Kode Tiket --}}
                                <td class="py-3.5 px-4 font-mono font-bold text-xs text-emerald-700 whitespace-nowrap">
                                    {{ $pgd->kode_tiket }}
                                </td>

                                {{-- Pelapor --}}
                                <td class="py-3.5 px-4">
                                    @if($pgd->is_anonim)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-xs font-semibold">
                                            <i class="fas fa-user-secret text-slate-400"></i> Anonim
                                        </span>
                                    @else
                                        <p class="font-bold text-slate-800 text-xs">{{ $pgd->nama }}</p>
                                    @endif

                                    @if($pgd->kontak)
                                        <a href="{{ $pgd->whatsapp_link }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-emerald-600 hover:underline mt-0.5" title="Chat WhatsApp">
                                            <i class="fab fa-whatsapp text-emerald-500"></i> {{ $pgd->kontak }}
                                        </a>
                                    @endif
                                </td>

                                {{-- Kategori & Judul --}}
                                <td class="py-3.5 px-4 max-w-xs">
                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-slate-100 text-slate-600">
                                        {{ $pgd->kategori }}
                                    </span>
                                    <p class="font-bold text-slate-800 text-xs mt-1 line-clamp-1" title="{{ $pgd->judul }}">
                                        {{ $pgd->judul }}
                                    </p>
                                    <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">
                                        {{ $pgd->isi_pengaduan }}
                                    </p>
                                </td>

                                {{-- Lokasi --}}
                                <td class="py-3.5 px-4 text-xs text-slate-600 whitespace-nowrap">
                                    {{ $pgd->lokasi ?: '-' }}
                                </td>

                                {{-- Bukti Foto --}}
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($pgd->foto_bukti)
                                        <a href="{{ $pgd->foto_url }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-semibold transition">
                                            <i class="fas fa-image"></i> Ada Foto
                                        </a>
                                    @else
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $pgd->status_badge['bg'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $pgd->status_badge['dot'] }}"></span>
                                        {{ $pgd->status_label }}
                                    </span>
                                </td>

                                {{-- Tanggal Masuk --}}
                                <td class="py-3.5 px-4 text-xs text-slate-500 whitespace-nowrap">
                                    {{ $pgd->created_at->translatedFormat('d M Y, H:i') }}
                                </td>

                                {{-- Aksi --}}
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('pengaduan.admin.show', $pgd->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-sm transition">
                                            <i class="fas fa-reply mr-1.5"></i> Tanggapi
                                        </a>

                                        <form action="{{ route('pengaduan.admin.destroy', $pgd->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengaduan {{ $pgd->kode_tiket }} ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus Pengaduan">
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-slate-400">
                                    <i class="fas fa-inbox text-4xl mb-2 text-slate-300"></i>
                                    <p class="font-semibold text-sm">Tidak ada data pengaduan yang sesuai filter.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $pengaduans->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
