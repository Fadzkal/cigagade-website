<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('surat.admin.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    Buat Surat Baru (Pelayanan Langsung di Kantor Desa)
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Pilih salah satu dari 7 template resmi KKN Desa Cigagade dan cetak dokumen langsung.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ selectedJenis: 'sku' }">

        <form action="{{ route('surat.admin.store') }}" method="POST" class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            @csrf

            <!-- Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center text-white">
                        <i class="fas fa-file-pen text-sm"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-sm">Formulir Pembuatan Surat Resmi</h3>
                        <p class="text-[11px] text-emerald-100">Standar Surat Keterangan Pemerintah Desa Cigagade</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-5 text-sm text-slate-700">

                {{-- Pilih Jenis Surat (7 Template) --}}
                <div>
                    <label class="block font-bold text-xs uppercase tracking-wider text-slate-600 mb-2">
                        Pilih Template Surat KKN <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2">
                        @foreach ($jenisList as $key => $info)
                            <label class="cursor-pointer border rounded-2xl p-2.5 text-center transition-all flex flex-col items-center justify-center gap-1.5"
                                   :class="selectedJenis === '{{ $key }}' ? 'border-emerald-600 bg-emerald-50 text-emerald-900 ring-2 ring-emerald-500 shadow-sm' : 'border-slate-200 hover:border-slate-300 text-slate-600 bg-slate-50/50'">
                                <input type="radio" name="jenis_surat" value="{{ $key }}" x-model="selectedJenis" class="sr-only" />
                                <span class="w-8 h-8 rounded-xl bg-white shadow-xs flex items-center justify-center text-xs">
                                    <i class="fas {{ $info['icon'] }}"></i>
                                </span>
                                <span class="text-[11px] font-bold">{{ $info['short'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Nomor Surat & Tanggal & Status --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <div>
                        <label class="block font-semibold mb-1 text-xs">Status Terbit</label>
                        <select name="status" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 font-semibold bg-white">
                            <option value="selesai" selected>✅ Selesai / Terbit (Langsung Cetak)</option>
                            <option value="diproses">🔄 Sedang Diproses</option>
                            <option value="pending">⏳ Menunggu (Draft)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-xs">Nomor Surat (Opsional / Otomatis)</label>
                        <input type="text" name="nomor_surat" placeholder="Otomatis jika dikosongkan" class="w-full px-3 py-2 text-xs font-mono rounded-xl border border-slate-300 bg-white" />
                    </div>
                    <div>
                        <label class="block font-semibold mb-1 text-xs">Tanggal Terbit</label>
                        <input type="date" name="tanggal_surat" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 bg-white" />
                    </div>
                </div>

                {{-- Biodata Pemohon --}}
                <div>
                    <h4 class="font-bold text-xs uppercase tracking-wider text-slate-400 mb-3">Biodata Pemohon</h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold mb-1">Nama Lengkap (Sesuai KTP) <span class="text-rose-500">*</span></label>
                            <input type="text" name="nama_lengkap" required placeholder="Contoh: ASEP SAEPUDIN" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 uppercase font-semibold" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">NIK (Nomor Induk Kependudukan) <span class="text-rose-500">*</span></label>
                            <input type="text" name="nik" required maxlength="16" placeholder="16 Digit NIK" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 font-mono" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-3">
                        <div>
                            <label class="block text-xs font-semibold mb-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" placeholder="Contoh: Garut" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                            <select name="jenis_kelamin" required class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-3">
                        <div>
                            <label class="block text-xs font-semibold mb-1">No. WhatsApp / HP <span class="text-rose-500">*</span></label>
                            <input type="text" name="no_telepon" required placeholder="08xxxxxxxxxx" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">Pekerjaan <span class="text-rose-500">*</span></label>
                            <input type="text" name="pekerjaan" required placeholder="Contoh: Buruh Harian Lepas" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">Status Perkawinan <span class="text-rose-500">*</span></label>
                            <select name="status_perkawinan" required class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300">
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin">Kawin</option>
                                <option value="Cerai Hidup">Cerai Hidup</option>
                                <option value="Cerai Mati">Cerai Mati</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-3">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold mb-1">Alamat Kampung / Dusun <span class="text-rose-500">*</span></label>
                            <input type="text" name="alamat" required placeholder="Contoh: KP. Ranca Paku" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">RT <span class="text-rose-500">*</span></label>
                            <input type="text" name="rt" required placeholder="001" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 text-center" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">RW <span class="text-rose-500">*</span></label>
                            <input type="text" name="rw" required placeholder="006" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 text-center" />
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="block text-xs font-semibold mb-1">Keperluan Pembuatan Surat</label>
                        <input type="text" name="keperluan" placeholder="Contoh: Persyaratan Credit BANK / Melamar Pekerjaan" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300" />
                    </div>
                </div>

                {{-- Dynamic Specific Section per Template --}}
                <!-- SKU SPECIFIC -->
                <div x-show="selectedJenis === 'sku'" class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-200 space-y-3">
                    <h5 class="font-bold text-xs text-emerald-900 flex items-center gap-2">
                        <i class="fas fa-store"></i> Data Tambahan: Surat Keterangan Usaha (SKU)
                    </h5>
                    <div>
                        <label class="block text-[11px] font-semibold text-emerald-900 mb-1">Nama / Bidang Usaha</label>
                        <input type="text" name="data_spesifik[nama_usaha]" placeholder="Contoh: Usaha Kuliner (Bakso Tahu & Cuangki)" class="w-full px-3 py-2 text-xs rounded-xl border border-emerald-300 bg-white" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-emerald-900 mb-1">Alamat / Lokasi Tempat Usaha</label>
                        <input type="text" name="data_spesifik[alamat_usaha]" placeholder="Contoh: Kp. Krajan RT 14 RW 02, Desa Sukadami..." class="w-full px-3 py-2 text-xs rounded-xl border border-emerald-300 bg-white" />
                    </div>
                </div>

                <!-- SKP SPECIFIC -->
                <div x-show="selectedJenis === 'skp'" class="p-4 rounded-2xl bg-teal-50/60 border border-teal-200 space-y-3">
                    <h5 class="font-bold text-xs text-teal-900 flex items-center gap-2">
                        <i class="fas fa-money-bill-wave"></i> Data Tambahan: Surat Keterangan Penghasilan (SKP)
                    </h5>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-teal-900 mb-1">Penghasilan Rata-rata Perbulan (Rp)</label>
                            <input type="number" name="data_spesifik[penghasilan_perbulan]" value="500000" class="w-full px-3 py-2 text-xs rounded-xl border border-teal-300 bg-white" />
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-teal-900 mb-1">Terbilang Kalimat</label>
                            <input type="text" name="data_spesifik[penghasilan_terbilang]" placeholder="Contoh: Lima ratus ribu rupiah" class="w-full px-3 py-2 text-xs rounded-xl border border-teal-300 bg-white" />
                        </div>
                    </div>
                </div>

                <!-- SKM SPECIFIC -->
                <div x-show="selectedJenis === 'skm'" class="p-4 rounded-2xl bg-pink-50/60 border border-pink-200 space-y-3">
                    <h5 class="font-bold text-xs text-pink-900 flex items-center gap-2">
                        <i class="fas fa-ring"></i> Data Tambahan: Surat Keterangan Menikah (SKM)
                    </h5>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-pink-900 mb-1">Nama Suami & Bin</label>
                            <input type="text" name="data_spesifik[suami_nama]" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 bg-white mb-1" placeholder="Nama Suami" />
                            <input type="text" name="data_spesifik[suami_bin]" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 bg-white" placeholder="Bin" />
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-pink-900 mb-1">Nama Istri & Binti</label>
                            <input type="text" name="data_spesifik[istri_nama]" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 bg-white mb-1" placeholder="Nama Istri" />
                            <input type="text" name="data_spesifik[istri_binti]" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 bg-white" placeholder="Binti" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-pink-900 mb-1">Tanggal Pernikahan Sah</label>
                            <input type="text" name="data_spesifik[tanggal_pernikahan]" placeholder="Contoh: 25 Oktober 2021" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 bg-white" />
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-pink-900 mb-1">KUA Tidak Tercatat</label>
                            <input type="text" name="data_spesifik[kua_kecamatan]" value="KUA Bl. Limbangan" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 bg-white" />
                        </div>
                    </div>
                </div>

                {{-- Pejabat Penandatangan --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-slate-100 pt-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Pejabat Penandatangan</label>
                        <input type="text" name="nama_kades" value="DEVI FAHRUROJI, S.Pd.I." class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Jabatan</label>
                        <input type="text" name="jabatan_kades" value="Kepala Desa Cigagade" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300" />
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('surat.admin.index') }}" class="px-4 py-2.5 rounded-xl text-slate-600 hover:bg-slate-200 text-xs font-semibold transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-semibold text-xs shadow-md shadow-emerald-600/20 transition-all flex items-center gap-2">
                    <i class="fas fa-check"></i>
                    <span>Terbitkan Surat Sekarang</span>
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
