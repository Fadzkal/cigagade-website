<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
                Dashboard <span class="text-indigo-600">Statistik</span>
            </h2>
            <div class="text-sm text-gray-500 font-medium bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100">
                <i class="fas fa-calendar-alt mr-2 text-indigo-500"></i> {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ─── Summary Cards ─────────────────────────────────────────── --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4">
                @php
                    $cards = [
                        ['label' => 'Total Artikel',    'value' => $totalPosts,      'icon' => 'fa-newspaper',  'color' => 'blue',    'link' => route('posts.index')],
                        ['label' => 'Total Views',      'value' => number_format($totalViews), 'icon' => 'fa-eye', 'color' => 'indigo',  'link' => null],
                        ['label' => 'Produk UMKM',      'value' => $totalUmkm,       'icon' => 'fa-store',      'color' => 'emerald', 'link' => route('umkm.admin.index')],
                        ['label' => 'Kategori',         'value' => $totalCategories, 'icon' => 'fa-tags',       'color' => 'purple',  'link' => route('categories.index')],
                        ['label' => 'Galeri Desa',      'value' => $totalGalleries,  'icon' => 'fa-images',     'color' => 'pink',    'link' => route('galleries.index')],
                        ['label' => 'Perangkat Desa',   'value' => $totalMinistries, 'icon' => 'fa-users-gear', 'color' => 'orange',  'link' => route('ministries.index')],
                        ['label' => 'Mitra & Instansi', 'value' => $totalPartners,   'icon' => 'fa-handshake',  'color' => 'green',   'link' => route('partners.index')],
                    ];
                    $colorMap = [
                        'blue'   => ['bg' => 'bg-blue-50',   'icon' => 'bg-blue-100 text-blue-600',   'val' => 'text-blue-700',   'border' => 'border-blue-100'],
                        'indigo' => ['bg' => 'bg-indigo-50', 'icon' => 'bg-indigo-100 text-indigo-600','val' => 'text-indigo-700', 'border' => 'border-indigo-100'],
                        'emerald'=> ['bg' => 'bg-emerald-50','icon' => 'bg-emerald-100 text-emerald-600','val' => 'text-emerald-700','border' => 'border-emerald-100'],
                        'purple' => ['bg' => 'bg-purple-50', 'icon' => 'bg-purple-100 text-purple-600','val' => 'text-purple-700', 'border' => 'border-purple-100'],
                        'pink'   => ['bg' => 'bg-pink-50',   'icon' => 'bg-pink-100 text-pink-600',   'val' => 'text-pink-700',   'border' => 'border-pink-100'],
                        'orange' => ['bg' => 'bg-orange-50', 'icon' => 'bg-orange-100 text-orange-600','val' => 'text-orange-700', 'border' => 'border-orange-100'],
                        'green'  => ['bg' => 'bg-green-50',  'icon' => 'bg-green-100 text-green-600',  'val' => 'text-green-700',  'border' => 'border-green-100'],
                    ];
                @endphp
                @foreach($cards as $card)
                @php $c = $colorMap[$card['color']]; @endphp
                <{{ $card['link'] ? 'a href=' . $card['link'] : 'div' }} class="relative overflow-hidden rounded-2xl p-5 {{ $c['bg'] }} border {{ $c['border'] }} shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 flex flex-col gap-3 group {{ $card['link'] ? 'cursor-pointer' : '' }}">
                    <!-- Decorative background element -->
                    <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full opacity-40 {{ $c['icon'] }} blur-2xl group-hover:blur-xl transition-all duration-300"></div>
                    
                    <div class="relative w-12 h-12 rounded-xl flex items-center justify-center {{ $c['icon'] }} shadow-inner">
                        <i class="fas {{ $card['icon'] }} text-lg"></i>
                    </div>
                    <div class="relative mt-1">
                        <p class="text-sm text-gray-500 font-semibold mb-1">{{ $card['label'] }}</p>
                        <p class="text-3xl font-black {{ $c['val'] }} tracking-tight">{{ $card['value'] }}</p>
                    </div>
                </{{ $card['link'] ? 'a' : 'div' }}>
                @endforeach
            </div>

            {{-- ─── Charts Row ─────────────────────────────────────────────── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Posts per Category Chart --}}
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                <i class="fas fa-chart-bar text-sm"></i>
                            </div>
                            Artikel per Kategori
                        </h3>
                    </div>
                    <div class="relative h-[250px]">
                        <canvas id="chartPostsByCategory"></canvas>
                    </div>
                </div>

                {{-- Views per Category Chart --}}
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center">
                                <i class="fas fa-chart-pie text-sm"></i>
                            </div>
                            Views per Kategori
                        </h3>
                    </div>
                    <div class="relative h-[250px] flex justify-center">
                        <canvas id="chartViewsByCategory"></canvas>
                    </div>
                </div>

            </div>

            {{-- ─── Tables Row ─────────────────────────────────────────────── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Top 10 Popular Posts --}}
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 flex flex-col">
                    <div class="p-6 border-b border-gray-50">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center">
                                <i class="fas fa-fire text-sm"></i>
                            </div>
                            Top 10 Artikel Terpopuler
                        </h3>
                    </div>
                    <div class="overflow-x-auto flex-1 p-2">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 bg-gray-50/50">
                                    <th class="text-center py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-lg">Rank</th>
                                    <th class="text-left py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="text-left py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="text-right py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tr-lg">Views</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($popularPosts as $i => $post)
                                <tr class="hover:bg-indigo-50/30 transition-colors group">
                                    <td class="py-3 px-4">
                                        @php
                                            $rankBadge = match($i) {
                                                0 => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                                1 => 'bg-gray-200 text-gray-700 border-gray-300',
                                                2 => 'bg-orange-100 text-orange-800 border-orange-200',
                                                default => 'bg-slate-50 text-slate-500 border-slate-100'
                                            };
                                        @endphp
                                        <div class="w-7 h-7 mx-auto rounded-full border flex items-center justify-center font-bold text-xs {{ $rankBadge }} shadow-sm">
                                            {{ $i + 1 }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('berita.show', $post->slug) }}" target="_blank"
                                           class="text-gray-700 font-semibold group-hover:text-indigo-600 transition-colors line-clamp-1">
                                            {{ $post->title }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-indigo-50 text-indigo-600 border border-indigo-100">
                                            {{ $post->category->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <i class="fas fa-eye text-gray-300 text-[10px]"></i>
                                            <span class="font-bold text-gray-700">{{ number_format($post->views) }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="py-8 text-center text-gray-400 text-sm">Belum ada data views.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Latest 5 Posts --}}
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 flex flex-col">
                    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center">
                                <i class="fas fa-clock text-sm"></i>
                            </div>
                            Artikel Terbaru
                        </h3>
                    </div>
                    <div class="overflow-x-auto flex-1 p-2">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100 bg-gray-50/50">
                                    <th class="text-left py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider rounded-tl-lg">Judul</th>
                                    <th class="text-left py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Penulis</th>
                                    <th class="text-right py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($latestPosts as $post)
                                <tr class="hover:bg-emerald-50/30 transition-colors group">
                                    <td class="py-3 px-4">
                                        <a href="{{ route('berita.show', $post->slug) }}" target="_blank"
                                           class="text-gray-700 font-semibold group-hover:text-emerald-600 transition-colors line-clamp-1 block mb-0.5">
                                            {{ $post->title }}
                                        </a>
                                        <span class="text-[11px] text-gray-400 flex items-center gap-1">
                                            <i class="fas fa-tag text-[9px]"></i> {{ $post->category->name ?? 'Tanpa Kategori' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-500 text-[10px]">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <span class="text-gray-600 text-xs font-medium">{{ $post->user->name ?? 'Admin' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <span class="text-gray-500 text-xs font-medium whitespace-nowrap bg-gray-50 px-2 py-1 rounded-md border border-gray-100">
                                            {{ ($post->published_at ?? $post->created_at)->format('d M Y') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="py-8 text-center text-gray-400 text-sm">Belum ada artikel.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Footer Action --}}
                    <div class="p-4 border-t border-gray-50 bg-gray-50/50 rounded-b-2xl text-center">
                        <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-800 bg-white hover:bg-indigo-50 px-4 py-2 rounded-lg border border-indigo-100 shadow-sm transition-all">
                            Kelola Semua Artikel <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- ─── Chart.js ─────────────────────────────────────────────────── --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Set default font to standard sans-serif
        Chart.defaults.font.family = "'Inter', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif";
        Chart.defaults.color = '#64748b';

        // Posts per Category
        const postLabels  = @json($postsByCategory->pluck('name'));
        const postCounts  = @json($postsByCategory->pluck('posts_count'));

        new Chart(document.getElementById('chartPostsByCategory'), {
            type: 'bar',
            data: {
                labels: postLabels,
                datasets: [{
                    label: 'Jumlah Artikel',
                    data: postCounts,
                    backgroundColor: 'rgba(99, 102, 241, 0.85)', // Indigo-500
                    hoverBackgroundColor: 'rgba(79, 70, 229, 1)', // Indigo-600
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        padding: 12,
                        titleFont: { size: 13 },
                        bodyFont: { size: 14, weight: 'bold' },
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { stepSize: 1, padding: 10 }, 
                        grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false } 
                    },
                    x: { 
                        grid: { display: false, drawBorder: false },
                        ticks: { padding: 10 }
                    }
                }
            }
        });

        // Views per Category
        const viewLabels  = @json($viewsByCategory->pluck('name'));
        const viewCounts  = @json($viewsByCategory->pluck('total_views'));
        const bgColors = [
            'rgba(99, 102, 241, 0.85)',  // Indigo
            'rgba(236, 72, 153, 0.85)',  // Pink
            'rgba(16, 185, 129, 0.85)',  // Emerald
            'rgba(245, 158, 11, 0.85)',  // Amber
            'rgba(239, 68, 68, 0.85)',   // Red
            'rgba(59, 130, 246, 0.85)',  // Blue
            'rgba(168, 85, 247, 0.85)',  // Purple
            'rgba(20, 184, 166, 0.85)',  // Teal
        ];

        new Chart(document.getElementById('chartViewsByCategory'), {
            type: 'doughnut',
            data: {
                labels: viewLabels,
                datasets: [{
                    data: viewCounts,
                    backgroundColor: bgColors,
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: { 
                        position: 'right', 
                        labels: { 
                            font: { size: 12 }, 
                            padding: 16,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        } 
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        padding: 12,
                        cornerRadius: 8
                    }
                }
            }
        });
    </script>
</x-app-layout>