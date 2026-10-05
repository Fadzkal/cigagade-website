<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight">
                    {{ __('Kelola Teks Berjalan (Running Text)') }}
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Teks berjalan (*breaking news ticker*) yang tampil tepat di bawah banner utama (*hero slider*) pada halaman beranda.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('hero-slides.index') }}" class="inline-flex items-center px-3.5 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-semibold rounded-xl transition">
                    <i class="fas fa-layer-group mr-1.5 text-slate-500"></i>
                    <span>Banner Utama</span>
                </a>
                <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                    <i class="fas fa-external-link-alt mr-1.5"></i>
                    <span>Lihat di Beranda</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 rounded-2xl flex items-center justify-between text-sm shadow-sm">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-circle-check text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- LIVE PREVIEW WIDGET --}}
            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 flex items-center gap-2">
                        <i class="fas fa-eye text-emerald-600"></i>
                        <span>Live Preview Running Text (Tampilan Publik)</span>
                    </span>
                    <span class="text-[11px] text-slate-400">Posisi: Tepat di bawah banner utama</span>
                </div>

                {{-- The exact ticker component --}}
                <div class="relative overflow-hidden rounded-xl shadow-inner flex items-stretch h-12"
                     style="background-color: #121214 !important; color: #f1f5f9 !important; border-top: 2px solid #dc2626 !important; border-bottom: 1px solid #1e293b !important;">
                    {{-- Badge INFO --}}
                    <div class="relative z-20 flex items-center gap-2 px-4 sm:px-6 font-extrabold text-xs tracking-wider uppercase shrink-0 shadow-md"
                         style="background-color: #dc2626 !important; color: #ffffff !important; clip-path: polygon(0 0, 100% 0, 85% 100%, 0 100%); padding-right: 1.75rem;">
                        <i class="fas fa-bullhorn text-xs" style="color: #ffffff !important;"></i>
                        <span style="color: #ffffff !important;">INFO</span>
                    </div>

                    {{-- Marquee Track --}}
                    <div class="flex-grow overflow-hidden flex items-center pl-2">
                        <div class="inline-flex items-center whitespace-nowrap animate-marquee text-xs sm:text-sm font-medium"
                             style="color: #e2e8f0 !important;">
                            @forelse($runningTexts->where('is_active', true) as $item)
                                <span class="inline-flex items-center">
                                    @if($item->url)
                                        <a href="{{ $item->url }}" class="text-amber-300 hover:underline inline-flex items-center gap-1 font-semibold">
                                            <span>{{ $item->text }}</span>
                                            <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
                                        </a>
                                    @else
                                        <span>{{ $item->text }}</span>
                                    @endif
                                    <span class="text-red-500 font-bold mx-4">•</span>
                                </span>
                            @empty
                                <span class="text-slate-400 italic">Belum ada teks berjalan yang aktif. Tambahkan di formulir bawah ini.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- GRID FORM TAMBAH & DAFTAR TEKS --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                {{-- FORM TAMBAH TEKS BERJALAN (4 Cols) --}}
                <div class="lg:col-span-4">
                    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm sticky top-6">
                        <div class="flex items-center gap-2 border-b border-slate-100 dark:border-slate-700 pb-3 mb-5">
                            <span class="w-2.5 h-5 bg-emerald-600 rounded-sm"></span>
                            <h3 class="font-bold text-base text-slate-900 dark:text-white">
                                + Tambah Teks Berjalan
                            </h3>
                        </div>

                        <form action="{{ route('running-texts.store') }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label for="text" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                    Isi Pesan / Pengumuman <span class="text-red-500">*</span>
                                </label>
                                <textarea name="text" id="text" rows="3" required
                                          placeholder="Contoh: Selamat Datang di Website Resmi Pemerintah Desa Cigagade..."
                                          class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">{{ old('text') }}</textarea>
                                @error('text')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                    Tautan / Link URL (Opsional)
                                </label>
                                <input type="text" name="url" id="url" value="{{ old('url') }}"
                                       placeholder="Contoh: /infografis atau https://..."
                                       class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                <p class="text-[11px] text-slate-400 mt-1">Jika diisi, teks pengumuman bisa diklik oleh warga.</p>
                                @error('url')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="badge" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                        Badge Label
                                    </label>
                                    <input type="text" name="badge" id="badge" value="{{ old('badge', 'INFO') }}"
                                           placeholder="INFO"
                                           class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                </div>
                                <div>
                                    <label for="order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                        Urutan
                                    </label>
                                    <input type="number" name="order" id="order" value="{{ old('order', $runningTexts->count() + 1) }}"
                                           class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                                </div>
                            </div>

                            <div class="pt-2">
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                    <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">Langsung Aktifkan Teks</span>
                                </label>
                            </div>

                            <button type="submit" class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-sm transition">
                                Simpan Teks Berjalan
                            </button>
                        </form>
                    </div>
                </div>

                {{-- DAFTAR ITEM RUNNING TEXT (8 Cols) --}}
                <div class="lg:col-span-8">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                        <div class="p-5 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-5 bg-amber-500 rounded-sm"></span>
                                <h3 class="font-bold text-base text-slate-900 dark:text-white">
                                    Daftar Teks Berjalan Aktif &amp; Arsip
                                </h3>
                            </div>
                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                Total: {{ $runningTexts->count() }} Item
                            </span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50 dark:bg-slate-900/60 text-slate-600 dark:text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100 dark:border-slate-700">
                                    <tr>
                                        <th class="py-3 px-4 w-12 text-center">No</th>
                                        <th class="py-3 px-4">Teks Berjalan</th>
                                        <th class="py-3 px-4 w-28">Tautan</th>
                                        <th class="py-3 px-4 w-24 text-center">Status</th>
                                        <th class="py-3 px-4 w-28 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                                    @forelse($runningTexts as $index => $rt)
                                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/30 transition-colors">
                                            <td class="py-3.5 px-4 text-center font-bold text-slate-500">
                                                {{ $rt->order ?? ($index + 1) }}
                                            </td>
                                            <td class="py-3.5 px-4">
                                                <div class="font-medium text-slate-900 dark:text-white text-xs leading-relaxed max-w-md">
                                                    {{ $rt->text }}
                                                </div>
                                                <span class="inline-block mt-1 text-[10px] text-slate-400">
                                                    Badge: <strong class="text-red-600 dark:text-red-400">{{ $rt->badge ?? 'INFO' }}</strong>
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-4 text-slate-500">
                                                @if($rt->url)
                                                    <a href="{{ $rt->url }}" target="_blank" class="text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-1 font-semibold truncate max-w-[120px]" title="{{ $rt->url }}">
                                                        <span>Link</span>
                                                        <i class="fas fa-external-link-alt text-[9px]"></i>
                                                    </a>
                                                @else
                                                    <span class="text-slate-300 dark:text-slate-600">-</span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 px-4 text-center">
                                                <form action="{{ route('running-texts.toggle', $rt->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider transition-all {{ $rt->is_active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300 hover:bg-slate-200' }}" title="Klik untuk mengubah status">
                                                        {{ $rt->is_active ? 'Aktif' : 'Nonaktif' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="py-3.5 px-4 text-center">
                                                <div class="flex items-center justify-center gap-1.5">
                                                    <a href="{{ route('running-texts.edit', $rt->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-slate-700 rounded-lg transition" title="Edit Teks">
                                                        <i class="fas fa-pen-to-square"></i>
                                                    </a>
                                                    <form action="{{ route('running-texts.destroy', $rt->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus teks berjalan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-slate-700 rounded-lg transition" title="Hapus Teks">
                                                            <i class="fas fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-slate-400 italic">
                                                Belum ada data teks berjalan. Silakan gunakan formulir di samping untuk menambahkan.
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
    </div>

    <style>
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: inline-flex;
            animation: marquee 30s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }
    </style>
</x-app-layout>
