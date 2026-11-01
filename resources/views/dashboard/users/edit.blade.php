<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('users.index') }}" class="hover:text-emerald-600 transition">Manajemen Pengguna</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-slate-800 font-semibold">Edit Akun</span>
                </div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Edit Akun: <span class="text-emerald-600">{{ $user->name }}</span>
                </h2>
            </div>
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:text-emerald-600 text-xs font-bold shadow-sm transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-2">

        {{-- Flash Alerts --}}
        @if(session('error'))
            <div class="mb-4 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <i class="fas fa-circle-exclamation text-rose-600 text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800 text-base">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @php
            $currentRole = old('role', $user->role ?? 'rw');
            if ($currentRole === 'kader_pkk') { $currentRole = 'pkk'; }
            if (!in_array($currentRole, ['superadmin', 'rw', 'pkk'])) {
                $currentRole = $user->isRw() ? 'rw' : ($user->isPkk() ? 'pkk' : 'superadmin');
            }
        @endphp

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8"
             x-data="{ role: '{{ $currentRole }}' }">

            <div class="border-b border-slate-100 pb-5 mb-6 flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h3 class="font-bold text-lg text-slate-800">Perbarui Informasi & Kredensial</h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Ubah data profil atau reset password akun ini jika pengguna lupa kata sandi.
                    </p>
                </div>

                {{-- Status Tag --}}
                @if($user->id === Auth::id())
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                        <i class="fas fa-user-check"></i> Ini Adalah Akun Anda Sendiri
                    </span>
                @endif
            </div>

            <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama Pengguna --}}
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Nama Lengkap / Instansi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                           placeholder="Contoh: Pengurus RW 01 Desa Cigagade"
                           class="w-full rounded-xl border-slate-200 text-xs sm:text-sm focus:border-emerald-500 focus:ring-emerald-500 @error('name') border-rose-300 ring-rose-200 @enderror"
                           required>
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                            <i class="fas fa-circle-exclamation text-[11px]"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email Pengguna --}}
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Alamat Email Resmi <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                placeholder="Contoh: rw01@desacigagade.id"
                                class="w-full pl-9 rounded-xl border-slate-200 text-xs sm:text-sm focus:border-emerald-500 focus:ring-emerald-500 @error('email') border-rose-300 ring-rose-200 @enderror"
                                required>
                    </div>
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                            <i class="fas fa-circle-exclamation text-[11px]"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Role / Peran --}}
                <div class="pt-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">
                        Peran Hak Akses (Role) <span class="text-rose-500">*</span>
                    </label>

                    @if($user->id === Auth::id())
                        <div class="p-3.5 rounded-2xl bg-indigo-50/60 border border-indigo-200 flex items-center gap-3">
                            <i class="fas fa-shield-halved text-indigo-600 text-lg"></i>
                            <div>
                                <p class="text-xs font-bold text-indigo-900">Peran: Super Administrator</p>
                                <p class="text-[11px] text-indigo-700">Untuk keamanan sistem, Anda tidak dapat mengubah peran akun Anda sendiri saat sedang login.</p>
                            </div>
                            <input type="hidden" name="role" value="superadmin">
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            {{-- Super Admin --}}
                            <div>
                                <input type="radio" name="role" id="role_superadmin" value="superadmin"
                                       x-model="role"
                                       {{ $currentRole === 'superadmin' ? 'checked' : '' }}
                                       onchange="window.updateUserRole && window.updateUserRole(this.value)"
                                       class="sr-only peer">
                                <label for="role_superadmin"
                                       class="relative flex flex-col p-4 rounded-2xl border cursor-pointer transition select-none h-full border-slate-200 bg-white hover:border-slate-300 peer-checked:border-indigo-500 peer-checked:bg-indigo-50/40 peer-checked:ring-2 peer-checked:ring-indigo-500/20"
                                       :class="role === 'superadmin' ? 'border-indigo-500 bg-indigo-50/40 ring-2 ring-indigo-500/20' : 'border-slate-200 hover:border-slate-300 bg-white'">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-bold">
                                            <i class="fas fa-shield-halved"></i>
                                        </span>
                                        <i class="fas fa-circle-check text-indigo-600 text-sm {{ $currentRole === 'superadmin' ? '' : 'hidden' }}"
                                           :class="{ 'hidden': role !== 'superadmin' }"
                                           x-show="role === 'superadmin'" x-cloak></i>
                                    </div>
                                    <span class="text-xs font-bold text-slate-800">Super Admin</span>
                                    <span class="text-[11px] text-slate-500 mt-1 leading-snug">Akses seluruh modul & data desa.</span>
                                </label>
                            </div>

                            {{-- Akun RW --}}
                            <div>
                                <input type="radio" name="role" id="role_rw" value="rw"
                                       x-model="role"
                                       {{ $currentRole === 'rw' ? 'checked' : '' }}
                                       onchange="window.updateUserRole && window.updateUserRole(this.value)"
                                       class="sr-only peer">
                                <label for="role_rw"
                                       class="relative flex flex-col p-4 rounded-2xl border cursor-pointer transition select-none h-full border-slate-200 bg-white hover:border-slate-300 peer-checked:border-amber-500 peer-checked:bg-amber-50/40 peer-checked:ring-2 peer-checked:ring-amber-500/20"
                                       :class="role === 'rw' ? 'border-amber-500 bg-amber-50/40 ring-2 ring-amber-500/20' : 'border-slate-200 hover:border-slate-300 bg-white'">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm font-bold">
                                            <i class="fas fa-map-location-dot"></i>
                                        </span>
                                        <i class="fas fa-circle-check text-amber-600 text-sm {{ $currentRole === 'rw' ? '' : 'hidden' }}"
                                           :class="{ 'hidden': role !== 'rw' }"
                                           x-show="role === 'rw'" x-cloak></i>
                                    </div>
                                    <span class="text-xs font-bold text-slate-800">Pengurus RW</span>
                                    <span class="text-[11px] text-slate-500 mt-1 leading-snug">Kelola publikasi kabar wilayah RW.</span>
                                </label>
                            </div>

                            {{-- Kader PKK --}}
                            <div>
                                <input type="radio" name="role" id="role_pkk" value="pkk"
                                       x-model="role"
                                       {{ $currentRole === 'pkk' ? 'checked' : '' }}
                                       onchange="window.updateUserRole && window.updateUserRole(this.value)"
                                       class="sr-only peer">
                                <label for="role_pkk"
                                       class="relative flex flex-col p-4 rounded-2xl border cursor-pointer transition select-none h-full border-slate-200 bg-white hover:border-slate-300 peer-checked:border-pink-500 peer-checked:bg-pink-50/40 peer-checked:ring-2 peer-checked:ring-pink-500/20"
                                       :class="role === 'pkk' ? 'border-pink-500 bg-pink-50/40 ring-2 ring-pink-500/20' : 'border-slate-200 hover:border-slate-300 bg-white'">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="w-8 h-8 rounded-xl bg-pink-100 text-pink-700 flex items-center justify-center text-sm font-bold">
                                            <i class="fas fa-hand-holding-heart"></i>
                                        </span>
                                        <i class="fas fa-circle-check text-pink-600 text-sm {{ $currentRole === 'pkk' ? '' : 'hidden' }}"
                                           :class="{ 'hidden': role !== 'pkk' }"
                                           x-show="role === 'pkk'" x-cloak></i>
                                    </div>
                                    <span class="text-xs font-bold text-slate-800">Kader TP-PKK</span>
                                    <span class="text-[11px] text-slate-500 mt-1 leading-snug">Publikasi posyandu & kegiatan PKK.</span>
                                </label>
                            </div>
                        </div>
                    @endif
                    @error('role')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                            <i class="fas fa-circle-exclamation text-[11px]"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Nomor RW (Hanya muncul dan aktif jika Role RW dipilih) --}}
                <div id="rw-select-container"
                     x-show="role === 'rw'"
                     x-cloak
                     class="p-4 rounded-2xl bg-amber-50/50 border border-amber-200 transition-all {{ $currentRole !== 'rw' ? 'hidden' : '' }}">
                    <label for="rw" class="block text-xs font-bold text-amber-900 uppercase tracking-wider mb-2">
                        Pilih Wilayah RW <span class="text-rose-500">*</span>
                    </label>
                    <select name="rw" id="rw" {{ $currentRole !== 'rw' ? 'disabled' : '' }}
                            class="w-full rounded-xl border-amber-300 text-xs sm:text-sm focus:border-amber-500 focus:ring-amber-500 text-slate-800">
                        <option value="">-- Pilih Nomor RW (01 s/d 10) --</option>
                        @for($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ (string)old('rw', $user->rw) === (string)$i ? 'selected' : '' }}>
                                RW {{ str_pad($i, 2, '0', STR_PAD_LEFT) }} - Rukun Warga {{ str_pad($i, 2, '0', STR_PAD_LEFT) }} Desa Cigagade
                            </option>
                        @endfor
                    </select>
                    @error('rw')
                        <p class="text-rose-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                            <i class="fas fa-circle-exclamation text-[11px]"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Ubah Password (Opsional) --}}
                <div class="pt-4 border-t border-slate-100">
                    <div class="mb-4">
                        <h4 class="font-bold text-sm text-slate-800 flex items-center gap-2">
                            <i class="fas fa-key text-emerald-600"></i> Ganti Password Akun (Opsional)
                        </h4>
                        <p class="text-xs text-slate-500 mt-1">
                            Biarkan kolom di bawah <strong>kosong</strong> jika Anda tidak berniat mengubah password akun ini.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Password Baru (Opsional)
                            </label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                <input type="password" name="password" id="password"
                                       placeholder="Kosongkan jika tidak diubah"
                                       class="w-full pl-9 rounded-xl border-slate-200 text-xs sm:text-sm focus:border-emerald-500 focus:ring-emerald-500 @error('password') border-rose-300 ring-rose-200 @enderror">
                            </div>
                            @error('password')
                                <p class="text-rose-500 text-xs mt-1.5 font-medium flex items-center gap-1">
                                    <i class="fas fa-circle-exclamation text-[11px]"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Konfirmasi Password Baru
                            </label>
                            <div class="relative">
                                <i class="fas fa-check-double absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       placeholder="Ulangi password baru"
                                       class="w-full pl-9 rounded-xl border-slate-200 text-xs sm:text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Metadata Info --}}
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs text-slate-500 space-y-1.5">
                    <p><i class="fas fa-calendar-plus text-slate-400 mr-1.5"></i> Dibuat pada: <strong>{{ $user->created_at ? $user->created_at->translatedFormat('d F Y H:i') : '-' }}</strong></p>
                    <p><i class="fas fa-newspaper text-slate-400 mr-1.5"></i> Berita yang telah dipublikasikan: <strong>{{ $user->posts()->count() }} Berita</strong></p>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('users.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                        <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        function updateUserRole(val) {
            var container = document.getElementById('rw-select-container');
            var select = document.getElementById('rw');
            if (container && select) {
                if (val === 'rw') {
                    container.classList.remove('hidden');
                    container.style.display = 'block';
                    select.disabled = false;
                } else {
                    container.classList.add('hidden');
                    container.style.display = 'none';
                    select.disabled = true;
                }
            }
        }
    </script>
</x-app-layout>

