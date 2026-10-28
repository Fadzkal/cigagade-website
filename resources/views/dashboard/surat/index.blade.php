<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-600 text-white flex items-center justify-center shadow-md shadow-emerald-500/20">
                        <i class="fas fa-file-signature text-lg"></i>
                    </span>
                    <span>Pelayanan Surat & Administrasi Warga</span>
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola dan cetak 7 template surat resmi Desa Cigagade sesuai standar pelayanan KKN.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('surat.admin.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-semibold text-sm shadow-md shadow-emerald-600/20 transition-all">
                    <i class="fas fa-plus"></i>
                    <span>+ Buat Surat Baru (Offline)</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 space-y-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ALERT NOTIFIKASI --}}
        @if (session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fas fa-circle-check text-emerald-600 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        {{-- ─── 1. STATISTIK UTAMA (KPI CARDS) ─────────────────────────── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Total Permohonan -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Permohonan</p>
                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($totalCount) }}</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Semua data surat masuk</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center text-xl shadow-inner">
                    <i class="fas fa-folder-open"></i>
                </div>
            </div>

            <!-- Menunggu Verifikasi (Pending) -->
            <div class="bg-white rounded-2xl p-5 border border-amber-200 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute top-0 right-0 w-2 h-full bg-amber-500"></div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                        <p class="text-xs font-semibold text-amber-700 uppercase tracking-wider">Perlu Verifikasi</p>
                    </div>
                    <h3 class="text-2xl font-extrabold text-amber-600 mt-1">{{ number_format($pendingCount) }}</h3>
                    <p class="text-[11px] text-amber-600/80 mt-0.5">Permohonan warga baru</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>

            <!-- Sedang Diproses -->
            <div class="bg-white rounded-2xl p-5 border border-blue-200 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-xs font-semibold text-blue-700 uppercase tracking-wider">Sedang Diproses</p>
                    <h3 class="text-2xl font-extrabold text-blue-600 mt-1">{{ number_format($diprosesCount) }}</h3>
                    <p class="text-[11px] text-blue-600/80 mt-0.5">Dalam tahap penulisan/ttd</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fas fa-arrows-rotate"></i>
                </div>
            </div>

            <!-- Selesai / Terbit -->
            <div class="bg-white rounded-2xl p-5 border border-emerald-200 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">Selesai / Terbit</p>
                    <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ number_format($selesaiCount) }}</h3>
                    <p class="text-[11px] text-emerald-600/80 mt-0.5">Siap diambil / dicetak</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fas fa-circle-check"></i>
                </div>
            </div>

            <!-- Ditolak / Perlu Revisi -->
            <div class="bg-white rounded-2xl p-5 border border-rose-200 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-xs font-semibold text-rose-700 uppercase tracking-wider">Ditolak / Revisi</p>
                    <h3 class="text-2xl font-extrabold text-rose-600 mt-1">{{ number_format($ditolakCount) }}</h3>
                    <p class="text-[11px] text-rose-600/80 mt-0.5">Berkas tidak memenuhi syarat</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                    <i class="fas fa-ban"></i>
                </div>
            </div>
        </div>

        {{-- ─── 2. STATISTIK PER 7 JENIS TEMPLATE SURAT ─────────────────── --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-4 border-b border-slate-100 gap-2 mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-emerald-600"></i>
                        <span>Statistik Berdasarkan 7 Template Surat KKN Desa</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Rincian distribusi permohonan surat masuk berdasarkan klasifikasi resmi template</p>
                </div>
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-slate-100 text-slate-600">
                    Total: {{ $totalCount }} Permohonan
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7 gap-3">
                @foreach ($byJenis as $key => $item)
                    @php
                        $isActive = request('jenis') === $key;
                        $colorStyles = [
                            'emerald' => 'hover:border-emerald-500 bg-emerald-50/30 text-emerald-700 border-emerald-200',
                            'blue'    => 'hover:border-blue-500 bg-blue-50/30 text-blue-700 border-blue-200',
                            'amber'   => 'hover:border-amber-500 bg-amber-50/30 text-amber-700 border-amber-200',
                            'rose'    => 'hover:border-rose-500 bg-rose-50/30 text-rose-700 border-rose-200',
                            'pink'    => 'hover:border-pink-500 bg-pink-50/30 text-pink-700 border-pink-200',
                            'indigo'  => 'hover:border-indigo-500 bg-indigo-50/30 text-indigo-700 border-indigo-200',
                            'teal'    => 'hover:border-teal-500 bg-teal-50/30 text-teal-700 border-teal-200',
                        ][$item['color']] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                    @endphp
                    <a href="{{ route('surat.admin.index', array_merge(request()->query(), ['jenis' => $isActive ? 'all' : $key])) }}"
                       class="p-3.5 rounded-2xl border transition-all flex flex-col justify-between group {{ $isActive ? 'ring-2 ring-emerald-500 bg-emerald-50 shadow-sm border-emerald-400' : 'bg-slate-50/60 border-slate-200/80 hover:bg-white hover:shadow-sm' }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="w-8 h-8 rounded-xl bg-white shadow-sm flex items-center justify-center text-xs font-bold text-slate-700 border border-slate-200/60">
                                <i class="fas {{ $item['icon'] }}"></i>
                            </span>
                            <span class="text-xs font-extrabold text-slate-900 group-hover:text-emerald-600 transition-colors">
                                {{ $item['count'] }}
                            </span>
                        </div>
                        <div>
                            <div class="text-[11px] font-bold text-slate-800 leading-tight line-clamp-1" title="{{ $item['title'] }}">
                                {{ $item['short'] }}
                            </div>
                            <div class="text-[9.5px] text-slate-500 leading-tight line-clamp-1 mt-0.5">
                                {{ $item['title'] }}
                            </div>
                        </div>
                        <div class="mt-2.5">
                            <div class="w-full bg-slate-200/80 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-emerald-600 h-1.5 rounded-full transition-all duration-500" style="width: {{ $item['percentage'] }}%"></div>
                            </div>
                            <div class="flex justify-between items-center text-[9px] text-slate-400 mt-1">
                                <span>Kode: {{ $item['code'] }}</span>
                                <span class="font-semibold">{{ $item['percentage'] }}%</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- ─── 3. TABEL DATA PERMOHONAN DENGAN FILTER LENGKAP ──────────── --}}
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            
            {{-- Filter Bar --}}
            <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                <form action="{{ route('surat.admin.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
                    
                    {{-- Search Input --}}
                    <div class="lg:col-span-4 relative">
                        <i class="fas fa-search absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama, NIK, No. Registrasi, No. Surat..."
                               class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-white">
                    </div>

                    {{-- Filter Jenis Surat --}}
                    <div class="lg:col-span-3">
                        <select name="jenis" onchange="this.form.submit()" class="w-full py-2 px-3 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-white">
                            <option value="all">Semua Template Surat (7 Jenis)</option>
                            @foreach ($byJenis as $key => $item)
                                <option value="{{ $key }}" {{ request('jenis') === $key ? 'selected' : '' }}>
                                    {{ $item['short'] }} - {{ $item['title'] }} ({{ $item['count'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Status --}}
                    <div class="lg:col-span-2">
                        <select name="status" onchange="this.form.submit()" class="w-full py-2 px-3 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-white">
                            <option value="all">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu ({{ $pendingCount }})</option>
                            <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses ({{ $diprosesCount }})</option>
                            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai / Terbit ({{ $selesaiCount }})</option>
                            <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak ({{ $ditolakCount }})</option>
                        </select>
                    </div>

                    {{-- Filter RW --}}
                    <div class="lg:col-span-2">
                        <select name="rw" onchange="this.form.submit()" class="w-full py-2 px-3 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-white">
                            <option value="all">Semua RW (01 - 10)</option>
                            @for ($i = 1; $i <= 10; $i++)
                                @php $rwStr = str_pad($i, 3, '0', STR_PAD_LEFT); @endphp
                                <option value="{{ $i }}" {{ request('rw') == $i ? 'selected' : '' }}>
                                    RW {{ str_pad($i, 2, '0', STR_PAD_LEFT) }} ({{ $rwCounts[$rwStr] ?? 0 }})
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- Reset Button --}}
                    <div class="lg:col-span-1 flex gap-2">
                        <a href="{{ route('surat.admin.index') }}" class="w-full py-2 px-3 text-center text-xs font-semibold text-slate-600 bg-slate-200 hover:bg-slate-300 rounded-xl transition-all" title="Reset Filter">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    </div>
                </form>
            </div>

            {{-- Table Content --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-100/70 border-b border-slate-200/80 text-slate-600 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4">No. Registrasi & Tanggal</th>
                            <th class="py-3.5 px-4">Jenis Surat Template</th>
                            <th class="py-3.5 px-4">Pemohon & NIK</th>
                            <th class="py-3.5 px-4">Alamat & RW</th>
                            <th class="py-3.5 px-4">Nomor Surat Resmi</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-center">Cetak & Unduh</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($surats as $surat)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                {{-- Tracking Code & Tanggal --}}
                                <td class="py-3 px-4">
                                    <div class="font-mono font-bold text-slate-900">{{ $surat->tracking_code }}</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">
                                        <i class="fas fa-calendar-day mr-1"></i>{{ $surat->created_at->format('d M Y, H:i') }}
                                    </div>
                                </td>

                                {{-- Jenis Surat --}}
                                <td class="py-3 px-4">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg font-bold text-[11px] {{ $surat->jenis_info['color'] === 'emerald' ? 'bg-emerald-100 text-emerald-800' : ($surat->jenis_info['color'] === 'blue' ? 'bg-blue-100 text-blue-800' : ($surat->jenis_info['color'] === 'rose' ? 'bg-rose-100 text-rose-800' : ($surat->jenis_info['color'] === 'pink' ? 'bg-pink-100 text-pink-800' : ($surat->jenis_info['color'] === 'amber' ? 'bg-amber-100 text-amber-800' : ($surat->jenis_info['color'] === 'indigo' ? 'bg-indigo-100 text-indigo-800' : 'bg-teal-100 text-teal-800'))))) }}">
                                        <i class="fas {{ $surat->jenis_info['icon'] }} text-[10px]"></i>
                                        <span>{{ $surat->jenis_info['short'] }}</span>
                                    </div>
                                    <div class="text-[10px] text-slate-500 mt-0.5 truncate max-w-[170px]" title="{{ $surat->jenis_info['title'] }}">
                                        {{ $surat->jenis_info['title'] }}
                                    </div>
                                </td>

                                {{-- Pemohon & NIK --}}
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-800 text-[12px]">{{ $surat->nama_lengkap }}</div>
                                    <div class="text-[10.5px] text-slate-500 font-mono mt-0.5">
                                        NIK: {{ $surat->nik }}
                                    </div>
                                    @if ($surat->no_telepon)
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $surat->no_telepon)) }}?text={{ urlencode('Halo Bapak/Ibu ' . $surat->nama_lengkap . ', mengenai permohonan ' . $surat->jenis_info['title'] . ' di Kantor Desa Cigagade:') }}"
                                           target="_blank" class="inline-flex items-center gap-1 text-[10px] text-emerald-600 hover:text-emerald-700 font-medium mt-0.5">
                                            <i class="fab fa-whatsapp"></i> {{ $surat->no_telepon }}
                                        </a>
                                    @endif
                                </td>

                                {{-- Alamat & RW --}}
                                <td class="py-3 px-4">
                                    <div class="text-slate-800 font-medium truncate max-w-[150px]" title="{{ $surat->alamat }}">
                                        {{ $surat->alamat }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">
                                        RT {{ $surat->rt }} / RW {{ $surat->rw }}
                                    </div>
                                </td>

                                {{-- Nomor Surat Resmi --}}
                                <td class="py-3 px-4">
                                    <span class="font-mono text-[11px] font-semibold text-slate-700 bg-slate-100 px-2 py-1 rounded-md border border-slate-200">
                                        {{ $surat->formatted_nomor_surat }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $surat->status_badge['bg'] }}">
                                        <i class="fas {{ $surat->status_badge['icon'] }} text-[9px]"></i>
                                        <span>{{ $surat->status_badge['label'] }}</span>
                                    </span>
                                </td>

                                {{-- Cetak & Unduh (Word / PDF / Print) --}}
                                <td class="py-3 px-4 text-center">
                                    <div class="inline-flex items-center gap-1.5 bg-slate-100/70 p-1 rounded-xl border border-slate-200/60 shadow-inner">
                                        {{-- Print Preview --}}
                                        <a href="{{ route('surat.admin.print', $surat->id) }}" target="_blank"
                                           class="w-7 h-7 rounded-lg bg-white hover:bg-slate-200 text-slate-700 flex items-center justify-center shadow-xs transition-all"
                                           title="Pratinjau & Cetak Langsung (Browser)">
                                            <i class="fas fa-print text-xs"></i>
                                        </a>
                                        {{-- Unduh PDF --}}
                                        <a href="{{ route('surat.admin.pdf', $surat->id) }}"
                                           class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 flex items-center justify-center shadow-xs transition-all"
                                           title="Unduh PDF Resmi">
                                            <i class="fas fa-file-pdf text-xs"></i>
                                        </a>
                                        {{-- Unduh Word --}}
                                        <a href="{{ route('surat.admin.word', $surat->id) }}"
                                           class="w-7 h-7 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center shadow-xs transition-all"
                                           title="Unduh File Word (.docx)">
                                            <i class="fas fa-file-word text-xs"></i>
                                        </a>
                                    </div>
                                </td>

                                {{-- Aksi --}}
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('surat.admin.show', $surat->id) }}"
                                           class="px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-semibold text-[11px] transition-all flex items-center gap-1">
                                            <i class="fas fa-pen-to-square"></i>
                                            <span>Kelola</span>
                                        </a>
                                        <form action="{{ route('surat.admin.destroy', $surat->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan surat ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-7 h-7 rounded-lg hover:bg-rose-50 text-slate-400 hover:text-rose-600 transition-colors flex items-center justify-center" title="Hapus">
                                                <i class="fas fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center text-slate-400">
                                    <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl mb-3">
                                        <i class="fas fa-inbox"></i>
                                    </div>
                                    <p class="font-semibold text-sm text-slate-700">Belum Ada Permohonan Surat</p>
                                    <p class="text-xs text-slate-400 mt-1">Tidak ada data surat yang sesuai dengan filter atau kata kunci yang dipilih.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($surats->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $surats->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>
