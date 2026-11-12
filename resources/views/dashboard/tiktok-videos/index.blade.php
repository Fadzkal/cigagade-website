<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center shadow-sm">
                    <i class="fab fa-tiktok text-lg"></i>
                </div>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 leading-tight">
                        {{ __('Kelola TikTok Desa Cigagade') }}
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Atur video singkat TikTok yang tampil di beranda website desa</p>
                </div>
            </div>
            <a href="{{ route('tiktok-videos.create') }}" class="inline-flex items-center px-4 py-2 bg-slate-900 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-800 active:bg-black focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 shadow-sm transition ease-in-out duration-150">
                <i class="fas fa-plus mr-2"></i> Tambah Video TikTok
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-6 bg-white">
                    
                    @if(session('success'))
                        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2" role="alert">
                            <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($videos->isEmpty())
                        <div class="text-center py-16 text-gray-500">
                            <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                                <i class="fab fa-tiktok text-3xl"></i>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800 mb-1">Belum Ada Video TikTok</h3>
                            <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">Tambahkan video TikTok desa untuk menyapa warga dengan konten visual yang kreatif dan menarik.</p>
                            <a href="{{ route('tiktok-videos.create') }}" class="inline-flex items-center px-4 py-2 bg-slate-900 text-white rounded-lg text-xs font-semibold uppercase tracking-wider hover:bg-slate-800 transition">
                                <i class="fas fa-plus mr-1.5"></i> Tambah Video Pertama
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Urutan</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Thumbnail</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul & Tautan</th>
                                        <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($videos as $video)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-500">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-700 text-xs font-bold">
                                                {{ $video->order }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="h-20 w-12 rounded-xl overflow-hidden shadow-sm border border-gray-200 bg-black flex-shrink-0">
                                                <img class="h-full w-full object-cover" src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900 leading-snug">{{ $video->title }}</div>
                                            <div class="mt-1 flex items-center gap-2 text-xs">
                                                <a href="{{ $video->tiktok_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-slate-700 hover:text-black font-medium hover:underline">
                                                    <i class="fab fa-tiktok mr-1 text-[11px]"></i> Buka di TikTok
                                                    <i class="fas fa-external-link-alt ml-1 text-[9px] text-gray-400"></i>
                                                </a>
                                                @if($video->video_id)
                                                    <span class="text-gray-400">• ID: {{ $video->video_id }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($video->is_active)
                                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                                    <i class="fas fa-circle text-[8px] mr-1.5 self-center text-emerald-500"></i> Aktif (Tayang)
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-slate-100 text-slate-600">
                                                    <i class="fas fa-circle text-[8px] mr-1.5 self-center text-slate-400"></i> Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('tiktok-videos.edit', $video) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 text-xs font-semibold transition">
                                                    <i class="fas fa-edit mr-1"></i> Edit
                                                </a>
                                                <form action="{{ route('tiktok-videos.destroy', $video) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus video TikTok ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 text-xs font-semibold transition">
                                                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
