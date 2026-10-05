<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center">
                        <i class="fas fa-store"></i>
                    </span>
                    Kelola Produk UMKM Desa Cigagade
                </h2>
                <p class="text-xs text-slate-500 mt-1">Daftar usaha mikro, kecil, menengah, dan komoditas warga desa yang dipublikasikan di website.</p>
            </div>
            <a href="{{ route('umkm.admin.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-medium text-sm rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-200">
                <i class="fas fa-plus text-xs"></i>
                Tambah Produk UMKM
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3 shadow-sm">
                    <i class="fas fa-circle-check text-emerald-600 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Filter & Pencarian --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
                <form action="{{ route('umkm.admin.index') }}" method="GET" class="w-full md:w-auto flex flex-1 flex-col sm:flex-row items-center gap-3">
                    <div class="relative w-full sm:w-80">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-search text-xs"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari produk, penjual, kategori..."
                               class="w-full pl-9 pr-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                    </div>

                    <div class="w-full sm:w-56">
                        <select name="category" onchange="this.form.submit()"
                                class="w-full py-2 px-3 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-medium transition">
                        Cari
                    </button>

                    @if(request('search') || request('category'))
                        <a href="{{ route('umkm.admin.index') }}" class="w-full sm:w-auto text-center px-3 py-2 text-sm text-slate-500 hover:text-slate-800 transition">
                            Reset
                        </a>
                    @endif
                </form>

                <div class="text-xs text-slate-500 font-medium">
                    Total: <span class="font-bold text-slate-800">{{ $umkms->total() }}</span> produk
                </div>
            </div>

            {{-- Tabel Produk --}}
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                @if ($umkms->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-600">
                            <thead class="bg-slate-50 border-b border-slate-100 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                <tr>
                                    <th scope="col" class="py-3.5 px-4 w-12 text-center">No</th>
                                    <th scope="col" class="py-3.5 px-4">Produk & Usaha</th>
                                    <th scope="col" class="py-3.5 px-4">Kategori</th>
                                    <th scope="col" class="py-3.5 px-4">Harga</th>
                                    <th scope="col" class="py-3.5 px-4">Penjual & WhatsApp</th>
                                    <th scope="col" class="py-3.5 px-4 text-center">Status</th>
                                    <th scope="col" class="py-3.5 px-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($umkms as $item)
                                    <tr class="hover:bg-slate-50/60 transition-colors">
                                        <td class="py-4 px-4 text-center text-xs text-slate-400 font-medium">
                                            {{ $loop->iteration + ($umkms->currentPage() - 1) * $umkms->perPage() }}
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                                                     class="w-14 h-14 rounded-xl object-cover border border-slate-200 shadow-xs flex-shrink-0">
                                                <div>
                                                    <a href="{{ route('umkm.show', $item->slug) }}" target="_blank"
                                                       class="font-semibold text-slate-800 hover:text-emerald-600 transition inline-flex items-center gap-1.5">
                                                        {{ $item->name }}
                                                        <i class="fas fa-external-link-alt text-[10px] text-slate-400"></i>
                                                    </a>
                                                    <p class="text-xs text-slate-400 line-clamp-1 mt-0.5">{{ Str::limit($item->description, 60) }}</p>
                                                    @if($item->address)
                                                        <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                                                            <i class="fas fa-map-marker-alt text-emerald-500"></i>
                                                            {{ $item->address }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                {{ $item->category }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <div class="font-bold text-slate-800 text-sm">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </div>
                                            @if($item->unit)
                                                <div class="text-[11px] text-slate-400 font-medium">/ {{ $item->unit }}</div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <div class="font-medium text-slate-700 text-xs">{{ $item->seller_name }}</div>
                                            <a href="{{ $item->whatsapp_url }}" target="_blank"
                                               class="inline-flex items-center gap-1.5 text-xs text-emerald-600 hover:text-emerald-700 font-medium mt-1 group">
                                                <i class="fab fa-whatsapp text-emerald-500 group-hover:scale-110 transition-transform"></i>
                                                <span>{{ $item->phone }}</span>
                                            </a>
                                        </td>
                                        <td class="py-4 px-4 text-center whitespace-nowrap">
                                            @if($item->is_active)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4 text-right whitespace-nowrap">
                                            <div class="inline-flex items-center gap-2">
                                                <a href="{{ route('umkm.admin.edit', $item->id) }}"
                                                   class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition"
                                                   title="Edit Produk">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('umkm.admin.destroy', $item->id) }}" method="POST"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk UMKM ini?')"
                                                      class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                                            title="Hapus Produk">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($umkms->hasPages())
                        <div class="p-4 border-t border-slate-100 bg-slate-50">
                            {{ $umkms->links() }}
                        </div>
                    @endif
                @else
                    <div class="py-16 text-center">
                        <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-2xl mb-3">
                            <i class="fas fa-store-slash"></i>
                        </div>
                        <h3 class="text-base font-semibold text-slate-700">Belum Ada Produk UMKM</h3>
                        <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Mulai tambahkan produk unggulan warga desa Cigagade agar dapat dipromosikan ke publik.</p>
                        <a href="{{ route('umkm.admin.create') }}"
                           class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-700 transition">
                            <i class="fas fa-plus"></i> Tambah Produk Pertama
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
