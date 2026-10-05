<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight">
                {{ __('Edit Teks Berjalan') }}
            </h2>
            <a href="{{ route('running-texts.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition">
                <i class="fas fa-arrow-left mr-1.5"></i>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                
                <form action="{{ route('running-texts.update', $runningText->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="text" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                            Isi Pesan / Pengumuman <span class="text-red-500">*</span>
                        </label>
                        <textarea name="text" id="text" rows="4" required
                                  class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">{{ old('text', $runningText->text) }}</textarea>
                        @error('text')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                            Tautan / Link URL (Opsional)
                        </label>
                        <input type="text" name="url" id="url" value="{{ old('url', $runningText->url) }}"
                               placeholder="Contoh: /infografis atau https://..."
                               class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                        <p class="text-xs text-slate-400 mt-1">Kosongkan jika hanya berupa teks pengumuman tanpa tautan.</p>
                        @error('url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="badge" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                                Badge Label
                            </label>
                            <input type="text" name="badge" id="badge" value="{{ old('badge', $runningText->badge ?? 'INFO') }}"
                                   class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                        </div>
                        <div>
                            <label for="order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                                Urutan
                            </label>
                            <input type="number" name="order" id="order" value="{{ old('order', $runningText->order) }}"
                                   class="w-full text-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $runningText->is_active) ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Teks Sedang Aktif (Tampil di Website)</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-sm transition">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('running-texts.index') }}" class="px-5 py-2.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 font-semibold text-xs rounded-xl transition">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
