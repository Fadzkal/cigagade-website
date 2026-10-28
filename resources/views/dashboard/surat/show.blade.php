<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('surat.admin.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-2">
                        <span>Detail & Verifikasi: {{ $surat->jenis_info['short'] }}</span>
                        <span class="text-xs font-mono font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                            {{ $surat->tracking_code }}
                        </span>
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ $surat->jenis_info['title'] }} &bull; Diajukan pada {{ $surat->created_at->format('d F Y, H:i') }}
                    </p>
                </div>
            </div>
            
            {{-- Quick Document Actions --}}
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('surat.admin.print', $surat->id) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs shadow-sm transition-all">
                    <i class="fas fa-print"></i> Cetak / Print
                </a>
                <a href="{{ route('surat.admin.pdf', $surat->id) }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs shadow-sm transition-all">
                    <i class="fas fa-file-pdf"></i> Unduh PDF
                </a>
                <a href="{{ route('surat.admin.word', $surat->id) }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs shadow-sm transition-all">
                    <i class="fas fa-file-word"></i> Unduh Word (.docx)
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ─── KOLOM KIRI (2 Kolom): FORM EDIT & VERIFIKASI ───────── --}}
            <div class="lg:col-span-2 space-y-6">

                <form action="{{ route('surat.admin.update', $surat->id) }}" method="POST" class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                    @csrf
                    @method('PUT')

                    <div class="px-6 py-4 bg-gradient-to-r from-slate-900 to-slate-800 text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-emerald-400">
                                <i class="fas fa-stamp text-sm"></i>
                            </span>
                            <div>
                                <h3 class="font-bold text-sm">Penomoran & Legalisasi Surat</h3>
                                <p class="text-[11px] text-slate-300">Format nomor dan pejabat penandatangan resmi desa</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $surat->status_badge['bg'] }}">
                            <i class="fas {{ $surat->status_badge['icon'] }}"></i>
                            <span>{{ $surat->status_badge['label'] }}</span>
                        </span>
                    </div>

                    <div class="p-6 space-y-5 text-sm text-slate-700">

                        {{-- Status & Nomor Surat --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold mb-1 text-xs text-slate-700">Status Permohonan <span class="text-rose-500">*</span></label>
                                <select name="status" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 outline-none font-semibold">
                                    <option value="pending" {{ $surat->status === 'pending' ? 'selected' : '' }}>⏳ Menunggu Verifikasi (Pending)</option>
                                    <option value="diproses" {{ $surat->status === 'diproses' ? 'selected' : '' }}>🔄 Sedang Diproses</option>
                                    <option value="selesai" {{ $surat->status === 'selesai' ? 'selected' : '' }}>✅ Selesai / Terbit (Siap Cetak)</option>
                                    <option value="ditolak" {{ $surat->status === 'ditolak' ? 'selected' : '' }}>❌ Ditolak / Perlu Revisi</option>
                                </select>
                            </div>

                            <div>
                                <label class="block font-semibold mb-1 text-xs text-slate-700">Nomor Surat Resmi <span class="text-rose-500">*</span></label>
                                <input type="text" name="nomor_surat" value="{{ $surat->formatted_nomor_surat }}"
                                       class="w-full px-3 py-2 text-xs font-mono font-semibold rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 outline-none" />
                                <p class="text-[10px] text-slate-400 mt-1">Format default otomatis sesuai template KKN Desa.</p>
                            </div>
                        </div>

                        {{-- Tanggal Surat & Pejabat --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block font-semibold mb-1 text-xs text-slate-700">Tanggal Terbit Surat</label>
                                <input type="date" name="tanggal_surat" value="{{ $surat->tanggal_surat ? $surat->tanggal_surat->format('Y-m-d') : date('Y-m-d') }}"
                                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 outline-none" />
                            </div>
                            <div>
                                <label class="block font-semibold mb-1 text-xs text-slate-700">Pejabat Penandatangan</label>
                                <input type="text" name="nama_kades" value="{{ $surat->nama_kades ?? 'DEVI FAHRUROJI, S.Pd.I.' }}"
                                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 outline-none" />
                            </div>
                            <div>
                                <label class="block font-semibold mb-1 text-xs text-slate-700">Jabatan Penandatangan</label>
                                <input type="text" name="jabatan_kades" value="{{ $surat->jabatan_kades ?? 'Kepala Desa Cigagade' }}"
                                       class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 outline-none" />
                            </div>
                        </div>

                        {{-- Catatan Petugas --}}
                        <div>
                            <label class="block font-semibold mb-1 text-xs text-slate-700">Catatan Petugas / Alasan Penolakan (Dapat Dilihat Warga)</label>
                            <textarea name="catatan" rows="2" placeholder="Tuliskan catatan verifikasi atau alasan bila ditolak..."
                                      class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 outline-none resize-none">{{ $surat->catatan }}</textarea>
                        </div>

                        <div class="border-t border-slate-100 pt-4">
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-400 mb-3">Biodata Pemohon (Bisa Disunting Bila Ada Koreksi)</h4>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold mb-1">Nama Lengkap Pemohon</label>
                                    <input type="text" name="nama_lengkap" value="{{ $surat->nama_lengkap }}" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 uppercase font-semibold" />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold mb-1">NIK (Nomor Induk Kependudukan)</label>
                                    <input type="text" name="nik" value="{{ $surat->nik }}" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 font-mono" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-3">
                                <div>
                                    <label class="block text-xs font-semibold mb-1">No. WhatsApp</label>
                                    <input type="text" name="no_telepon" value="{{ $surat->no_telepon }}" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300" />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold mb-1">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" value="{{ $surat->pekerjaan }}" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300" />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold mb-1">RT / RW</label>
                                    <div class="flex gap-2">
                                        <input type="text" name="rt" value="{{ $surat->rt }}" placeholder="RT" class="w-1/2 px-3 py-2 text-xs rounded-xl border border-slate-300 text-center" />
                                        <input type="text" name="rw" value="{{ $surat->rw }}" placeholder="RW" class="w-1/2 px-3 py-2 text-xs rounded-xl border border-slate-300 text-center" />
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="block text-xs font-semibold mb-1">Alamat Domisili / Kampung</label>
                                <input type="text" name="alamat" value="{{ $surat->alamat }}" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300" />
                            </div>

                            <div class="mt-3">
                                <label class="block text-xs font-semibold mb-1">Keperluan Pembuatan Surat</label>
                                <textarea name="keperluan" rows="2" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 resize-none">{{ $surat->keperluan }}</textarea>
                            </div>

                            {{-- Spesifik SKU --}}
                            @php $spec = $surat->data_spesifik ?? []; @endphp
                            @if ($surat->jenis_surat === 'sku')
                                <div class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-200 mt-4 space-y-3">
                                    <h5 class="font-bold text-xs text-emerald-900 flex items-center gap-2">
                                        <i class="fas fa-store"></i> Data Keterangan Usaha (SKU)
                                    </h5>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-emerald-900 mb-1">Nama / Bidang Usaha</label>
                                        <input type="text" name="data_spesifik[nama_usaha]" value="{{ $spec['nama_usaha'] ?? '' }}" placeholder="Contoh: Usaha Kuliner (Bakso Tahu & Cuangki)" class="w-full px-3 py-2 text-xs rounded-xl border border-emerald-300 bg-white" />
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-emerald-900 mb-1">Alamat / Lokasi Usaha</label>
                                        <input type="text" name="data_spesifik[alamat_usaha]" value="{{ $spec['alamat_usaha'] ?? '' }}" placeholder="Contoh: Kp. Krajan RT 14 RW 02, Desa Sukadami..." class="w-full px-3 py-2 text-xs rounded-xl border border-emerald-300 bg-white" />
                                    </div>
                                </div>
                            @elseif ($surat->jenis_surat === 'skp')
                                <div class="p-4 rounded-2xl bg-teal-50/60 border border-teal-200 mt-4 space-y-3">
                                    <h5 class="font-bold text-xs text-teal-900 flex items-center gap-2">
                                        <i class="fas fa-money-bill-wave"></i> Data Keterangan Penghasilan (SKP)
                                    </h5>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-[11px] font-semibold text-teal-900 mb-1">Penghasilan Rata-rata Perbulan (Rp)</label>
                                            <input type="number" name="data_spesifik[penghasilan_perbulan]" value="{{ $spec['penghasilan_perbulan'] ?? 500000 }}" class="w-full px-3 py-2 text-xs rounded-xl border border-teal-300 bg-white" />
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-semibold text-teal-900 mb-1">Pernyataan Pengantar RT / RW</label>
                                            <div class="flex gap-2">
                                                <input type="text" name="data_spesifik[pernyataan_rt]" value="{{ $spec['pernyataan_rt'] ?? $surat->rt }}" placeholder="RT" class="w-1/2 px-3 py-2 text-xs rounded-xl border border-teal-300 bg-white text-center" />
                                                <input type="text" name="data_spesifik[pernyataan_rw]" value="{{ $spec['pernyataan_rw'] ?? $surat->rw }}" placeholder="RW" class="w-1/2 px-3 py-2 text-xs rounded-xl border border-teal-300 bg-white text-center" />
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-teal-900 mb-1">Terbilang Kalimat Rupiah</label>
                                        <input type="text" name="data_spesifik[penghasilan_terbilang]" value="{{ $spec['penghasilan_terbilang'] ?? '' }}" placeholder="Contoh: Lima ratus ribu rupiah" class="w-full px-3 py-2 text-xs rounded-xl border border-teal-300 bg-white" />
                                    </div>
                                </div>
                            @elseif ($surat->jenis_surat === 'skbm')
                                <div class="p-4 rounded-2xl bg-indigo-50/60 border border-indigo-200 mt-4 space-y-3">
                                    <h5 class="font-bold text-xs text-indigo-900 flex items-center gap-2">
                                        <i class="fas fa-user-check"></i> Data Surat Pernyataan Belum Menikah (SKBM)
                                    </h5>
                                    <div>
                                        <label class="block text-[11px] font-semibold text-indigo-900 mb-1">Diketahui oleh Ketua RT & RW</label>
                                        <div class="flex gap-2">
                                            <input type="text" name="data_spesifik[pernyataan_rt]" value="{{ $spec['pernyataan_rt'] ?? $surat->rt }}" placeholder="RT" class="w-1/2 px-3 py-2 text-xs rounded-xl border border-indigo-300 bg-white text-center" />
                                            <input type="text" name="data_spesifik[pernyataan_rw]" value="{{ $spec['pernyataan_rw'] ?? $surat->rw }}" placeholder="RW" class="w-1/2 px-3 py-2 text-xs rounded-xl border border-indigo-300 bg-white text-center" />
                                        </div>
                                    </div>
                                </div>
                            @elseif ($surat->jenis_surat === 'skm')
                                <div class="p-4 rounded-2xl bg-pink-50/60 border border-pink-200 mt-4 space-y-3">
                                    <h5 class="font-bold text-xs text-pink-900 flex items-center gap-2">
                                        <i class="fas fa-ring"></i> Data Suami & Istri (SKM)
                                    </h5>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-[11px] font-semibold text-pink-900 mb-1">Nama Suami & Bin</label>
                                            <input type="text" name="data_spesifik[suami_nama]" value="{{ $spec['suami_nama'] ?? $surat->nama_lengkap }}" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 bg-white mb-1" placeholder="Nama Suami" />
                                            <input type="text" name="data_spesifik[suami_bin]" value="{{ $spec['suami_bin'] ?? '' }}" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 bg-white" placeholder="Bin" />
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-semibold text-pink-900 mb-1">Nama Istri & Binti</label>
                                            <input type="text" name="data_spesifik[istri_nama]" value="{{ $spec['istri_nama'] ?? '' }}" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 bg-white mb-1" placeholder="Nama Istri" />
                                            <input type="text" name="data_spesifik[istri_binti]" value="{{ $spec['istri_binti'] ?? '' }}" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 bg-white" placeholder="Binti" />
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2">
                                        <div>
                                            <label class="block text-[11px] font-semibold text-pink-900 mb-1">Tanggal Pernikahan</label>
                                            <input type="text" name="data_spesifik[tanggal_pernikahan]" value="{{ $spec['tanggal_pernikahan'] ?? '' }}" placeholder="Contoh: 25 Oktober 2021" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 bg-white" />
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-semibold text-pink-900 mb-1">KUA Tidak Tercatat</label>
                                            <input type="text" name="data_spesifik[kua_kecamatan]" value="{{ $spec['kua_kecamatan'] ?? 'KUA Bl. Limbangan' }}" class="w-full px-3 py-2 text-xs rounded-xl border border-pink-300 bg-white" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>

                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-semibold text-xs shadow-md shadow-emerald-600/20 transition-all flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan & Verifikasi</span>
                        </button>
                    </div>
                </form>

            </div>

            {{-- ─── KOLOM KANAN (1 Kolom): KARTU AKSI CEPAT & WHATSAPP ─── --}}
            <div class="space-y-6">

                {{-- Kartu WhatsApp Notifikasi --}}
                <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-sm space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                            <i class="fab fa-whatsapp"></i>
                        </span>
                        <div>
                            <h4 class="font-bold text-sm text-slate-800">Kirim Notifikasi WA</h4>
                            <p class="text-xs text-slate-400">Konfirmasi status permohonan ke pemohon</p>
                        </div>
                    </div>

                    @php
                        $waPhone = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $surat->no_telepon));
                        $waPesan = "*PEMERINTAH DESA CIGAGADE*\n" .
                                   "*KECAMATAN BALUBUR LIMBANGAN, GARUT*\n\n" .
                                   "Yth. Bapak/Ibu *" . $surat->nama_lengkap . "*,\n\n" .
                                   "Permohonan *" . $surat->jenis_info['title'] . "* dengan rincian:\n" .
                                   "• No. Registrasi: *" . $surat->tracking_code . "*\n" .
                                   "• Status: *" . $surat->status_badge['label'] . "*\n" .
                                   ($surat->nomor_surat ? "• No. Surat: " . $surat->formatted_nomor_surat . "\n" : "") .
                                   ($surat->catatan ? "• Catatan: " . $surat->catatan . "\n" : "") . "\n" .
                                   ($surat->status === 'selesai'
                                       ? "Surat Anda telah *SELESAI DITERBITKAN*. Anda dapat mengambil dokumen fisik di Kantor Desa Cigagade pada jam kerja, atau mengunduhnya melalui tautan portal resmi:\n" . route('layanan-surat.index', ['lacak' => $surat->tracking_code]) . "\n\n"
                                       : "Permohonan Anda saat ini *" . $surat->status_badge['label'] . "* oleh petugas administrasi Desa Cigagade.\n\n") .
                                   "Terima kasih atas kerja samanya.\n_Pemerintah Desa Cigagade_";
                        $waUrl = "https://wa.me/{$waPhone}?text=" . urlencode($waPesan);
                    @endphp

                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200 text-xs font-mono text-slate-600 max-h-36 overflow-y-auto whitespace-pre-line leading-relaxed">
                        {{ $waPesan }}
                    </div>

                    <a href="{{ $waUrl }}" target="_blank"
                       class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs flex items-center justify-center gap-2 shadow-sm transition-all">
                        <i class="fab fa-whatsapp text-sm"></i>
                        <span>Buka Chat & Kirim ke Pemohon</span>
                    </a>
                </div>

                {{-- Ringkasan Dokumen Cetak --}}
                <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-sm space-y-4">
                    <h4 class="font-bold text-sm text-slate-800 flex items-center gap-2">
                        <i class="fas fa-file-invoice text-emerald-600"></i>
                        <span>Dokumen Siap Unduh & Cetak</span>
                    </h4>

                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="flex items-center gap-2.5">
                                <i class="fas fa-file-word text-blue-600 text-base"></i>
                                <div>
                                    <div class="font-bold text-slate-800">Microsoft Word (.docx)</div>
                                    <div class="text-[10px] text-slate-400">100% Persis Template KKN</div>
                                </div>
                            </div>
                            <a href="{{ route('surat.admin.word', $surat->id) }}" class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-[11px]">
                                Unduh
                            </a>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="flex items-center gap-2.5">
                                <i class="fas fa-file-pdf text-rose-600 text-base"></i>
                                <div>
                                    <div class="font-bold text-slate-800">Format PDF Resmi</div>
                                    <div class="text-[10px] text-slate-400">Siap Kirim & Diarsip</div>
                                </div>
                            </div>
                            <a href="{{ route('surat.admin.pdf', $surat->id) }}" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white font-semibold text-[11px]">
                                Unduh
                            </a>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-200">
                            <div class="flex items-center gap-2.5">
                                <i class="fas fa-print text-slate-700 text-base"></i>
                                <div>
                                    <div class="font-bold text-slate-800">Cetak Browser Langsung</div>
                                    <div class="text-[10px] text-slate-400">Layout Presisi A4 Portrait</div>
                                </div>
                            </div>
                            <a href="{{ route('surat.admin.print', $surat->id) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white font-semibold text-[11px]">
                                Pratinjau
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Hapus Permohonan --}}
                <div class="bg-rose-50/60 rounded-3xl p-5 border border-rose-200">
                    <h5 class="text-xs font-bold text-rose-900 mb-1">Zona Bahaya</h5>
                    <p class="text-[11px] text-rose-700/80 mb-3">Menghapus data permohonan ini tidak dapat dibatalkan.</p>
                    <form action="{{ route('surat.admin.destroy', $surat->id) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda benar-benar yakin ingin menghapus surat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 px-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-trash-can"></i> Hapus Permohonan Surat Ini
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
