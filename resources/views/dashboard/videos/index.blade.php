<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Video YouTube</h2>
            <a href="{{ route('videos.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-xs rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i> Tambah Video
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            @if($videos->isEmpty())
                <div class="text-center py-24 bg-white rounded-2xl border border-dashed border-gray-200">
                    <i class="fab fa-youtube text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Video</h3>
                    <p class="text-gray-500 text-sm mb-6">Tambahkan video YouTube Anda sekarang.</p>
                    <a href="{{ route('videos.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-plus mr-2"></i> Tambah Sekarang
                    </a>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Thumbnail</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Judul</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Featured</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Tanggal Publish</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($videos as $video)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="relative w-24 h-16 rounded-lg overflow-hidden bg-gray-100">
                                        @if($video->thumbnail)
                                            <img src="{{ asset('storage/' . $video->thumbnail) }}" class="w-full h-full object-cover">
                                        @elseif($video->youtube_id)
                                            <img src="https://img.youtube.com/vi/{{ $video->youtube_id }}/mqdefault.jpg" class="w-full h-full object-cover">
                                        @else
                                            <div class="flex items-center justify-center w-full h-full"><i class="fab fa-youtube text-gray-400"></i></div>
                                        @endif
                                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                            <i class="fas fa-play text-white opacity-80 shadow-sm"></i>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $video->title }}</p>
                                    <a href="{{ $video->youtube_url }}" target="_blank" class="text-xs text-blue-500 hover:underline truncate block max-w-xs">{{ $video->youtube_url }}</a>
                                </td>
                                <td class="px-6 py-4">
                                    @if($video->is_featured)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                            <i class="fas fa-star mr-1"></i> Featured
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($video->published_at)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('videos.edit', $video) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 font-semibold text-xs rounded-lg hover:bg-blue-100 transition">
                                            <i class="fas fa-pencil mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('videos.destroy', $video) }}" method="POST" onsubmit="return confirm('Hapus video ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 font-semibold text-xs rounded-lg hover:bg-red-100 transition">
                                                <i class="fas fa-trash mr-1"></i> Hapus
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
</x-app-layout>
