<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center">
                        <i class="fas fa-chart-pie"></i>
                    </span>
                    Kelola Infografis & Data Statistik Desa
                </h2>
                <p class="text-xs text-slate-500 mt-1">Perbarui statistik demografi penduduk, anggaran APBDes, stunting, bantuan sosial, IDM, dan SDGs Desa Cigagade.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('infografis.tab', $currentTab) }}" target="_blank"
                   class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium text-xs rounded-xl shadow-sm transition">
                    <i class="fas fa-arrow-up-right-from-square text-emerald-600"></i>
                    Lihat di Website
                </a>
                <form action="{{ route('infografis.admin.reset') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset seluruh data infografis ke data standar Cigagade?');">
                    @csrf
                    <input type="hidden" name="tab" value="{{ $currentTab }}">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-3 py-2 bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 border border-slate-200 rounded-xl text-xs font-medium transition"
                            title="Reset data ke nilai default">
                        <i class="fas fa-rotate-left"></i>
                        Reset Default
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ openAddModal: false, editModalOpen: false, editItem: {} }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 shadow-sm">
                    <i class="fas fa-circle-check text-emerald-600 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl space-y-1 shadow-sm">
                    <div class="flex items-center gap-2 font-bold text-sm">
                        <i class="fas fa-triangle-exclamation text-rose-600"></i>
                        Terjadi kesalahan validasi:
                    </div>
                    <ul class="list-disc list-inside text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Tab Navigasi 6 Kategori (Mirip Saribakti) --}}
            <div class="bg-white rounded-2xl p-2 border border-slate-200/80 shadow-sm overflow-x-auto">
                <nav class="flex space-x-2 min-w-max">
                    @php
                        $tabs = [
                            'penduduk' => ['label' => 'Demografi Penduduk', 'icon' => 'fas fa-users'],
                            'apbdes'   => ['label' => 'APBDes (Keuangan)', 'icon' => 'fas fa-hand-holding-dollar'],
                            'stunting' => ['label' => 'Stunting & Posyandu', 'icon' => 'fas fa-heart-pulse'],
                            'bansos'   => ['label' => 'Bantuan Sosial (Bansos)', 'icon' => 'fas fa-box-open'],
                            'idm'      => ['label' => 'IDM (Desa Membangun)', 'icon' => 'fas fa-crown'],
                            'sdgs'     => ['label' => 'SDGs Desa (18 Tujuan)', 'icon' => 'fas fa-list-ol'],
                        ];
                    @endphp

                    @foreach ($tabs as $tKey => $tData)
                        <a href="{{ route('infografis.admin.index', ['tab' => $tKey]) }}"
                           class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-medium transition-all {{ $currentTab === $tKey ? 'bg-emerald-600 text-white shadow-sm font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                            <i class="{{ $tData['icon'] }} text-xs"></i>
                            <span>{{ $tData['label'] }}</span>
                            <span class="ml-1 px-1.5 py-0.5 text-[10px] rounded-full {{ $currentTab === $tKey ? 'bg-emerald-700 text-white' : 'bg-slate-100 text-slate-500' }}">
                                {{ $tabCounts[$tKey] ?? 0 }}
                            </span>
                        </a>
                    @endforeach
                </nav>
            </div>

            {{-- Form Simpan Cepat / Bulk Update untuk Tab Aktif --}}
            <form action="{{ route('infografis.admin.bulk') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="tab" value="{{ $currentTab }}">

                {{-- 1. KARTU STATISTIK RINGKASAN (SUMMARY CARDS) --}}
                @if (isset($sections['summary']) && $sections['summary']->isNotEmpty())
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div>
                                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                                    <i class="fas fa-table-cells-large text-emerald-600"></i>
                                    Indikator Utama (Kartu Ringkasan)
                                </h3>
                                <p class="text-xs text-slate-500">Nilai utama yang ditampilkan pada kartu metrik teratas halaman publik.</p>
                            </div>
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-lg">
                                {{ $sections['summary']->count() }} Kartu Terpasang
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach ($sections['summary'] as $card)
                                <div class="bg-slate-50/70 p-4 rounded-xl border border-slate-200/60 space-y-2 hover:border-emerald-300 transition-colors">
                                    <div class="flex items-center justify-between">
                                        <label class="text-[11px] font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                                            @if($card->icon)
                                                <i class="{{ $card->icon }} text-emerald-600"></i>
                                            @endif
                                            {{ $card->title }}
                                        </label>
                                        <input type="text" name="titles[{{ $card->id }}]" value="{{ $card->title }}" class="hidden">
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="text" name="values[{{ $card->id }}]" value="{{ $card->value }}"
                                               class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-slate-800 font-bold text-base focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                                        <input type="text" name="units[{{ $card->id }}]" value="{{ $card->unit }}"
                                               placeholder="Satuan"
                                               class="w-20 px-2 py-2 bg-white border border-slate-200 rounded-lg text-slate-600 text-xs text-center focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- 2. KHUSUS PENDUDUK: PIRAMIDA PENDUDUK (LAKI-LAKI VS PEREMPUAN) --}}
                @if ($currentTab === 'penduduk' && isset($sections['piramida']))
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2">
                            <div>
                                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                                    <i class="fas fa-chart-simple text-emerald-600"></i>
                                    Piramida Penduduk Berdasarkan Kelompok Umur
                                </h3>
                                <p class="text-xs text-slate-500">Data jumlah warga laki-laki dan perempuan per rentang usia (0-4 hingga 85+).</p>
                            </div>
                            <span class="text-xs text-slate-500 bg-slate-100 px-3 py-1 rounded-lg">
                                Grafik otomatis diperbarui di halaman publik
                            </span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-slate-600">
                                <thead class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                    <tr>
                                        <th class="py-3 px-4 w-32">Kelompok Umur</th>
                                        <th class="py-3 px-4">Laki-Laki (Jiwa)</th>
                                        <th class="py-3 px-4">Perempuan (Jiwa)</th>
                                        <th class="py-3 px-4 text-center w-28">Total Kelompok</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($sections['piramida'] as $p)
                                        <tr class="hover:bg-slate-50/50">
                                            <td class="py-2.5 px-4 font-bold text-slate-800">
                                                {{ $p->title }} Tahun
                                                <input type="hidden" name="titles[{{ $p->id }}]" value="{{ $p->title }}">
                                            </td>
                                            <td class="py-2.5 px-4">
                                                <div class="relative w-40">
                                                    <input type="number" name="values[{{ $p->id }}]" value="{{ $p->value }}" min="0"
                                                           class="w-full py-1.5 px-3 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-800 focus:border-teal-500 focus:ring-1 focus:ring-teal-500">
                                                </div>
                                            </td>
                                            <td class="py-2.5 px-4">
                                                <div class="relative w-40">
                                                    <input type="number" name="values_alt[{{ $p->id }}]" value="{{ $p->value_alt }}" min="0"
                                                           class="w-full py-1.5 px-3 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-800 focus:border-rose-400 focus:ring-1 focus:ring-rose-400">
                                                </div>
                                            </td>
                                            <td class="py-2.5 px-4 text-center font-bold text-slate-700">
                                                {{ ((int)$p->value) + ((int)$p->value_alt) }} Jiwa
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                {{-- 3. KHUSUS APBDES: RINCIAN BELANJA PER BIDANG --}}
                @if ($currentTab === 'apbdes' && isset($sections['rincian']))
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div>
                                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                                    <i class="fas fa-file-invoice-dollar text-emerald-600"></i>
                                    Alokasi Belanja Desa per Bidang
                                </h3>
                                <p class="text-xs text-slate-500">Perincian realisasi anggaran belanja desa berdasarkan bidang prioritas.</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @foreach ($sections['rincian'] as $b)
                                <div class="p-4 bg-slate-50/70 border border-slate-200/70 rounded-xl flex flex-col md:flex-row md:items-center justify-between gap-3">
                                    <div class="flex-1">
                                        <input type="text" name="titles[{{ $b->id }}]" value="{{ $b->title }}"
                                               class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:border-emerald-500">
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-48">
                                            <input type="text" name="values[{{ $b->id }}]" value="{{ $b->value }}"
                                                   placeholder="Nominal (Rp)"
                                                   class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-800 focus:border-emerald-500">
                                        </div>
                                        <div class="w-28">
                                            <input type="text" name="values_alt[{{ $b->id }}]" value="{{ $b->value_alt }}"
                                                   placeholder="Persentase (%)"
                                                   class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-600 text-center focus:border-emerald-500">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- 4. KHUSUS STUNTING: POSYANDU & BALITA --}}
                @if ($currentTab === 'stunting' && isset($sections['rincian']))
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div>
                                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                                    <i class="fas fa-stethoscope text-emerald-600"></i>
                                    Data Balita & Penanganan per Posyandu
                                </h3>
                                <p class="text-xs text-slate-500">Pemantauan gizi dan pemberian PMT di posyandu Desa Cigagade.</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @foreach ($sections['rincian'] as $pos)
                                <div class="p-4 bg-slate-50/70 border border-slate-200/70 rounded-xl flex flex-col md:flex-row md:items-center justify-between gap-3">
                                    <div class="flex-1">
                                        <input type="text" name="titles[{{ $pos->id }}]" value="{{ $pos->title }}"
                                               class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-sm font-semibold text-slate-800 focus:border-emerald-500">
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-32">
                                            <input type="number" name="values[{{ $pos->id }}]" value="{{ $pos->value }}"
                                                   placeholder="Balita"
                                                   class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-800 focus:border-emerald-500">
                                        </div>
                                        <div class="w-64">
                                            <input type="text" name="values_alt[{{ $pos->id }}]" value="{{ $pos->value_alt }}"
                                                   placeholder="Keterangan PMT"
                                                   class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-600 focus:border-emerald-500">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- 5. KHUSUS SDGs: 18 TUJUAN SDGs DESA --}}
                @if ($currentTab === 'sdgs' && isset($sections['tujuan']))
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div>
                                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                                    <i class="fas fa-list-check text-emerald-600"></i>
                                    Skor 18 Indikator SDGs Desa Cigagade
                                </h3>
                                <p class="text-xs text-slate-500">Rentang skor capaian 0 s.d. 100 untuk masing-masing tujuan pembangunan desa.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($sections['tujuan'] as $goal)
                                <div class="p-3.5 bg-slate-50/70 border border-slate-200/70 rounded-xl space-y-2">
                                    <div class="text-xs font-bold text-slate-800 truncate" title="{{ $goal->title }}">
                                        {{ $goal->title }}
                                        <input type="hidden" name="titles[{{ $goal->id }}]" value="{{ $goal->title }}">
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <input type="number" step="0.1" min="0" max="100" name="values[{{ $goal->id }}]" value="{{ $goal->value }}"
                                               class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold text-emerald-700 focus:border-emerald-500">
                                        <span class="text-xs font-semibold text-slate-400">/ 100</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- 6. DEMOGRAFI TAMBAHAN (PENDIDIKAN, PEKERJAAN, DUSUN) --}}
                @if ($currentTab === 'penduduk')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Pendidikan --}}
                        @if (isset($sections['pendidikan']))
                            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-3">
                                <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2 pb-2 border-b border-slate-100">
                                    <i class="fas fa-graduation-cap text-emerald-600"></i>
                                    Tingkat Pendidikan Penduduk
                                </h3>
                                <div class="space-y-2">
                                    @foreach ($sections['pendidikan'] as $edu)
                                        <div class="flex items-center justify-between gap-3 text-xs">
                                            <input type="text" name="titles[{{ $edu->id }}]" value="{{ $edu->title }}"
                                                   class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-700">
                                            <div class="flex items-center gap-1 w-32">
                                                <input type="number" name="values[{{ $edu->id }}]" value="{{ $edu->value }}"
                                                       class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-800">
                                                <span class="text-slate-400">Jiwa</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Pekerjaan --}}
                        @if (isset($sections['pekerjaan']))
                            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm space-y-3">
                                <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2 pb-2 border-b border-slate-100">
                                    <i class="fas fa-briefcase text-emerald-600"></i>
                                    Mata Pencaharian & Pekerjaan
                                </h3>
                                <div class="space-y-2">
                                    @foreach ($sections['pekerjaan'] as $job)
                                        <div class="flex items-center justify-between gap-3 text-xs">
                                            <input type="text" name="titles[{{ $job->id }}]" value="{{ $job->title }}"
                                                   class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs text-slate-700">
                                            <div class="flex items-center gap-1 w-32">
                                                <input type="number" name="values[{{ $job->id }}]" value="{{ $job->value }}"
                                                       class="w-full px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-800">
                                                <span class="text-slate-400">Jiwa</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Action Bar Bawah (Tombol Simpan Perubahan) --}}
                <div class="sticky bottom-4 z-20 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-slate-200/80 shadow-xl flex items-center justify-between gap-4">
                    <div class="text-xs text-slate-500">
                        Pastikan data yang Anda ubah sudah sesuai dengan sensus & data resmi Pemerintah Desa Cigagade.
                    </div>
                    <button type="submit"
                            class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-500/20 transition-all flex items-center gap-2">
                        <i class="fas fa-floppy-disk"></i>
                        Simpan Perubahan {{ strtoupper($currentTab) }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
