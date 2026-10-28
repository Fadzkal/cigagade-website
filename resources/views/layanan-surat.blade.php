<x-public-layout>
    <x-slot name="title">Layanan Surat Mandiri Warga - Desa Cigagade</x-slot>
    <x-slot name="metaDescription">Layanan permohonan surat keterangan online Desa Cigagade: SKU, SKBB, SKD, SKTM, SKM, SKBM, dan SKP. Cepat, transparan, dan mudah.</x-slot>

    <div class="pt-24 pb-16 min-h-screen" x-data="{
        activeTab: '{{ $activeTab ?? 'sku' }}',
        trackInput: '{{ $trackQuery ?? '' }}',
        trackLoading: false,
        trackResult: null,
        trackError: null,
        submitLoading: false,
        successData: null,

        form: {
            jenis_surat: 'sku',
            nama_lengkap: '',
            nik: '',
            no_kk: '',
            no_telepon: '',
            tempat_lahir: 'Garut',
            tanggal_lahir: '',
            jenis_kelamin: 'Laki-laki',
            warga_negara: 'Indonesia',
            agama: 'Islam',
            status_perkawinan: 'Belum Kawin',
            pekerjaan: 'Buruh Harian Lepas',
            alamat: 'KP. Ranca Paku',
            rt: '001',
            rw: '006',
            keperluan: '',
            data_spesifik: {
                nama_usaha: '',
                alamat_usaha: '',
                penghasilan_perbulan: 500000,
                penghasilan_terbilang: 'Lima ratus ribu rupiah',
                pernyataan_rt: '01',
                pernyataan_rw: '01',
                suami_nama: '',
                suami_bin: '',
                suami_jenis_kelamin: 'Laki-aki',
                suami_ttl: '',
                suami_agama: 'Islam',
                suami_status_perkawinan: 'Jejaka',
                suami_warga_negara: 'Indonesia',
                suami_pekerjaan: 'Buruh Harian Lepas',
                suami_alamat: '',
                istri_nama: '',
                istri_binti: '',
                istri_jenis_kelamin: 'Perempuan',
                istri_ttl: '',
                istri_agama: 'Islam',
                istri_status_perkawinan: 'Perawan',
                istri_warga_negara: 'Indonesia',
                istri_pekerjaan: 'Mengurus Rumah Tangga',
                istri_alamat: '',
                tanggal_pernikahan: '',
                kua_kecamatan: 'KUA Bl. Limbangan'
            }
        },

        init() {
            this.form.jenis_surat = this.activeTab;
            if (this.trackInput) {
                this.searchTrack();
            }
        },

        selectJenis(key) {
            this.activeTab = key;
            this.form.jenis_surat = key;
            if (key === 'sku' && !this.form.keperluan) this.form.keperluan = 'Persyaratan Credit BANK';
            if (key === 'skbb' && !this.form.keperluan) this.form.keperluan = 'Kelengkapan Credit Bank';
            if (key === 'sktm' && !this.form.keperluan) this.form.keperluan = 'Keringanan Biaya di PUSKESMAS';
            if (key === 'skm' && !this.form.keperluan) this.form.keperluan = 'Persyaratan Isbat Nikah';
            if (key === 'skp' && !this.form.keperluan) this.form.keperluan = 'Untuk Persyaratan Melanjutkan Pendidikan Ke perguruan Tinggi';
        },

        async searchTrack() {
            if (!this.trackInput.trim()) return;
            this.trackLoading = true;
            this.trackError = null;
            this.trackResult = null;

            try {
                const res = await fetch('{{ route('layanan-surat.track') }}?query=' + encodeURIComponent(this.trackInput.trim()), {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();
                if (data.success && data.data.length > 0) {
                    this.trackResult = data.data;
                } else {
                    this.trackError = data.message || 'Permohonan tidak ditemukan.';
                }
            } catch (err) {
                this.trackError = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
            } finally {
                this.trackLoading = false;
            }
        },

        async submitForm() {
            if (!this.form.nama_lengkap || !this.form.nik || !this.form.no_telepon || !this.form.alamat) {
                alert('Mohon lengkapi Nama Lengkap, NIK, No. WhatsApp, dan Alamat Anda.');
                return;
            }
            if (this.form.nik.length < 16) {
                alert('NIK harus terdiri dari 16 digit.');
                return;
            }

            this.submitLoading = true;

            try {
                const res = await fetch('{{ route('layanan-surat.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.form)
                });
                const data = await res.json();

                if (data.success) {
                    this.successData = data.data;
                    window.scrollTo({ top: 300, behavior: 'smooth' });
                } else {
                    alert(data.message || 'Gagal mengirim permohonan surat.');
                }
            } catch (err) {
                alert('Terjadi kesalahan sistem. Silakan periksa koneksi internet Anda.');
            } finally {
                this.submitLoading = false;
            }
        }
    }">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            {{-- ─── HERO BANNER ─────────────────────────────────────────────── --}}
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-emerald-950 to-teal-900 text-white p-8 sm:p-12 shadow-2xl border border-emerald-500/20">
                <div class="absolute -right-16 -bottom-16 w-80 h-80 rounded-full bg-emerald-500/15 blur-3xl pointer-events-none"></div>
                <div class="relative max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        <i class="fas fa-certificate text-emerald-400"></i>
                        <span>Pelayanan Administrasi KKN Resmi Desa Cigagade</span>
                    </div>
                    <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                        Layanan Surat Mandiri Warga Desa Cigagade
                    </h1>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                        Ajukan permohonan surat keterangan resmi pemerintah desa secara mandiri dari mana saja. Tersedia <strong>7 template surat resmi</strong> sesuai standar administrasi Pemerintah Kabupaten Garut.
                    </p>
                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <a href="#form-section" class="px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 active:scale-95 text-white font-bold text-sm shadow-lg shadow-emerald-600/30 transition-all flex items-center gap-2">
                            <i class="fas fa-file-pen"></i>
                            <span>Ajukan Surat Sekarang</span>
                        </a>
                        <a href="#lacak-section" class="px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 active:scale-95 text-white font-semibold text-sm backdrop-blur-sm border border-white/20 transition-all flex items-center gap-2">
                            <i class="fas fa-magnifying-glass"></i>
                            <span>Lacak Status Permohonan</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- ─── SUKSES MODAL / NOTIFIKASI REGISTRASI ─────────────────────── --}}
            <div x-show="successData" x-transition class="p-6 sm:p-8 rounded-3xl bg-emerald-50 dark:bg-emerald-950/50 border-2 border-emerald-500 shadow-xl space-y-4">
                <div class="flex items-center gap-3 text-emerald-800 dark:text-emerald-300">
                    <span class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-2xl shadow-md">
                        <i class="fas fa-check"></i>
                    </span>
                    <div>
                        <h3 class="text-xl font-black">Permohonan Berhasil Dikirim!</h3>
                        <p class="text-xs text-emerald-700 dark:text-emerald-400">Data Anda telah masuk ke sistem antrean pelayanan SuperAdmin Kantor Desa Cigagade.</p>
                    </div>
                </div>

                <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-emerald-200 dark:border-emerald-800 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <span class="text-[11px] font-semibold text-slate-400 uppercase">Kode Lacak Resmi</span>
                        <div class="font-mono text-xl font-black text-emerald-600 dark:text-emerald-400 mt-0.5" x-text="successData?.tracking_code"></div>
                    </div>
                    <div>
                        <span class="text-[11px] font-semibold text-slate-400 uppercase">Jenis Surat</span>
                        <div class="font-bold text-slate-800 dark:text-slate-100 mt-0.5 text-sm" x-text="successData?.jenis_surat"></div>
                    </div>
                    <div>
                        <span class="text-[11px] font-semibold text-slate-400 uppercase">Status Permohonan</span>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 mt-1">
                            <i class="fas fa-clock text-amber-500"></i>
                            <span x-text="successData?.status"></span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a :href="'https://wa.me/6281234567890?text=' + encodeURIComponent('Halo Petugas Pelayanan Desa Cigagade, saya telah mengajukan surat online dengan Kode Lacak: ' + successData?.tracking_code + ' atas nama ' + successData?.nama_lengkap + '. Mohon konfirmasi.')"
                       target="_blank" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-2 shadow-sm transition-all">
                        <i class="fab fa-whatsapp text-sm"></i>
                        <span>Konfirmasi via WhatsApp Pelayanan</span>
                    </a>
                    <button type="button" @click="trackInput = successData?.tracking_code; searchTrack(); document.getElementById('lacak-section').scrollIntoView({behavior: 'smooth'})"
                            class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs flex items-center gap-2 transition-all">
                        <i class="fas fa-magnifying-glass"></i>
                        <span>Cek Status Secara Langsung</span>
                    </button>
                    <button type="button" @click="successData = null" class="text-xs text-slate-500 hover:text-slate-700 font-semibold ml-auto">
                        Tutup Notifikasi &times;
                    </button>
                </div>
            </div>

            {{-- ─── 7 TEMPLATE SELECTION TABS ───────────────────────────────── --}}
            <div id="form-section" class="space-y-6">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-sm">
                            <i class="fas fa-list-check"></i>
                        </span>
                        <span>Pilih Template Surat yang Dibutuhkan</span>
                    </h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Pilih salah satu dari 7 template resmi di bawah ini. Formulir akan menyesuaikan secara dinamis.
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
                    @foreach ($jenisList as $key => $item)
                        <button type="button" @click="selectJenis('{{ $key }}')"
                                :class="activeTab === '{{ $key }}' ? 'border-emerald-600 bg-white dark:bg-slate-800 ring-2 ring-emerald-500 shadow-md scale-102' : 'border-slate-200 dark:border-slate-800 bg-white/70 dark:bg-slate-900/60 hover:border-slate-300 dark:hover:border-slate-700'"
                                class="p-3.5 rounded-2xl border text-center transition-all flex flex-col items-center justify-between gap-2 text-left group">
                            <span class="w-10 h-10 rounded-2xl flex items-center justify-center text-base transition-colors"
                                  :class="activeTab === '{{ $key }}' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300'">
                                <i class="fas {{ $item['icon'] }}"></i>
                            </span>
                            <div>
                                <div class="text-xs font-extrabold text-slate-900 dark:text-white">{{ $item['short'] }}</div>
                                <div class="text-[9.5px] text-slate-500 dark:text-slate-400 line-clamp-1 mt-0.5">{{ $item['title'] }}</div>
                            </div>
                            <span class="text-[9px] font-mono font-bold px-2 py-0.5 rounded-full"
                                  :class="activeTab === '{{ $key }}' ? 'bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-500'">
                                Kode: {{ $item['code'] }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- ─── FORMULIR ISIAN LENGKAP ───────────────────────────────────── --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden">
                <div class="px-6 py-5 bg-slate-900 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-lg">
                            <i class="fas fa-file-pen"></i>
                        </span>
                        <div>
                            <h3 class="font-bold text-base flex items-center gap-2">
                                <span>Formulir Pengajuan:</span>
                                <span class="text-emerald-400 uppercase font-mono" x-text="form.jenis_surat.toUpperCase()"></span>
                            </h3>
                            <p class="text-xs text-slate-400">Pastikan data yang dimasukkan sesuai dengan KTP dan Kartu Keluarga yang berlaku.</p>
                        </div>
                    </div>
                </div>

                <form @submit.prevent="submitForm()" class="p-6 sm:p-8 space-y-6 text-sm text-slate-700 dark:text-slate-200">

                    {{-- Bagian 1: Biodata Warga --}}
                    <div>
                        <h4 class="font-bold text-xs uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-4 flex items-center gap-2">
                            <i class="fas fa-id-card text-emerald-600"></i>
                            <span>1. Biodata Pemohon (Sesuai KTP)</span>
                        </h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                    Nama Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" x-model="form.nama_lengkap" required placeholder="Contoh: ASEP KURNIAWAN"
                                       class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 uppercase font-semibold focus:ring-2 focus:ring-emerald-500 outline-none" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                    NIK (Nomor Induk Kependudukan) <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" x-model="form.nik" required maxlength="16" placeholder="16 Digit NIK"
                                       class="w-full px-3.5 py-2.5 text-xs font-mono rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                    No. WhatsApp / HP Aktif <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" x-model="form.no_telepon" required placeholder="08xxxxxxxxxx"
                                       class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">Tempat Lahir</label>
                                <input type="text" x-model="form.tempat_lahir" placeholder="Contoh: Garut"
                                       class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">Tanggal Lahir</label>
                                <input type="date" x-model="form.tanggal_lahir"
                                       class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                            <div>
                                <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                    Jenis Kelamin <span class="text-rose-500">*</span>
                                </label>
                                <select x-model="form.jenis_kelamin" required
                                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                    Pekerjaan <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" x-model="form.pekerjaan" required placeholder="Contoh: Buruh Harian Lepas / Wiraswasta"
                                       class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                    Status Perkawinan <span class="text-rose-500">*</span>
                                </label>
                                <select x-model="form.status_perkawinan" required
                                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none">
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Cerai Hidup">Cerai Hidup</option>
                                    <option value="Cerai Mati">Cerai Mati</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-4">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                    Alamat Kampung / Dusun <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" x-model="form.alamat" required placeholder="Contoh: KP. Ranca Paku / Tonjong Kulon"
                                       class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                    RT <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" x-model="form.rt" required placeholder="001"
                                       class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-center focus:ring-2 focus:ring-emerald-500 outline-none" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                    RW (001 - 010) <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" x-model="form.rw" required placeholder="006"
                                       class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-center focus:ring-2 focus:ring-emerald-500 outline-none" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                Keperluan Pembuatan Surat <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" x-model="form.keperluan" required placeholder="Contoh: Persyaratan Credit BANK / Keringanan Biaya PUSKESMAS"
                                   class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none" />
                        </div>
                    </div>

                    {{-- Bagian 2: Data Spesifik Template --}}
                    <!-- SKU DYNAMIC FIELDS -->
                    <div x-show="activeTab === 'sku'" class="p-5 rounded-2xl bg-emerald-50/60 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 space-y-4">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-emerald-800 dark:text-emerald-300 flex items-center gap-2">
                            <i class="fas fa-store"></i>
                            <span>2. Data Usaha Pemohon (Sesuai Template SKU)</span>
                        </h4>
                        <div>
                            <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                Nama / Bidang Usaha yang Dijalankan <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" x-model="form.data_spesifik.nama_usaha" placeholder="Contoh: Usaha Kuliner (Bakso Tahu & Cuangki)"
                                   class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-emerald-300 dark:border-emerald-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                Lokasi / Alamat Tempat Usaha Berdiri <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" x-model="form.data_spesifik.alamat_usaha" placeholder="Contoh: Kp. Krajan RT 14 RW 02, Desa Sukadami, Wanayasa, Purwakarta"
                                   class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-emerald-300 dark:border-emerald-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none" />
                        </div>
                    </div>

                    <!-- SKP DYNAMIC FIELDS -->
                    <div x-show="activeTab === 'skp'" class="p-5 rounded-2xl bg-teal-50/60 dark:bg-teal-950/30 border border-teal-200 dark:border-teal-800 space-y-4">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-teal-800 dark:text-teal-300 flex items-center gap-2">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>2. Rincian Penghasilan (Sesuai Template SKP)</span>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                    Terima Rata-rata Perbulan (Rp) <span class="text-rose-500">*</span>
                                </label>
                                <input type="number" x-model="form.data_spesifik.penghasilan_perbulan" placeholder="500000"
                                       class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-teal-300 dark:border-teal-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-teal-500 outline-none" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-1 text-slate-700 dark:text-slate-300">
                                    Terbilang Kalimat Rupiah <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" x-model="form.data_spesifik.penghasilan_terbilang" placeholder="Contoh: Lima ratus ribu rupiah"
                                       class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-teal-300 dark:border-teal-700 bg-white dark:bg-slate-800 focus:ring-2 focus:ring-teal-500 outline-none" />
                            </div>
                        </div>
                    </div>

                    <!-- SKBM DYNAMIC FIELDS -->
                    <div x-show="activeTab === 'skbm'" class="p-5 rounded-2xl bg-indigo-50/60 dark:bg-indigo-950/30 border border-indigo-200 dark:border-indigo-800 space-y-4">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-indigo-800 dark:text-indigo-300 flex items-center gap-2">
                            <i class="fas fa-user-check"></i>
                            <span>2. Pengantar RT & RW (Sesuai Template SKBM)</span>
                        </h4>
                        <div class="grid grid-cols-2 gap-4 max-w-xs">
                            <div>
                                <label class="block text-xs font-semibold mb-1">Ketua RT</label>
                                <input type="text" x-model="form.data_spesifik.pernyataan_rt" placeholder="01"
                                       class="w-full px-3 py-2 text-xs rounded-xl border border-indigo-300 dark:border-indigo-700 bg-white dark:bg-slate-800 text-center" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-1">Ketua RW</label>
                                <input type="text" x-model="form.data_spesifik.pernyataan_rw" placeholder="10"
                                       class="w-full px-3 py-2 text-xs rounded-xl border border-indigo-300 dark:border-indigo-700 bg-white dark:bg-slate-800 text-center" />
                            </div>
                        </div>
                    </div>

                    <!-- SKM DYNAMIC FIELDS -->
                    <div x-show="activeTab === 'skm'" class="p-5 rounded-2xl bg-pink-50/60 dark:bg-pink-950/30 border border-pink-200 dark:border-pink-800 space-y-4">
                        <h4 class="font-bold text-xs uppercase tracking-wider text-pink-800 dark:text-pink-300 flex items-center gap-2">
                            <i class="fas fa-ring"></i>
                            <span>2. Data Calon Suami & Istri (Sesuai Template SKM)</span>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="p-3.5 rounded-xl bg-white dark:bg-slate-800 border border-pink-200 dark:border-pink-900 space-y-2">
                                <h5 class="font-bold text-xs text-pink-700 dark:text-pink-400">Data Suami:</h5>
                                <input type="text" x-model="form.data_spesifik.suami_nama" placeholder="Nama Suami" class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900" />
                                <input type="text" x-model="form.data_spesifik.suami_bin" placeholder="Bin (Nama Ayah Suami)" class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900" />
                                <input type="text" x-model="form.data_spesifik.suami_ttl" placeholder="Tempat, Tgl Lahir Suami" class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900" />
                                <input type="text" x-model="form.data_spesifik.suami_alamat" placeholder="Alamat Suami" class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900" />
                            </div>
                            <div class="p-3.5 rounded-xl bg-white dark:bg-slate-800 border border-pink-200 dark:border-pink-900 space-y-2">
                                <h5 class="font-bold text-xs text-pink-700 dark:text-pink-400">Data Istri:</h5>
                                <input type="text" x-model="form.data_spesifik.istri_nama" placeholder="Nama Istri" class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900" />
                                <input type="text" x-model="form.data_spesifik.istri_binti" placeholder="Binti (Nama Ayah Istri)" class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900" />
                                <input type="text" x-model="form.data_spesifik.istri_ttl" placeholder="Tempat, Tgl Lahir Istri" class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900" />
                                <input type="text" x-model="form.data_spesifik.istri_alamat" placeholder="Alamat Istri" class="w-full px-3 py-1.5 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold mb-1">Tanggal Pernikahan Sah</label>
                                <input type="text" x-model="form.data_spesifik.tanggal_pernikahan" placeholder="Contoh: 25 Oktober 2021" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 dark:border-pink-800 bg-white dark:bg-slate-800" />
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-1">KUA Tidak Tercatat</label>
                                <input type="text" x-model="form.data_spesifik.kua_kecamatan" placeholder="KUA Bl. Limbangan" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 dark:border-pink-800 bg-white dark:bg-slate-800" />
                            </div>
                        </div>
                    </div>

                    <!-- Persetujuan & Tombol Submit -->
                    <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="text-xs text-slate-500 dark:text-slate-400 max-w-lg">
                            Dengan mengklik tombol kirim, saya menyatakan bahwa data yang diisi adalah benar dan dapat dipertanggungjawabkan sesuai hukum yang berlaku di NKRI.
                        </div>
                        <button type="submit" :disabled="submitLoading"
                                class="px-8 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-sm shadow-lg shadow-emerald-600/30 active:scale-95 transition-all flex items-center gap-2 shrink-0 disabled:opacity-50">
                            <span x-show="!submitLoading"><i class="fas fa-paper-plane mr-1.5"></i> Kirim Permohonan Surat</span>
                            <span x-show="submitLoading"><i class="fas fa-spinner fa-spin mr-1.5"></i> Sedang Mengirim...</span>
                        </button>
                    </div>

                </form>
            </div>

            {{-- ─── SECTION LACAK STATUS PERMOHONAN ────────────────────────── --}}
            <div id="lacak-section" class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-8 sm:p-12 text-white space-y-6 shadow-xl border border-slate-700">
                <div class="max-w-2xl space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">
                        <i class="fas fa-satellite-dish mr-1"></i> Pelacakan Terintegrasi
                    </span>
                    <h3 class="text-2xl sm:text-3xl font-black text-white">
                        Lacak Status & Ambil Dokumen Surat Anda
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                        Masukkan <strong>16 digit NIK</strong> atau <strong>Kode Lacak</strong> (contoh: SRT-202610-001) untuk memantau status verifikasi dokumen Anda secara real-time.
                    </p>
                </div>

                {{-- Input Pencarian --}}
                <div class="flex flex-col sm:flex-row gap-3 max-w-xl">
                    <div class="relative flex-1">
                        <i class="fas fa-search absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                        <input type="text" x-model="trackInput" @keydown.enter="searchTrack()" placeholder="Masukkan NIK atau Kode Lacak..."
                               class="w-full pl-11 pr-4 py-3 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-slate-400 text-sm focus:ring-2 focus:ring-emerald-500 outline-none backdrop-blur-md">
                    </div>
                    <button type="button" @click="searchTrack()" :disabled="trackLoading"
                            class="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 active:scale-95 text-white font-bold text-sm shadow-md transition-all shrink-0 flex items-center justify-center gap-2">
                        <span x-show="!trackLoading"><i class="fas fa-magnifying-glass"></i> Lacak Sekarang</span>
                        <span x-show="trackLoading"><i class="fas fa-spinner fa-spin"></i> Mencari...</span>
                    </button>
                </div>

                {{-- Pesan Error Lacak --}}
                <div x-show="trackError" x-transition class="p-4 rounded-2xl bg-rose-500/20 border border-rose-500/40 text-rose-200 text-xs flex items-center gap-2 max-w-xl">
                    <i class="fas fa-circle-exclamation text-rose-400"></i>
                    <span x-text="trackError"></span>
                </div>

                {{-- Hasil Pencarian Lacak --}}
                <div x-show="trackResult && trackResult.length > 0" x-transition class="space-y-4 pt-2">
                    <h4 class="text-sm font-bold text-emerald-400 flex items-center gap-2">
                        <i class="fas fa-circle-check"></i>
                        <span>Ditemukan <span x-text="trackResult.length"></span> Permohonan Surat:</span>
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="item in trackResult" :key="item.tracking_code">
                            <div class="p-5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 space-y-3 hover:border-emerald-500/50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <span class="font-mono text-xs font-bold text-emerald-300" x-text="item.tracking_code"></span>
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold"
                                          :class="item.status === 'selesai' ? 'bg-emerald-500 text-white' : (item.status === 'diproses' ? 'bg-blue-500 text-white' : (item.status === 'ditolak' ? 'bg-rose-500 text-white' : 'bg-amber-500 text-white'))"
                                          x-text="item.status_label">
                                    </span>
                                </div>
                                <div>
                                    <h5 class="font-bold text-sm text-white" x-text="item.jenis_title"></h5>
                                    <p class="text-xs text-slate-300 mt-0.5">Pemohon: <span class="font-semibold text-white" x-text="item.nama_lengkap"></span> (<span x-text="item.nik"></span>)</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Tanggal: <span x-text="item.tanggal_pengajuan"></span></p>
                                </div>
                                <div x-show="item.catatan" class="p-2.5 rounded-xl bg-black/30 border border-white/10 text-xs text-slate-300">
                                    <span class="font-semibold text-amber-300">Catatan Petugas:</span>
                                    <span x-text="item.catatan"></span>
                                </div>
                                <div x-show="item.can_print" class="pt-2 border-t border-white/10 flex items-center gap-2">
                                    <a :href="item.print_url" target="_blank"
                                       class="w-full py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs text-center flex items-center justify-center gap-2 transition-all">
                                        <i class="fas fa-print"></i>
                                        <span>Lihat & Cetak Dokumen Resmi</span>
                                    </a>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- ─── ALUR PELAYANAN INFOGRAFIS ──────────────────────────────── --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 sm:p-10 border border-slate-200 dark:border-slate-800 shadow-sm space-y-6">
                <div class="text-center max-w-xl mx-auto space-y-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Alur Standar Pelayanan</span>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white">Mudah, Cepat, dan Transparan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">4 langkah praktis dalam pengurusan surat keterangan di Desa Cigagade</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-4">
                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 space-y-3">
                        <span class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-black text-base">
                            1
                        </span>
                        <h4 class="font-bold text-sm text-slate-800 dark:text-white">Pilih Template Surat</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Pilih salah satu dari 7 template resmi (SKU, SKBB, SKD, SKTM, SKM, SKBM, SKP) dan isi data formulir secara lengkap.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 space-y-3">
                        <span class="w-10 h-10 rounded-2xl bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black text-base">
                            2
                        </span>
                        <h4 class="font-bold text-sm text-slate-800 dark:text-white">Verifikasi Petugas</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Staf kantor desa memeriksa keabsahan NIK dan pengantar RT/RW melalui panel SuperAdmin desa.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 space-y-3">
                        <span class="w-10 h-10 rounded-2xl bg-amber-100 dark:bg-amber-950 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-base">
                            3
                        </span>
                        <h4 class="font-bold text-sm text-slate-800 dark:text-white">Legalisasi & Terbit</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Surat diberi nomor resmi dan disahkan oleh Kepala Desa Cigagade sesuai tanggal terbit surat.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/80 space-y-3">
                        <span class="w-10 h-10 rounded-2xl bg-teal-100 dark:bg-teal-950 text-teal-600 dark:text-teal-400 flex items-center justify-center font-black text-base">
                            4
                        </span>
                        <h4 class="font-bold text-sm text-slate-800 dark:text-white">Cetak Dokumen Fisik</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Pemohon dapat mencetak dokumen secara online dengan kode lacak atau mengambil berkas fisik di Kantor Desa.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-public-layout>
