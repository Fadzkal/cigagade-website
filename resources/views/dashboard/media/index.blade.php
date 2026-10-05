<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Media</h2>
            <a href="{{ route('media.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-xs rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i> Tambah Media
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

            @if($mediaItems->isEmpty())
                <div class="text-center py-24 bg-white rounded-2xl border border-dashed border-gray-200">
                    <i class="fas fa-photo-video text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Media</h3>
                    <p class="text-gray-500 text-sm mb-6">Tambahkan media berupa gambar majalah atau link social media reel.</p>
                    <a href="{{ route('media.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-plus mr-2"></i> Tambah Sekarang
                    </a>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Media</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Tipe</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Judul</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Featured</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($mediaItems as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    @if($item->type === 'image' && $item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" class="w-20 h-14 object-cover rounded-lg border border-gray-100">
                                    @elseif($item->type === 'social')
                                        <div class="w-20 h-14 rounded-lg flex items-center justify-center bg-gradient-to-br
                                            {{ $item->platform === 'instagram' ? 'from-pink-500 to-purple-600' : ($item->platform === 'tiktok' ? 'from-gray-900 to-gray-700' : 'from-red-500 to-red-700') }}">
                                            <i class="fab fa-{{ $item->platform === 'instagram' ? 'instagram' : ($item->platform === 'tiktok' ? 'tiktok' : 'youtube') }} text-2xl text-white"></i>
                                        </div>
                                    @else
                                        <div class="w-20 h-14 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->type === 'image')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            <i class="fas fa-image mr-1"></i> Gambar
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                            {{ $item->platform === 'instagram' ? 'bg-pink-100 text-pink-700' : ($item->platform === 'tiktok' ? 'bg-gray-100 text-gray-700' : 'bg-red-100 text-red-700') }}">
                                            <i class="fab fa-{{ $item->platform }} mr-1"></i> {{ ucfirst($item->platform ?? 'social') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $item->title }}</p>
                                    @if($item->url)
                                        <a href="{{ $item->url }}" target="_blank" class="text-xs text-blue-500 hover:underline truncate block max-w-xs">{{ $item->url }}</a>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->is_featured)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                            <i class="fas fa-star mr-1"></i> Featured
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('media.edit', $item) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 font-semibold text-xs rounded-lg hover:bg-blue-100 transition">
                                            <i class="fas fa-pencil mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('media.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus media ini?')">
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
