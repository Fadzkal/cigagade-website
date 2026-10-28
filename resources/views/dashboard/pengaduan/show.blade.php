<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('pengaduan.admin.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 text-slate-600 hover:text-emerald-600 flex items-center justify-center shadow-sm transition">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-mono font-bold text-emerald-600">{{ $pengaduan->kode_tiket }}</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $pengaduan->status_badge['bg'] }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $pengaduan->status_badge['dot'] }}"></span>
                            {{ $pengaduan->status_label }}
                        </span>
                    </div>
                    <h2 class="font-bold text-xl text-gray-800 leading-tight mt-0.5">
                        Detail & Tindak Lanjut Pengaduan
                    </h2>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <form action="{{ route('pengaduan.admin.destroy', $pengaduan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50 border border-rose-200 transition">
                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ─── KOLOM KIRI (KONTEN PENGADUAN) ──────────────────────────────────── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Alert Flash --}}
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

            {{-- Kartu Rincian Pengaduan --}}
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 space-y-6">
                <div>
                    <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500 mb-2">
                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-bold uppercase tracking-wider text-[10px]">
                            <i class="fas fa-tag mr-1 text-slate-400"></i> {{ $pengaduan->kategori }}
                        </span>
                        <span>•</span>
                        <span><i class="fas fa-calendar mr-1"></i> {{ $pengaduan->created_at->translatedFormat('l, d F Y - H:i') }} WIB</span>
                        @if($pengaduan->lokasi)
                            <span>•</span>
                            <span class="text-rose-600 font-medium"><i class="fas fa-map-marker-alt mr-1"></i> {{ $pengaduan->lokasi }}</span>
                        @endif
                    </div>

                    <h3 class="text-2xl font-black text-slate-800 leading-snug">
                        {{ $pengaduan->judul }}
                    </h3>
                </div>

                {{-- Isi Uraian --}}
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/70 text-slate-800 text-sm sm:text-base leading-relaxed whitespace-pre-line font-normal">
{{ $pengaduan->isi_pengaduan }}
                </div>

                {{-- Bukti Foto / Gambar (Jika ada) --}}
                @if($pengaduan->foto_bukti)
                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3 flex items-center gap-1.5">
                            <i class="fas fa-image text-emerald-600"></i> Foto Bukti Lampiran Warga:
                        </h4>
                        <div class="max-w-md rounded-2xl overflow-hidden border border-slate-200 shadow-sm bg-slate-100">
                            <a href="{{ $pengaduan->foto_url }}" target="_blank" title="Klik untuk perbesar foto">
                                <img src="{{ $pengaduan->foto_url }}" alt="Bukti Pengaduan {{ $pengaduan->kode_tiket }}" class="w-full h-auto max-h-96 object-contain hover:scale-105 transition-transform duration-300">
                            </a>
                        </div>
                        <span class="text-[11px] text-slate-400 mt-1.5 block">
                            * Klik gambar untuk melihat dalam ukuran resolusi penuh di tab baru.
                        </span>
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-slate-50 border border-dashed border-slate-200 text-xs text-slate-400 flex items-center gap-2">
                        <i class="fas fa-info-circle text-sm"></i>
                        <span>Pelapor tidak menyertakan foto bukti lampiran.</span>
                    </div>
                @endif
            </div>

            {{-- Kartu Riwayat Tanggapan Saat Ini --}}
            @if($pengaduan->tanggapan)
                <div class="bg-emerald-50/60 rounded-3xl p-6 sm:p-8 border border-emerald-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-900 flex items-center gap-2">
                            <i class="fas fa-reply text-emerald-600"></i> Tanggapan Resmi yang Ditampilkan ke Warga:
                        </h4>
                        <span class="text-[11px] text-emerald-700 font-medium">
                            {{ $pengaduan->tanggapan_at ? $pengaduan->tanggapan_at->translatedFormat('d F Y, H:i') : '' }}
                        </span>
                    </div>
                    <p class="text-slate-800 text-sm leading-relaxed font-medium whitespace-pre-line">
                        {{ $pengaduan->tanggapan }}
                    </p>
                    <p class="text-xs text-emerald-800 font-semibold pt-2 border-t border-emerald-200/60">
                        Oleh: <strong>{{ $pengaduan->tanggapan_oleh ?: 'Pemerintah Desa Cigagade' }}</strong>
                    </p>
                </div>
            @endif

        </div>

        {{-- ─── KOLOM KANAN (TINDAK LANJUT & RESPON) ───────────────────────────── --}}
        <div class="space-y-6">

            {{-- Data Pelapor --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 space-y-4">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">
                    Data Pelapor
                </h4>

                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-xs text-slate-500">Status Identitas:</span>
                        @if($pengaduan->is_anonim)
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 font-bold text-xs inline-flex items-center gap-1">
                                <i class="fas fa-user-secret text-slate-500"></i> Anonim (Dirahasiakan)
                            </span>
                        @else
                            <span class="font-bold text-xs text-slate-800">{{ $pengaduan->nama }}</span>
                        @endif
                    </div>

                    @if(!$pengaduan->is_anonim && $pengaduan->kontak)
                        <div class="flex items-center justify-between py-2 border-b border-slate-100">
                            <span class="text-xs text-slate-500">No. WhatsApp / HP:</span>
                            <a href="{{ $pengaduan->whatsapp_link }}" target="_blank" class="inline-flex items-center gap-1 font-bold text-xs text-emerald-600 hover:underline">
                                <i class="fab fa-whatsapp text-emerald-500"></i> {{ $pengaduan->kontak }}
                            </a>
                        </div>
                    @endif

                    <div class="flex items-center justify-between py-2 border-b border-slate-100">
                        <span class="text-xs text-slate-500">Tanggal Aduan:</span>
                        <span class="text-xs font-semibold text-slate-800">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <span class="text-xs text-slate-500">IP Pelapor:</span>
                        <span class="text-xs font-mono text-slate-600">{{ $pengaduan->ip_address ?: '-' }}</span>
                    </div>
                </div>

                @if($pengaduan->kontak)
                    <a href="{{ $pengaduan->whatsapp_link }}" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center justify-center gap-2">
                        <i class="fab fa-whatsapp text-base"></i> Hubungi Pelapor via WA
                    </a>
                @endif
            </div>

            {{-- Form Update Status & Tanggapan --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 space-y-5">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">
                    Aksi & Tindak Lanjut Admin
                </h4>

                <form action="{{ route('pengaduan.admin.update', $pengaduan->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Pilih Status --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Status Pengaduan <span class="text-rose-500">*</span>
                        </label>
                        <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold bg-white text-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition" required>
                            <option value="menunggu" {{ $pengaduan->status === 'menunggu' ? 'selected' : '' }}>⏳ Menunggu Verifikasi</option>
                            <option value="diproses" {{ $pengaduan->status === 'diproses' ? 'selected' : '' }}>🔄 Sedang Diproses</option>
                            <option value="selesai" {{ $pengaduan->status === 'selesai' ? 'selected' : '' }}>✅ Selesai Ditindaklanjuti</option>
                            <option value="ditolak" {{ $pengaduan->status === 'ditolak' ? 'selected' : '' }}>❌ Ditolak / Tidak Valid</option>
                        </select>
                    </div>

                    {{-- Teks Tanggapan Resmi --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Tanggapan / Solusi Resmi Pemdes
                        </label>
                        <textarea name="tanggapan" rows="5" placeholder="Tuliskan jawaban, kronologi tindakan, atau solusi dari pihak Pemerintah Desa yang dapat dibaca oleh warga saat melacak tiket..."
                                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition leading-relaxed">{{ old('tanggapan', $pengaduan->tanggapan) }}</textarea>
                    </div>

                    {{-- Nama Petugas / Instansi --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            Nama Petugas / Jabatan
                        </label>
                        <input type="text" name="tanggapan_oleh" value="{{ old('tanggapan_oleh', $pengaduan->tanggapan_oleh ?? Auth::user()->name) }}" placeholder="Contoh: Kepala Seksi Pelayanan"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                    </div>

                    {{-- Visibilitas Publik --}}
                    <div class="pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_public" value="1" {{ $pengaduan->is_public ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                            <span class="text-xs font-semibold text-slate-700">Tampilkan di Transparansi Publik</span>
                        </label>
                        <span class="text-[10px] text-slate-400 block mt-0.5">Bila dicentang, laporan ini dapat dibaca oleh warga lain di halaman Transparansi Aduan.</span>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="pt-3">
                        <button type="submit" class="w-full py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md transition flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Simpan Status & Tanggapan
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</x-app-layout>
