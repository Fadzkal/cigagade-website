<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('umkm.admin.index') }}"
                   class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h2 class="font-bold text-xl text-slate-800 leading-tight">
                        Tambah Produk UMKM Baru
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daftarkan usaha, produk, atau jasa warga Desa Cigagade</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl shadow-sm">
                    <div class="flex items-center gap-2 font-semibold text-sm mb-1 text-red-800">
                        <i class="fas fa-circle-exclamation"></i>
                        Periksa kembali input formulir:
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 mt-2 text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('umkm.admin.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-6">
                    <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fas fa-box text-emerald-600 text-sm"></i>
                        Informasi Utama Produk
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Nama Produk --}}
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Nama Produk / Usaha <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   placeholder="Contoh: Kopi Robusta Cibalampu / Keripik Singkong Cigagade"
                                   class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label for="category" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="category" id="category" required
                                    class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Harga & Satuan --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="price" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                    Harga (Rp) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-xs font-semibold text-slate-400">Rp</span>
                                    <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="100"
                                           placeholder="25000"
                                           class="w-full pl-9 pr-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                                </div>
                            </div>
                            <div>
                                <label for="unit" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                    Satuan
                                </label>
                                <input type="text" name="unit" id="unit" value="{{ old('unit', 'pcs') }}"
                                       placeholder="pcs, kg, bungkus, porsi"
                                       class="w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="sm:col-span-2">
                            <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Deskripsi Produk & Cara Pemesanan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" id="description" rows="5" required
                                      placeholder="Jelaskan keunggulan produk, varian rasa/ukuran, bahan, keaslian, dan cara warga/pembeli memesan..."
                                      class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">{{ old('description') }}</textarea>
                            <p class="text-[11px] text-slate-400 mt-1">Deskripsi ini akan muncul saat pengunjung mengklik tombol Detail di homepage atau katalog UMKM.</p>
                        </div>
                    </div>
                </div>

                {{-- Informasi Penjual & Kontak --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-6">
                    <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fab fa-whatsapp text-emerald-600 text-sm"></i>
                        Data Penjual & Kontak WhatsApp
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Nama Penjual --}}
                        <div>
                            <label for="seller_name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Nama Penjual / Pemilik Usaha <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="seller_name" id="seller_name" value="{{ old('seller_name') }}" required
                                   placeholder="Contoh: Ibu Enok / Pak Asep"
                                   class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                        </div>

                        {{-- Nomor WhatsApp --}}
                        <div>
                            <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Nomor WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-600">
                                    <i class="fab fa-whatsapp text-sm"></i>
                                </span>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                                       placeholder="Contoh: 081234567890"
                                       class="w-full pl-10 pr-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                            </div>
                            <p class="text-[11px] text-slate-400 mt-1">Tombol "Hubungi Penjual" di website akan langsung mengarahkan pengunjung ke chat WhatsApp dengan nomor ini.</p>
                        </div>

                        {{-- Lokasi / Alamat --}}
                        <div class="sm:col-span-2">
                            <label for="address" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Dusun / Alamat di Desa Cigagade
                            </label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}"
                                   placeholder="Contoh: Dusun Cigagade Hilir RT 03/02, Desa Cigagade"
                                   class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition">
                        </div>
                    </div>
                </div>

                {{-- Foto & Status --}}
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 shadow-sm space-y-6">
                    <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <i class="fas fa-image text-emerald-600 text-sm"></i>
                        Foto Produk & Visibilitas
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                        <div>
                            <label for="image" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">
                                Upload Foto Produk
                            </label>
                            <input type="file" name="image" id="image" accept="image/*"
                                   class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer border border-slate-200 rounded-xl p-1 bg-slate-50">
                            <p class="text-[11px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maks: 3MB.</p>
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                <span class="ml-3 text-sm font-medium text-slate-700">Tampilkan ke Publik (Aktif)</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('umkm.admin.index') }}"
                       class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-100 text-sm font-medium transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-xl text-sm font-semibold shadow-sm shadow-emerald-500/20 transition flex items-center gap-2">
                        <i class="fas fa-save text-xs"></i>
                        Simpan Produk UMKM
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
