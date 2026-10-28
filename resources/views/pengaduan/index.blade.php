<x-public-layout>
    <x-slot name="title">Layanan Pengaduan & Aspirasi Masyarakat - Desa Cigagade</x-slot>

    {{-- ─── HERO HEADER (Clean, Professional, Eye-friendly) ─────────────────── --}}
    <section class="pt-28 pb-12 sm:pb-16 bg-white dark:bg-slate-900 border-b border-slate-200/80 dark:border-slate-800">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800 mb-3 shadow-xs">
                <i class="fas fa-bullhorn text-emerald-600 dark:text-emerald-400"></i> Suara & Aspirasi Warga Cigagade
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">
                Layanan Pengaduan & Aspirasi Warga
            </h1>
            <p class="mt-3.5 text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
                Pemerintah Desa Cigagade membuka ruang seluas-luasnya bagi seluruh warga untuk menyampaikan saran, keluhan, dan aspirasi. Laporan dapat dikirim secara <strong>terbuka</strong> maupun <strong>anonim</strong>.
            </p>

            {{-- Stat Counters (Clean & Unified Neutral Design) --}}
            <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 max-w-3xl mx-auto">
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200/80 dark:border-slate-700 text-center">
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-white">{{ $stats['total'] }}</p>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-0.5">Total Aduan</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200/80 dark:border-slate-700 text-center">
                    <p class="text-2xl sm:text-3xl font-extrabold text-emerald-600 dark:text-emerald-400">{{ $stats['selesai'] }}</p>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-0.5">Selesai Ditangani</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200/80 dark:border-slate-700 text-center">
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-slate-200">{{ $stats['diproses'] }}</p>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-0.5">Sedang Diproses</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200/80 dark:border-slate-700 text-center">
                    <p class="text-2xl sm:text-3xl font-extrabold text-slate-800 dark:text-slate-200">{{ $stats['menunggu'] }}</p>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-0.5">Menunggu Telaah</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── MAIN CONTENT ──────────────────────────────────────────────────────── --}}
    <main class="py-10 bg-slate-50/70 dark:bg-slate-900 min-h-screen" x-data="pengaduanApp()">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Alert Flash Message --}}
            @if(session('success'))
                <div class="p-4 sm:p-5 rounded-2xl bg-emerald-600 text-white shadow-md flex items-center justify-between gap-4 max-w-3xl mx-auto">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-circle-check text-xl shrink-0"></i>
                        <p class="text-sm font-semibold">{{ session('success') }}</p>
                    </div>
                    <button @click="$el.parentElement.remove()" class="text-white/80 hover:text-white text-base">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            {{-- Segmented Tab Navigation --}}
            <div class="flex justify-center">
                <div class="inline-flex p-1 rounded-xl bg-slate-200/70 dark:bg-slate-800 border border-slate-300/60 dark:border-slate-700">
                    <button
                        @click="activeTab = 'form'"
                        :class="activeTab === 'form' ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-xs font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 font-medium'"
                        class="px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg text-xs sm:text-sm transition-all flex items-center gap-2"
                    >
                        <i class="fas fa-pen-to-square text-xs"></i> Buat Pengaduan
                    </button>
                    <button
                        @click="activeTab = 'lacak'"
                        :class="activeTab === 'lacak' ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-xs font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 font-medium'"
                        class="px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg text-xs sm:text-sm transition-all flex items-center gap-2"
                    >
                        <i class="fas fa-magnifying-glass text-xs"></i> Lacak Status Tiket
                    </button>
                    <button
                        @click="activeTab = 'riwayat'"
                        :class="activeTab === 'riwayat' ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-xs font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 font-medium'"
                        class="px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg text-xs sm:text-sm transition-all flex items-center gap-2"
                    >
                        <i class="fas fa-list-check text-xs"></i> Transparansi Aduan
                    </button>
                </div>
            </div>

            {{-- ── TAB 1: FORM PENGADUAN ───────────────────────────────────────── --}}
            <div x-show="activeTab === 'form'" x-transition class="max-w-3xl mx-auto">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                    
                    {{-- Clean Header --}}
                    <div class="p-6 sm:p-7 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3.5 bg-white dark:bg-slate-800">
                        <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 flex items-center justify-center text-lg shrink-0">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        <div>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">Formulir Aspirasi & Pengaduan Warga</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Silakan lengkapi informasi di bawah ini. Identitas pelapor bersifat opsional.</p>
                        </div>
                    </div>

                    {{-- Form Body --}}
                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                        @csrf

                        {{-- 1. Pilihan Kategori --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2.5">
                                1. Kategori Pengaduan <span class="text-rose-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                                @foreach($kategoriList as $katName => $kat)
                                    <label class="relative flex flex-col p-3 rounded-xl border cursor-pointer transition-all text-left"
                                           :class="selectedKategori === '{{ $katName }}' ? 'border-emerald-600 bg-emerald-50/40 dark:bg-emerald-950/30 ring-1 ring-emerald-600' : 'border-slate-200 dark:border-slate-700 hover:border-slate-300 bg-white dark:bg-slate-800'">
                                        <input type="radio" name="kategori" value="{{ $katName }}" x-model="selectedKategori" class="sr-only" required>
                                        <div class="flex items-center gap-2 mb-1">
                                            <i class="fas {{ $kat['icon'] }} text-xs" :class="selectedKategori === '{{ $katName }}' ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400'"></i>
                                            <span class="text-xs font-bold" :class="selectedKategori === '{{ $katName }}' ? 'text-emerald-950 dark:text-emerald-200' : 'text-slate-800 dark:text-slate-200'">{{ $katName }}</span>
                                        </div>
                                        <span class="text-[10px] text-slate-500 dark:text-slate-400 leading-tight">{{ $kat['desc'] }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('kategori')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- 2. Identitas Pelapor (Opsional / Anonim) --}}
                        <div class="p-5 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                    2. Identitas Pelapor <span class="text-slate-400 font-normal">(Opsional)</span>
                                </label>
                                <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                    <input type="checkbox" name="is_anonim" value="1" x-model="isAnonim" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                                    <span class="text-xs font-medium text-slate-700 dark:text-slate-300">Kirim Anonim (Nama Dirahasiakan)</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-show="!isAnonim" x-transition>
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Asep Supriatna"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-sm text-slate-800 dark:text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
                                    @error('nama') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">Nomor WhatsApp / HP</label>
                                    <input type="text" name="kontak" value="{{ old('kontak') }}" placeholder="Contoh: 081234567890"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-sm text-slate-800 dark:text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
                                    <span class="text-[10px] text-slate-400 mt-1 block">Untuk menerima notifikasi tindak lanjut langsung via WA.</span>
                                    @error('kontak') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div x-show="isAnonim" x-transition class="p-3 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-600 dark:text-slate-400 flex items-center gap-2.5">
                                <i class="fas fa-shield-halved text-emerald-600 text-sm shrink-0"></i>
                                <span>Identitas Anda akan disamarkan sebagai <strong>Warga Anonim</strong>. Anda tetap dapat memantau status melalui <strong>Kode Tiket</strong> yang diberikan.</span>
                            </div>
                        </div>

                        {{-- 3. Uraian Pengaduan --}}
                        <div class="space-y-4">
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                3. Rincian Pengaduan / Aspirasi <span class="text-rose-500">*</span>
                            </label>

                            <div>
                                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">
                                    Judul Pengaduan <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="judul" value="{{ old('judul') }}" required
                                       placeholder="Contoh: Lampu penerangan jalan mati di dekat jembatan RW 03"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-sm text-slate-800 dark:text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
                                @error('judul') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">
                                    Lokasi Kejadian <span class="text-slate-400 font-normal">(Opsional)</span>
                                </label>
                                <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                                       placeholder="Contoh: Dusun 2, RT 02 / RW 04, Dekat Pos Ronda"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-sm text-slate-800 dark:text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
                                @error('lokasi') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">
                                    Isi / Uraian Lengkap Pengaduan <span class="text-rose-500">*</span>
                                </label>
                                <textarea name="isi_pengaduan" rows="4" required
                                          placeholder="Jelaskan kondisi lapangan, saran, atau kronologi secara ringkas dan jelas..."
                                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-sm text-slate-800 dark:text-slate-200 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition leading-relaxed">{{ old('isi_pengaduan') }}</textarea>
                                @error('isi_pengaduan') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- 4. Foto Bukti (Opsional) --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                                4. Foto Bukti Lapangan <span class="text-slate-400 font-normal">(Opsional, Maks 5 MB)</span>
                            </label>
                            
                            <div class="relative border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-5 text-center hover:border-slate-400 dark:hover:border-slate-500 transition bg-slate-50/50 dark:bg-slate-800/40">
                                <input type="file" name="foto_bukti" id="foto_bukti" accept="image/*" @change="previewImage($event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                
                                <div x-show="!imagePreview" class="space-y-1.5 pointer-events-none">
                                    <div class="w-10 h-10 mx-auto rounded-full bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-300 flex items-center justify-center text-base">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                    <p class="text-xs font-medium text-slate-700 dark:text-slate-200">
                                        Klik untuk unggah foto bukti pendukung
                                    </p>
                                    <p class="text-[10px] text-slate-400">Format: JPG, PNG, WEBP (Maksimal 5 MB)</p>
                                </div>

                                <div x-show="imagePreview" x-cloak class="relative inline-block mt-2">
                                    <img :src="imagePreview" alt="Preview Foto Bukti" class="h-40 w-auto rounded-lg shadow-sm object-cover border border-slate-200 dark:border-slate-700 mx-auto">
                                    <button type="button" @click="clearImage()" class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-slate-800 hover:bg-slate-900 text-white flex items-center justify-center shadow-sm transition">
                                        <i class="fas fa-times text-[10px]"></i>
                                    </button>
                                </div>
                            </div>
                            @error('foto_bukti') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Tombol Kirim --}}
                        <div class="pt-3 border-t border-slate-100 dark:border-slate-700">
                            <button type="submit" class="w-full py-3 px-6 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-sm transition flex items-center justify-center gap-2">
                                <i class="fas fa-paper-plane text-xs"></i> Kirim Pengaduan Warga
                            </button>
                            <p class="text-[11px] text-center text-slate-400 mt-2">
                                <i class="fas fa-shield-halved text-[10px] text-emerald-600"></i> Pengaduan dikelola secara terpercaya oleh Pemerintah Desa Cigagade.
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ── TAB 2: LACAK STATUS TIKET ───────────────────────────────────── --}}
            <div x-show="activeTab === 'lacak'" x-transition class="max-w-3xl mx-auto space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200 dark:border-slate-700 text-center">
                    <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 flex items-center justify-center text-xl mx-auto mb-3">
                        <i class="fas fa-magnifying-glass"></i>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">Lacak Status Pengaduan</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-md mx-auto">
                        Masukkan <strong>Kode Tiket</strong> yang Anda peroleh saat mengirim laporan (contoh: <code>PGD-20261028-A101</code>).
                    </p>

                    <form @submit.prevent="searchTicket()" class="mt-5 flex flex-col sm:flex-row gap-2.5 max-w-md mx-auto">
                        <input
                            type="text"
                            x-model="ticketQuery"
                            placeholder="Kode Tiket (Contoh: PGD-20261028-XXXX)"
                            class="flex-1 px-3.5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white uppercase font-mono text-xs sm:text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-center sm:text-left"
                            required
                        >
                        <button type="submit" :disabled="isSearching" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm shadow-sm transition flex items-center justify-center gap-2 shrink-0">
                            <span x-show="!isSearching"><i class="fas fa-search"></i> Lacak</span>
                            <span x-show="isSearching"><i class="fas fa-spinner fa-spin"></i> Mencari...</span>
                        </button>
                    </form>

                    <p x-show="trackError" x-text="trackError" class="text-xs text-rose-500 font-semibold mt-3"></p>
                </div>

                {{-- Hasil Pencarian Lacak Tiket --}}
                <div x-show="ticketResult" x-cloak class="bg-white dark:bg-slate-800 rounded-2xl p-6 sm:p-7 shadow-sm border border-slate-200 dark:border-slate-700 space-y-5">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100 dark:border-slate-700">
                        <div>
                            <span class="text-xs font-mono font-bold text-emerald-700 dark:text-emerald-400" x-text="ticketResult?.kode_tiket"></span>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white mt-0.5" x-text="ticketResult?.judul"></h3>
                            <div class="flex flex-wrap items-center gap-2 mt-1 text-xs text-slate-500">
                                <span><i class="fas fa-user mr-1 text-slate-400"></i> <span x-text="ticketResult?.nama_tampil"></span></span>
                                <span>•</span>
                                <span><i class="fas fa-tag mr-1 text-slate-400"></i> <span x-text="ticketResult?.kategori"></span></span>
                                <span>•</span>
                                <span><i class="fas fa-calendar mr-1 text-slate-400"></i> <span x-text="ticketResult?.created_at"></span></span>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold shrink-0 self-start sm:self-center"
                              :class="ticketResult?.status_badge?.bg">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5" :class="ticketResult?.status_badge?.dot"></span>
                            <span x-text="ticketResult?.status_label"></span>
                        </span>
                    </div>

                    {{-- Isi Pengaduan & Lokasi --}}
                    <div class="space-y-3">
                        <div x-show="ticketResult?.lokasi" class="text-xs text-slate-600 dark:text-slate-300 flex items-center gap-1.5">
                            <i class="fas fa-location-dot text-slate-400"></i>
                            <span>Lokasi: <strong x-text="ticketResult?.lokasi"></strong></span>
                        </div>
                        <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 text-sm text-slate-700 dark:text-slate-300 leading-relaxed" x-text="ticketResult?.isi_pengaduan">
                        </div>
                        
                        {{-- Foto Bukti --}}
                        <template x-if="ticketResult?.foto_url">
                            <div class="mt-3">
                                <p class="text-xs font-medium text-slate-500 mb-1.5">Foto Bukti:</p>
                                <a :href="ticketResult.foto_url" target="_blank" class="block max-w-xs rounded-lg overflow-hidden border border-slate-200 shadow-xs hover:opacity-90 transition">
                                    <img :src="ticketResult.foto_url" alt="Foto Bukti Pengaduan" class="w-full h-40 object-cover">
                                </a>
                            </div>
                        </template>
                    </div>

                    {{-- Tanggapan Resmi Superadmin --}}
                    <div class="p-4 sm:p-5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/40">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-reply text-slate-500 text-xs"></i>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                Tanggapan Pemerintah Desa
                            </h4>
                        </div>

                        <template x-if="ticketResult?.tanggapan">
                            <div class="space-y-2">
                                <p class="text-sm text-slate-800 dark:text-slate-200 leading-relaxed" x-text="ticketResult.tanggapan"></p>
                                <div class="text-[11px] text-slate-500 flex items-center justify-between pt-2 border-t border-slate-200 dark:border-slate-700">
                                    <span>Oleh: <strong x-text="ticketResult.tanggapan_oleh || 'Pemdes Cigagade'"></strong></span>
                                    <span x-text="ticketResult.tanggapan_at"></span>
                                </div>
                            </div>
                        </template>

                        <template x-if="!ticketResult?.tanggapan">
                            <p class="text-xs text-slate-500 dark:text-slate-400 italic">
                                Pengaduan sedang dalam proses telaah oleh perangkat Desa Cigagade. Mohon kesediaannya menunggu.
                            </p>
                        </template>
                    </div>
                </div>
            </div>

            {{-- ── TAB 3: TRANSPARANSI & RIWAYAT PENGADUAN ─────────────────────── --}}
            <div x-show="activeTab === 'riwayat'" x-transition class="space-y-6">
                {{-- Filter Bar --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl p-3.5 shadow-xs border border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="flex flex-wrap items-center gap-1.5">
                        <span class="text-xs font-semibold text-slate-500 mr-1">Kategori:</span>
                        <a href="{{ route('pengaduan.index') }}" class="px-2.5 py-1 rounded-lg text-xs font-medium {{ !request('kategori') ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200' }}">
                            Semua
                        </a>
                        @foreach($kategoriList as $kName => $kData)
                            <a href="{{ route('pengaduan.index', ['kategori' => $kName]) }}" class="px-2.5 py-1 rounded-lg text-xs font-medium {{ request('kategori') === $kName ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200' }}">
                                {{ $kName }}
                            </a>
                        @endforeach
                    </div>
                    <span class="text-xs text-slate-500">Total: <strong>{{ $pengaduans->total() }}</strong> Laporan</span>
                </div>

                {{-- Cards Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($pengaduans as $pgd)
                        <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-xs border border-slate-200 dark:border-slate-700 flex flex-col justify-between hover:border-slate-300 transition">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-[11px] font-mono font-bold">
                                        {{ $pgd->kode_tiket }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $pgd->status_badge['bg'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $pgd->status_badge['dot'] }}"></span>
                                        {{ $pgd->status_label }}
                                    </span>
                                </div>

                                <div>
                                    <h3 class="text-sm font-bold text-slate-900 dark:text-white line-clamp-2 leading-snug">
                                        {{ $pgd->judul }}
                                    </h3>
                                    <div class="flex items-center gap-2 mt-1 text-[11px] text-slate-500">
                                        <span><i class="fas fa-user text-[10px] mr-1 text-slate-400"></i> {{ $pgd->nama_tampil }}</span>
                                        <span>•</span>
                                        <span>{{ $pgd->kategori }}</span>
                                    </div>
                                </div>

                                <p class="text-xs text-slate-600 dark:text-slate-300 line-clamp-3 leading-relaxed">
                                    {{ $pgd->isi_pengaduan }}
                                </p>

                                @if($pgd->foto_bukti)
                                    <div class="pt-1">
                                        <a href="{{ $pgd->foto_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">
                                            <i class="fas fa-image"></i> Lihat Foto Bukti
                                        </a>
                                    </div>
                                @endif

                                {{-- Tanggapan Preview --}}
                                @if($pgd->tanggapan)
                                    <div class="p-3 rounded-lg bg-slate-50 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-700 space-y-1">
                                        <p class="text-[10px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                            <i class="fas fa-reply mr-1 text-slate-500"></i> Respon Pemdes:
                                        </p>
                                        <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2">
                                            {{ $pgd->tanggapan }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="pt-3 mt-3 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between text-[11px] text-slate-400">
                                <span>{{ $pgd->created_at->diffForHumans() }}</span>
                                <button @click="quickTrack('{{ $pgd->kode_tiket }}')" class="font-bold text-emerald-600 dark:text-emerald-400 hover:underline">
                                    Detail Laporan &rarr;
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center text-slate-400 bg-white dark:bg-slate-800 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                            <i class="fas fa-inbox text-3xl mb-2 text-slate-300"></i>
                            <p class="text-sm font-medium">Belum ada pengaduan pada kategori ini.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="pt-4">
                    {{ $pengaduans->links() }}
                </div>
            </div>

        </div>
    </main>

    {{-- Script Alpine.js Controller --}}
    <script>
        function pengaduanApp() {
            return {
                activeTab: '{{ request()->filled("lacak") ? "lacak" : "form" }}',
                selectedKategori: '{{ array_key_first($kategoriList) }}',
                isAnonim: false,
                imagePreview: null,
                ticketQuery: '{{ request("lacak") ?? "" }}',
                ticketResult: @json($trackedData),
                isSearching: false,
                trackError: null,

                previewImage(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.imagePreview = URL.createObjectURL(file);
                    }
                },

                clearImage() {
                    this.imagePreview = null;
                    const input = document.getElementById('foto_bukti');
                    if (input) input.value = '';
                },

                quickTrack(code) {
                    this.ticketQuery = code;
                    this.activeTab = 'lacak';
                    this.searchTicket();
                    window.scrollTo({ top: 300, behavior: 'smooth' });
                },

                async searchTicket() {
                    const query = this.ticketQuery.trim();
                    if (!query) return;

                    this.isSearching = true;
                    this.trackError = null;

                    try {
                        const res = await fetch('{{ route('pengaduan.track') }}?query=' + encodeURIComponent(query));
                        const json = await res.json();
                        if (json.success) {
                            this.ticketResult = json.data;
                        } else {
                            this.ticketResult = null;
                            this.trackError = json.message || 'Tiket tidak ditemukan';
                        }
                    } catch (err) {
                        this.trackError = 'Terjadi kesalahan saat mencari tiket. Silakan coba lagi.';
                    } finally {
                        this.isSearching = false;
                    }
                }
            }
        }
    </script>
</x-public-layout>
