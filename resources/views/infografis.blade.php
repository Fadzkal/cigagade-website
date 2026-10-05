<x-public-layout>
    <x-slot name="title">
        {{ $tabMeta['title'] }} — Infografis Desa Cigagade
    </x-slot>

    {{-- Chart.js CDN for interactive charts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <div class="pt-24 pb-16 bg-[#F8FAFC] dark:bg-slate-950 transition-colors duration-300 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Breadcrumb --}}
            <nav class="flex items-center text-xs font-medium text-slate-500 dark:text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors flex items-center gap-1.5">
                    <i class="fas fa-house text-[10px]"></i>
                    <span>Beranda</span>
                </a>
                <span class="mx-2 text-slate-300 dark:text-slate-700">/</span>
                <span class="text-slate-600 dark:text-slate-300">Infografis</span>
                <span class="mx-2 text-slate-300 dark:text-slate-700">/</span>
                <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ $tabMeta['badge'] }}</span>
            </nav>

            {{-- Top Header & Navigation Tabs (Mirip DigitalDesa Saribakti) --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-6 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <span class="text-xs font-extrabold uppercase tracking-widest text-emerald-600 dark:text-emerald-400">PORTAL DATA & STATISTIK</span>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight mt-1 uppercase">
                            INFOGRAFIS DESA CIGAGADE
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Kecamatan Balubur Limbangan, Kabupaten Garut, Jawa Barat</p>
                    </div>

                    {{-- 6 Tabs Selector --}}
                    <div class="overflow-x-auto pb-2 lg:pb-0">
                        <div class="flex items-center gap-1 sm:gap-2 min-w-max border-b lg:border-b-0 border-slate-100 dark:border-slate-800">
                            @foreach ($allowedTabs as $tKey => $tData)
                                @php $isActive = ($tab === $tKey); @endphp
                                <a href="{{ route('infografis.tab', $tKey) }}"
                                   class="group flex flex-col items-center justify-center px-3.5 sm:px-4 py-2.5 rounded-2xl transition-all {{ $isActive ? 'bg-emerald-50/80 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border-b-2 border-emerald-500 font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800/50' }}">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110 {{ $isActive ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-500 dark:text-slate-400' }}">
                                        <i class="{{ $tData['icon'] }} text-base"></i>
                                    </div>
                                    <span class="text-[11px] sm:text-xs tracking-tight mt-1 capitalize whitespace-nowrap">
                                        {{ $tKey === 'apbdes' ? 'APBDes' : ($tKey === 'idm' ? 'IDM' : ($tKey === 'sdgs' ? 'SDGs' : ucfirst($tKey))) }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Hero Banner per Tab --}}
                <div class="pt-8 flex flex-col lg:flex-row items-center justify-between gap-8">
                    <div class="max-w-2xl space-y-4">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 text-xs font-bold">
                            <i class="{{ $tabMeta['icon'] }}"></i>
                            <span>{{ $tabMeta['badge'] }}</span>
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-emerald-600 dark:text-emerald-400 tracking-tight leading-tight">
                            {{ $tabMeta['title'] }}
                        </h2>
                        <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed">
                            {{ $tabMeta['subtitle'] }}
                        </p>
                    </div>

                    {{-- 3D Illustration / Decorative Badge --}}
                    <div class="w-full sm:w-80 flex-shrink-0 flex items-center justify-center p-4">
                        <div class="relative w-64 h-48 rounded-3xl bg-gradient-to-tr from-emerald-500/10 via-teal-500/10 to-emerald-600/20 dark:from-emerald-900/20 dark:to-teal-900/30 border border-emerald-500/20 flex flex-col items-center justify-center p-6 text-center shadow-lg shadow-emerald-500/5">
                            <div class="w-16 h-16 rounded-2xl bg-white dark:bg-slate-800 shadow-md flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-2xl mb-3">
                                <i class="{{ $tabMeta['icon'] }}"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Sistem Informasi Data Terpadu</span>
                            <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-semibold mt-0.5">Pemerintah Desa Cigagade</span>
                            <div class="mt-2 text-[10px] text-slate-400 dark:text-slate-500">
                                Diperbarui: {{ date('F Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============================================================== --}}
            {{-- TAB 1: DEMOGRAFI PENDUDUK (Sesuai Screenshot User)           --}}
            {{-- ============================================================== --}}
            @if ($tab === 'penduduk')
                {{-- 1. Jumlah Penduduk dan Kepala Keluarga (4 Kartu) --}}
                <div class="space-y-4">
                    <h3 class="text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 tracking-tight flex items-center gap-2">
                        <span>Jumlah Penduduk dan Kepala Keluarga</span>
                    </h3>

                    @php
                        $totalPenduduk = $sections['summary']->where('key', 'total_penduduk')->first()->value ?? '1.048';
                        $totalKK = $sections['summary']->where('key', 'total_kk')->first()->value ?? '307';
                        $totalPerempuan = $sections['summary']->where('key', 'perempuan')->first()->value ?? '520';
                        $totalLaki = $sections['summary']->where('key', 'laki_laki')->first()->value ?? '528';
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        {{-- Kartu Total Penduduk --}}
                        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-4 hover:border-emerald-300 dark:hover:border-emerald-700 transition-all hover:shadow-md">
                            <div class="w-16 h-16 rounded-full bg-emerald-100/70 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center flex-shrink-0">
                                <svg class="w-9 h-9" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="24" cy="16" r="6" fill="#10B981" />
                                    <path d="M12 36C12 29.3726 17.3726 24 24 24C30.6274 24 36 29.3726 36 36" stroke="#10B981" stroke-width="4" stroke-linecap="round"/>
                                    <circle cx="36" cy="19" r="4" fill="#34D399" />
                                    <circle cx="12" cy="19" r="4" fill="#34D399" />
                                    <path d="M30 38C30.5 33 34 30 38 30" stroke="#34D399" stroke-width="3" stroke-linecap="round"/>
                                    <path d="M18 38C17.5 33 14 30 10 30" stroke="#34D399" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">TOTAL PENDUDUK</p>
                                <p class="text-2xl sm:text-3xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight mt-0.5">
                                    {{ is_numeric($totalPenduduk) ? number_format((float)$totalPenduduk, 0, ',', '.') : $totalPenduduk }}
                                    <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">Jiwa</span>
                                </p>
                            </div>
                        </div>

                        {{-- Kartu Kepala Keluarga --}}
                        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-4 hover:border-emerald-300 dark:hover:border-emerald-700 transition-all hover:shadow-md">
                            <div class="w-16 h-16 rounded-full bg-teal-100/70 dark:bg-teal-950/60 text-teal-600 dark:text-teal-400 flex items-center justify-center flex-shrink-0">
                                <svg class="w-9 h-9" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 22L24 10L38 22V36C38 37.1046 37.1046 38 36 38H12C10.8954 38 10 37.1046 10 36V22Z" stroke="#0D9488" stroke-width="3.5" stroke-linejoin="round"/>
                                    <circle cx="24" cy="24" r="4" fill="#0D9488"/>
                                    <path d="M18 36C18 32.6863 20.6863 30 24 30C27.3137 30 30 32.6863 30 36" stroke="#0D9488" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">KEPALA KELUARGA</p>
                                <p class="text-2xl sm:text-3xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight mt-0.5">
                                    {{ is_numeric($totalKK) ? number_format((float)$totalKK, 0, ',', '.') : $totalKK }}
                                    <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">Jiwa</span>
                                </p>
                            </div>
                        </div>

                        {{-- Kartu Perempuan --}}
                        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-4 hover:border-emerald-300 dark:hover:border-emerald-700 transition-all hover:shadow-md">
                            <div class="w-16 h-16 rounded-full bg-rose-100/70 dark:bg-rose-950/60 text-rose-500 dark:text-rose-400 flex items-center justify-center flex-shrink-0">
                                <svg class="w-9 h-9" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="24" cy="18" r="8" fill="#F43F5E"/>
                                    <path d="M14 38C14 32.4772 18.4772 28 24 28C29.5228 28 34 32.4772 34 38" stroke="#F43F5E" stroke-width="3.5" stroke-linecap="round"/>
                                    <path d="M24 10C20 10 16 14 16 18C16 23 20 25 24 25C28 25 32 23 32 18C32 14 28 10 24 10Z" stroke="#FDA4AF" stroke-width="2"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">PEREMPUAN</p>
                                <p class="text-2xl sm:text-3xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight mt-0.5">
                                    {{ is_numeric($totalPerempuan) ? number_format((float)$totalPerempuan, 0, ',', '.') : $totalPerempuan }}
                                    <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">Jiwa</span>
                                </p>
                            </div>
                        </div>

                        {{-- Kartu Laki-Laki --}}
                        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-4 hover:border-emerald-300 dark:hover:border-emerald-700 transition-all hover:shadow-md">
                            <div class="w-16 h-16 rounded-full bg-blue-100/70 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                                <svg class="w-9 h-9" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="24" cy="18" r="8" fill="#3B82F6"/>
                                    <path d="M14 38C14 32.4772 18.4772 28 24 28C29.5228 28 34 32.4772 34 38" stroke="#3B82F6" stroke-width="3.5" stroke-linecap="round"/>
                                    <path d="M20 12L24 15L28 12" stroke="#93C5FD" stroke-width="2.5" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">LAKI-LAKI</p>
                                <p class="text-2xl sm:text-3xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight mt-0.5">
                                    {{ is_numeric($totalLaki) ? number_format((float)$totalLaki, 0, ',', '.') : $totalLaki }}
                                    <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">Jiwa</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Piramida Penduduk Berdasarkan Kelompok Umur (Chart.js) --}}
                <div class="space-y-4 pt-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <h3 class="text-xl sm:text-2xl font-bold text-emerald-600 dark:text-emerald-400 tracking-tight">
                            Berdasarkan Kelompok Umur
                        </h3>
                        <div class="flex items-center gap-6 text-xs font-bold">
                            <div class="flex items-center gap-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-[#5ea897]"></span>
                                <span class="text-slate-700 dark:text-slate-300">Laki-Laki</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-[#fca58e]"></span>
                                <span class="text-slate-700 dark:text-slate-300">Perempuan</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-4 sm:p-8 border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors">
                        <div class="relative w-full h-[620px] sm:h-[680px]">
                            <canvas id="piramidaUmurChart"></canvas>
                        </div>
                        <p class="text-center text-[11px] text-slate-400 dark:text-slate-500 mt-4 italic">
                            *Grafik piramida umur menunjukkan perbandingan jumlah penduduk Laki-Laki (kiri) dan Perempuan (kanan) di Desa Cigagade.
                        </p>
                    </div>
                </div>

                {{-- 3. Demografi Tambahan: Pendidikan, Pekerjaan, Dusun --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-4">
                    {{-- Pendidikan --}}
                    @if (isset($sections['pendidikan']))
                        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-5">
                            <h4 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 flex items-center justify-center text-sm">
                                    <i class="fas fa-graduation-cap"></i>
                                </span>
                                Berdasarkan Tingkat Pendidikan
                            </h4>
                            <div class="space-y-3.5">
                                @php
                                    $maxEdu = max(1, (int)$sections['pendidikan']->max('value'));
                                @endphp
                                @foreach ($sections['pendidikan'] as $edu)
                                    @php
                                        $val = (int)$edu->value;
                                        $pct = round(($val / $maxEdu) * 100);
                                    @endphp
                                    <div class="space-y-1">
                                        <div class="flex justify-between text-xs font-semibold text-slate-700 dark:text-slate-300">
                                            <span>{{ $edu->title }}</span>
                                            <span class="text-emerald-600 dark:text-emerald-400 font-bold">{{ number_format($val, 0, ',', '.') }} Jiwa</span>
                                        </div>
                                        <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2.5 overflow-hidden">
                                            <div class="bg-emerald-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Pekerjaan --}}
                    @if (isset($sections['pekerjaan']))
                        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-5">
                            <h4 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-xl bg-teal-100 dark:bg-teal-950 text-teal-600 flex items-center justify-center text-sm">
                                    <i class="fas fa-briefcase"></i>
                                </span>
                                Berdasarkan Mata Pencaharian
                            </h4>
                            <div class="space-y-3.5">
                                @php
                                    $maxJob = max(1, (int)$sections['pekerjaan']->max('value'));
                                @endphp
                                @foreach ($sections['pekerjaan'] as $job)
                                    @php
                                        $val = (int)$job->value;
                                        $pct = round(($val / $maxJob) * 100);
                                    @endphp
                                    <div class="space-y-1">
                                        <div class="flex justify-between text-xs font-semibold text-slate-700 dark:text-slate-300">
                                            <span>{{ $job->title }}</span>
                                            <span class="text-teal-600 dark:text-teal-400 font-bold">{{ number_format($val, 0, ',', '.') }} Jiwa</span>
                                        </div>
                                        <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2.5 overflow-hidden">
                                            <div class="bg-teal-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Dusun & Kewilayahan --}}
                @if (isset($sections['dusun']))
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-6">
                        <h4 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-950 text-blue-600 flex items-center justify-center text-sm">
                                <i class="fas fa-map-location-dot"></i>
                            </span>
                            Sebaran Penduduk per Wilayah Dusun
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @foreach ($sections['dusun'] as $ds)
                                <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60 space-y-2">
                                    <p class="text-xs font-bold text-slate-700 dark:text-slate-200">{{ $ds->title }}</p>
                                    <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400">
                                        {{ number_format((float)$ds->value, 0, ',', '.') }} <span class="text-xs font-semibold text-slate-500">Jiwa</span>
                                    </p>
                                    @if ($ds->value_alt)
                                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $ds->value_alt }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            {{-- ============================================================== --}}
            {{-- TAB 2: APBDES (KEUANGAN DESA)                                --}}
            {{-- ============================================================== --}}
            @if ($tab === 'apbdes')
                <div class="space-y-8">
                    {{-- Summary 4 Kartu APBDes --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        @foreach ($sections['summary'] as $card)
                            <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-4 hover:shadow-md transition">
                                <div class="w-14 h-14 rounded-2xl bg-emerald-100/70 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl flex-shrink-0">
                                    <i class="{{ $card->icon ?? 'fas fa-coins' }}"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 truncate">{{ $card->title }}</p>
                                    <p class="text-xl sm:text-2xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight mt-0.5 truncate">
                                        {{ is_numeric($card->value) ? 'Rp ' . number_format((float)$card->value, 0, ',', '.') : $card->value }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Rincian Alokasi Belanja Desa --}}
                    @if (isset($sections['rincian']))
                        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-6">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100 dark:border-slate-800">
                                <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                                    <i class="fas fa-file-invoice-dollar text-emerald-600"></i>
                                    Alokasi Realisasi Belanja Desa per Bidang
                                </h3>
                                <span class="text-xs text-slate-500 font-medium">Tahun Anggaran Berjalan</span>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                                <div class="space-y-4">
                                    @foreach ($sections['rincian'] as $b)
                                        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60 flex items-center justify-between gap-4">
                                            <div class="space-y-1">
                                                <p class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $b->title }}</p>
                                                <p class="text-base font-black text-emerald-600 dark:text-emerald-400">
                                                    Rp {{ number_format((float)$b->value, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            @if ($b->value_alt)
                                                <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 font-extrabold text-xs rounded-xl">
                                                    {{ $b->value_alt }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <div class="relative w-full h-[320px] flex items-center justify-center">
                                    <canvas id="apbdesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            {{-- ============================================================== --}}
            {{-- TAB 3: STUNTING & KESEHATAN                                  --}}
            {{-- ============================================================== --}}
            @if ($tab === 'stunting')
                <div class="space-y-8">
                    {{-- Summary Stunting --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        @foreach ($sections['summary'] as $card)
                            <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center gap-4 hover:shadow-md transition">
                                <div class="w-14 h-14 rounded-2xl bg-emerald-100/70 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl flex-shrink-0">
                                    <i class="{{ $card->icon ?? 'fas fa-heart-pulse' }}"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ $card->title }}</p>
                                    <p class="text-2xl sm:text-3xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight mt-0.5">
                                        {{ $card->value }} <span class="text-xs font-semibold text-slate-500">{{ $card->unit }}</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Data per Posyandu --}}
                    @if (isset($sections['rincian']))
                        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-6">
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                                <i class="fas fa-stethoscope text-emerald-600"></i>
                                Pemantauan Gizi Balita per Posyandu
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                @foreach ($sections['rincian'] as $pos)
                                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60 space-y-2">
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-100">{{ $pos->title }}</p>
                                        <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400">
                                            {{ $pos->value }} <span class="text-xs font-semibold text-slate-500">Balita</span>
                                        </p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $pos->value_alt }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            {{-- ============================================================== --}}
            {{-- TAB 4: BANTUAN SOSIAL (BANSOS)                               --}}
            {{-- ============================================================== --}}
            @if ($tab === 'bansos')
                <div class="space-y-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($sections['summary'] as $card)
                            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-3 hover:shadow-md transition">
                                <div class="w-12 h-12 rounded-xl bg-emerald-100/70 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg">
                                    <i class="{{ $card->icon ?? 'fas fa-box-open' }}"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">{{ $card->title }}</p>
                                    <p class="text-3xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight mt-1">
                                        {{ $card->value }} <span class="text-sm font-semibold text-slate-500">{{ $card->unit }}</span>
                                    </p>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 pt-2 border-t border-slate-100 dark:border-slate-800">
                                    Penerima Manfaat Terverifikasi DTKS / Desa Cigagade
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- ============================================================== --}}
            {{-- TAB 5: IDM (INDEKS DESA MEMBANGUN)                           --}}
            {{-- ============================================================== --}}
            @if ($tab === 'idm')
                <div class="space-y-8">
                    @php
                        $skorIDM = $sections['summary']->where('key', 'skor_idm')->first()->value ?? '0.7682';
                        $statusIDM = $sections['summary']->where('key', 'status_idm')->first()->value ?? 'DESA MAJU';
                        $iks = $sections['summary']->where('key', 'iks')->first()->value ?? '0.8120';
                        $ike = $sections['summary']->where('key', 'ike')->first()->value ?? '0.7150';
                        $ikl = $sections['summary']->where('key', 'ikl')->first()->value ?? '0.7775';
                    @endphp

                    {{-- Highlight Status IDM --}}
                    <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl p-6 sm:p-10 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="space-y-2 text-center md:text-left">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold tracking-wider uppercase">
                                STATUS INDEKS DESA MEMBANGUN
                            </span>
                            <h3 class="text-3xl sm:text-5xl font-black tracking-tight mt-1">{{ $statusIDM }}</h3>
                            <p class="text-emerald-100 text-sm max-w-xl">
                                Desa Cigagade telah mencapai status kemajuan tinggi dengan ketahanan sosial, ekonomi, dan lingkungan yang kuat menuju Desa Mandiri.
                            </p>
                        </div>
                        <div class="text-center bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 min-w-[200px]">
                            <p class="text-xs font-bold uppercase tracking-wider text-emerald-100">SKOR KOMPOSIT IDM</p>
                            <p class="text-4xl sm:text-5xl font-black mt-1">{{ $skorIDM }}</p>
                        </div>
                    </div>

                    {{-- 3 Dimensi Ketahanan IDM --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
                            <div class="w-12 h-12 rounded-xl bg-teal-100 dark:bg-teal-950 text-teal-600 flex items-center justify-center text-lg">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 dark:text-white text-base">Ketahanan Sosial (IKS)</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Pendidikan, kesehatan, modal sosial, dan pemukiman.</p>
                            </div>
                            <div class="space-y-1 pt-2">
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-slate-500">Nilai Indeks</span>
                                    <span class="text-teal-600 font-black text-lg">{{ $iks }}</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-3 overflow-hidden">
                                    <div class="bg-teal-500 h-3 rounded-full" style="width: {{ ((float)$iks) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-950 text-indigo-600 flex items-center justify-center text-lg">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 dark:text-white text-base">Ketahanan Ekonomi (IKE)</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Keragaman produksi, perdagangan, akses pasar, dan perbankan.</p>
                            </div>
                            <div class="space-y-1 pt-2">
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-slate-500">Nilai Indeks</span>
                                    <span class="text-indigo-600 font-black text-lg">{{ $ike }}</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-3 overflow-hidden">
                                    <div class="bg-indigo-500 h-3 rounded-full" style="width: {{ ((float)$ike) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 flex items-center justify-center text-lg">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 dark:text-white text-base">Ketahanan Lingkungan (IKL)</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Kualitas lingkungan hidup, sanitasi, dan tanggap bencana.</p>
                            </div>
                            <div class="space-y-1 pt-2">
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-slate-500">Nilai Indeks</span>
                                    <span class="text-emerald-600 font-black text-lg">{{ $ikl }}</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-3 overflow-hidden">
                                    <div class="bg-emerald-500 h-3 rounded-full" style="width: {{ ((float)$ikl) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ============================================================== --}}
            {{-- TAB 6: SDGs DESA (18 INDIKATOR LENGKAP)                      --}}
            {{-- ============================================================== --}}
            @if ($tab === 'sdgs')
                <div class="space-y-8">
                    @php
                        $skorSDGs = $sections['summary']->where('key', 'skor_sdgs_total')->first()->value ?? '66.85';
                    @endphp

                    {{-- Banner Skor SDGs Desa --}}
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="space-y-2">
                            <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-xs font-bold uppercase tracking-wider">
                                CAPAIAN PEMBANGUNAN BERKELANJUTAN
                            </span>
                            <h3 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-white tracking-tight">
                                Skor SDGs Desa Cigagade
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 max-w-xl">
                                SDGs Desa merupakan lokalisasi 18 tujuan pembangunan berkelanjutan dari Kementerian Desa PDTT untuk mewujudkan kesejahteraan menyeluruh bagi seluruh warga Cigagade.
                            </p>
                        </div>
                        <div class="text-center bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200/80 dark:border-emerald-800/80 p-6 rounded-2xl min-w-[200px]">
                            <p class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">RATA-RATA SKOR</p>
                            <p class="text-4xl sm:text-5xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ $skorSDGs }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">dari skala 100</p>
                        </div>
                    </div>

                    {{-- 18 Kartu Indikator SDGs Desa --}}
                    @if (isset($sections['tujuan']))
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                            @foreach ($sections['tujuan'] as $goal)
                                @php
                                    $score = (float)$goal->value;
                                @endphp
                                <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-3 hover:border-emerald-400 dark:hover:border-emerald-600 transition-all hover:shadow-md">
                                    <div class="flex items-start justify-between gap-2">
                                        <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100 leading-snug">
                                            {{ $goal->title }}
                                        </h4>
                                        <span class="px-2 py-0.5 bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 font-extrabold text-xs rounded-lg flex-shrink-0">
                                            {{ $score }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-emerald-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $score }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>

    {{-- CHART SCRIPTS --}}
    @if ($tab === 'penduduk' && isset($chartData['piramida_labels']))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const labels = @json(array_reverse($chartData['piramida_labels']));
                const maleDataRaw = @json(array_reverse($chartData['piramida_laki']));
                const femaleData = @json(array_reverse($chartData['piramida_perempuan']));
                
                // Chart.js population pyramid: mirror male data using negative values for the left axis
                const maleDataNegative = maleDataRaw.map(v => -Math.abs(v));

                const ctx = document.getElementById('piramidaUmurChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Laki-Laki',
                                data: maleDataNegative,
                                backgroundColor: '#5ea897',
                                hoverBackgroundColor: '#498879',
                                borderRadius: 4,
                                barPercentage: 0.85,
                            },
                            {
                                label: 'Perempuan',
                                data: femaleData,
                                backgroundColor: '#fca58e',
                                hoverBackgroundColor: '#f88c70',
                                borderRadius: 4,
                                barPercentage: 0.85,
                            }
                        ]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const val = Math.abs(context.parsed.x);
                                        return context.dataset.label + ': ' + val + ' Jiwa';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: false,
                                grid: {
                                    color: 'rgba(226, 232, 240, 0.6)'
                                },
                                ticks: {
                                    callback: function(val) {
                                        return Math.abs(val);
                                    },
                                    font: {
                                        size: 11,
                                        weight: '600'
                                    }
                                }
                            },
                            y: {
                                stacked: false,
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11,
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif

    @if ($tab === 'apbdes' && isset($chartData['belanja_labels']))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const labels = @json($chartData['belanja_labels']);
                const values = @json($chartData['belanja_values']);

                const ctx = document.getElementById('apbdesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: [
                                '#10B981', '#3B82F6', '#F59E0B', '#EC4899', '#8B5CF6'
                            ],
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    font: { size: 10 }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': Rp ' + context.parsed.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            });
        </script>
    @endif

</x-public-layout>
