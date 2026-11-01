<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Manajemen Akun & <span class="text-emerald-600">Pengguna</span>
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Kelola seluruh akun hak akses portal Desa Cigagade: Super Admin, 10 Pengurus RW, dan Kader TP-PKK.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition">
                    <i class="fas fa-user-plus"></i> Tambah Pengguna Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- Flash Alerts --}}
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

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fas fa-circle-exclamation text-rose-600 text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800 text-base">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        {{-- ─── KPI METRIC CARDS ─── --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('users.index') }}" class="p-5 rounded-2xl bg-white border {{ !$roleFilter ? 'ring-2 ring-emerald-500 border-emerald-300' : 'border-slate-200/80' }} shadow-sm hover:border-emerald-400 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Akun</span>
                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center text-sm group-hover:bg-slate-200 transition">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-slate-800 mt-2">{{ $stats['total'] }}</p>
                <span class="text-[11px] text-slate-400">Semua pengguna terdaftar</span>
            </a>

            <a href="{{ route('users.index', ['role' => 'superadmin']) }}" class="p-5 rounded-2xl bg-white border {{ $roleFilter === 'superadmin' ? 'ring-2 ring-indigo-500 border-indigo-300' : 'border-slate-200/80' }} shadow-sm hover:border-indigo-400 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Super Admin</span>
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm group-hover:bg-indigo-100 transition">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-indigo-700 mt-2">{{ $stats['superadmin'] }}</p>
                <span class="text-[11px] text-indigo-500 font-medium">Akses penuh sistem</span>
            </a>

            <a href="{{ route('users.index', ['role' => 'rw']) }}" class="p-5 rounded-2xl bg-white border {{ $roleFilter === 'rw' ? 'ring-2 ring-amber-500 border-amber-300' : 'border-slate-200/80' }} shadow-sm hover:border-amber-400 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-amber-600 uppercase tracking-wider">Akun RW</span>
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm group-hover:bg-amber-100 transition">
                        <i class="fas fa-map-location-dot"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-amber-700 mt-2">{{ $stats['rw'] }}</p>
                <span class="text-[11px] text-amber-600 font-medium">Pengurus RW 01 s/d RW 10</span>
            </a>

            <a href="{{ route('users.index', ['role' => 'pkk']) }}" class="p-5 rounded-2xl bg-white border {{ $roleFilter === 'pkk' ? 'ring-2 ring-pink-500 border-pink-300' : 'border-slate-200/80' }} shadow-sm hover:border-pink-400 transition group">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-pink-600 uppercase tracking-wider">Kader PKK</span>
                    <div class="w-9 h-9 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-sm group-hover:bg-pink-100 transition">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                </div>
                <p class="text-2xl font-black text-pink-700 mt-2">{{ $stats['pkk'] }}</p>
                <span class="text-[11px] text-pink-600 font-medium">Posyandu & 10 Pokok PKK</span>
            </a>
        </div>

        {{-- ─── FILTER & SEARCH BAR ─── --}}
        <div class="p-5 bg-white rounded-2xl border border-slate-200/80 shadow-sm">
            <form method="GET" action="{{ route('users.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                {{-- Search Keyword --}}
                <div class="sm:col-span-5 relative">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Cari nama atau email akun..."
                           class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-slate-700">
                </div>

                {{-- Filter Role --}}
                <div class="sm:col-span-3">
                    <select name="role" class="w-full py-2 text-xs rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-slate-700">
                        <option value="">Semua Peran / Role</option>
                        <option value="superadmin" {{ $roleFilter === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="rw" {{ $roleFilter === 'rw' ? 'selected' : '' }}>Pengurus RW</option>
                        <option value="pkk" {{ $roleFilter === 'pkk' ? 'selected' : '' }}>Kader TP-PKK</option>
                    </select>
                </div>

                {{-- Filter RW --}}
                <div class="sm:col-span-2">
                    <select name="rw" class="w-full py-2 text-xs rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 text-slate-700">
                        <option value="">Semua RW</option>
                        @for($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ (string)$rwFilter === (string)$i ? 'selected' : '' }}>RW {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="sm:col-span-2 flex items-center gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold shadow-sm transition">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    @if($search || $roleFilter || $rwFilter)
                        <a href="{{ route('users.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold transition" title="Reset Filter">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- ─── TABEL PENGGUNA ─── --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-4 w-12 text-center">No</th>
                            <th class="py-3.5 px-4">Pengguna</th>
                            <th class="py-3.5 px-4">Peran (Role)</th>
                            <th class="py-3.5 px-4">Wilayah / Tugas</th>
                            <th class="py-3.5 px-4 text-center">Berita Dibuat</th>
                            <th class="py-3.5 px-4">Terdaftar</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50/80 transition {{ $user->id === Auth::id() ? 'bg-emerald-50/30' : '' }}">
                                {{-- Nomor --}}
                                <td class="py-4 px-4 text-center text-slate-400 font-medium">
                                    {{ $users->firstItem() + $loop->index }}
                                </td>

                                {{-- User Info --}}
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs shrink-0
                                            @if($user->isSuperAdmin())
                                                bg-indigo-100 text-indigo-700 border border-indigo-200
                                            @elseif($user->isRw())
                                                bg-amber-100 text-amber-700 border border-amber-200
                                            @elseif($user->isPkk())
                                                bg-pink-100 text-pink-700 border border-pink-200
                                            @else
                                                bg-slate-100 text-slate-700 border border-slate-200
                                            @endif">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                <p class="font-bold text-slate-800 text-sm truncate">{{ $user->name }}</p>
                                                @if($user->id === Auth::id())
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                        Akun Anda
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-slate-400 text-xs mt-0.5 flex items-center gap-1">
                                                <i class="fas fa-envelope text-[10px]"></i> {{ $user->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Role Badge --}}
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if($user->isSuperAdmin())
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                            <i class="fas fa-shield-halved text-xs text-indigo-500"></i> Super Admin
                                        </span>
                                    @elseif($user->isRw())
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                            <i class="fas fa-map-location-dot text-xs text-amber-600"></i> Pengurus RW
                                        </span>
                                    @elseif($user->isPkk())
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-pink-50 text-pink-700 border border-pink-200">
                                            <i class="fas fa-hand-holding-heart text-xs text-pink-500"></i> Kader PKK
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                            <i class="fas fa-user text-xs text-slate-500"></i> Pengguna
                                        </span>
                                    @endif
                                </td>

                                {{-- Wilayah Tugas --}}
                                <td class="py-4 px-4 whitespace-nowrap text-slate-600 font-medium">
                                    @if($user->isRw())
                                        <span class="inline-flex items-center gap-1 text-slate-700 font-bold">
                                            <i class="fas fa-location-dot text-amber-500 text-xs"></i>
                                            {{ $user->getRwLabel() ?? 'RW ?' }}
                                        </span>
                                    @elseif($user->isSuperAdmin())
                                        <span class="text-slate-500">Seluruh Desa Cigagade</span>
                                    @elseif($user->isPkk())
                                        <span class="text-slate-500">Tim PKK & Posyandu Desa</span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>

                                {{-- Berita Dibuat --}}
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-xl text-xs font-bold {{ $user->posts_count > 0 ? 'bg-slate-100 text-slate-700' : 'text-slate-400' }}">
                                        {{ $user->posts_count }}
                                    </span>
                                </td>

                                {{-- Terdaftar --}}
                                <td class="py-4 px-4 whitespace-nowrap text-slate-500 text-[11px]">
                                    {{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}
                                </td>

                                {{-- Aksi --}}
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        {{-- Tombol Edit / Reset Password --}}
                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 text-xs font-semibold border border-slate-200 hover:border-emerald-200 transition"
                                           title="Edit Akun & Password">
                                            <i class="fas fa-pen-to-square text-[11px]"></i> Edit
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        @if($user->id === Auth::id())
                                            <span class="inline-flex items-center px-2 py-1.5 rounded-lg bg-slate-50 text-slate-300 text-xs cursor-not-allowed" title="Tidak dapat menghapus akun Anda sendiri">
                                                <i class="fas fa-trash-can text-[11px]"></i>
                                            </span>
                                        @else
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun \'{{ $user->name }}\'?{{ $user->posts_count > 0 ? ' Pengguna ini memiliki ' . $user->posts_count . ' berita.' : '' }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-rose-50 text-slate-500 hover:text-rose-600 text-xs font-semibold border border-slate-200 hover:border-rose-200 transition"
                                                        title="Hapus Akun">
                                                    <i class="fas fa-trash-can text-[11px]"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mb-3">
                                            <i class="fas fa-users-slash"></i>
                                        </div>
                                        <h3 class="font-bold text-slate-700 text-base">Tidak ada akun yang ditemukan</h3>
                                        <p class="text-xs text-slate-400 mt-1 max-w-sm">
                                            Silakan sesuaikan kata kunci pencarian atau ubah filter role untuk menemukan akun.
                                        </p>
                                        <a href="{{ route('users.index') }}" class="mt-4 px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-bold">
                                            Reset Filter
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

    </div>
</x-app-layout>

