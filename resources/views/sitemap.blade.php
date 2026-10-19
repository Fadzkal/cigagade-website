{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    {{-- ─── 1. Halaman Utama (Beranda) beserta Semua Gambar Galeri, Hero, Banner, Perangkat Desa ─── --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>

        {{-- Logo Desa --}}
        @if(!empty($settings['logo_path']) && file_exists(public_path('storage/' . $settings['logo_path'])))
        <image:image>
            <image:loc>{{ asset('storage/' . $settings['logo_path']) }}</image:loc>
            <image:title>Logo Resmi Pemerintah Desa Cigagade</image:title>
            <image:caption>Logo resmi Pemerintah Desa Cigagade, Kecamatan Balubur Limbangan, Kabupaten Garut</image:caption>
        </image:image>
        @elseif(file_exists(public_path('images/LOGO_GARUT.png')))
        <image:image>
            <image:loc>{{ asset('images/LOGO_GARUT.png') }}</image:loc>
            <image:title>Logo Resmi Pemerintah Desa Cigagade</image:title>
            <image:caption>Logo resmi Pemerintah Desa Cigagade, Kecamatan Balubur Limbangan, Kabupaten Garut</image:caption>
        </image:image>
        @endif

        {{-- Gambar Profil / Tentang Desa --}}
        @if(!empty($settings['about_image']) && file_exists(public_path('storage/' . $settings['about_image'])))
        <image:image>
            <image:loc>{{ asset('storage/' . $settings['about_image']) }}</image:loc>
            <image:title>{{ $settings['about_title'] ?? 'Profil dan Pesona Desa Cigagade' }}</image:title>
            <image:caption>{{ Str::limit(strip_tags($settings['about_description'] ?? 'Pemandangan dan profil keindahan Desa Cigagade Balubur Limbangan Garut'), 200) }}</image:caption>
        </image:image>
        @endif

        {{-- Hero Slides --}}
        @foreach($heroSlides as $slide)
            @if($slide->image && file_exists(public_path('storage/' . $slide->image)))
            <image:image>
                <image:loc>{{ asset('storage/' . $slide->image) }}</image:loc>
                <image:title>{{ $slide->title ?: 'Dokumentasi Visual Desa Cigagade' }}</image:title>
                <image:caption>{{ $slide->subtitle ?: $slide->title ?: 'Dokumentasi kegiatan dan pesona Desa Cigagade' }}</image:caption>
            </image:image>
            @endif
        @endforeach

        {{-- Galeri Foto Desa --}}
        @foreach($galleries as $gallery)
            @if($gallery->image && file_exists(public_path('storage/' . $gallery->image)))
            <image:image>
                <image:loc>{{ asset('storage/' . $gallery->image) }}</image:loc>
                <image:title>{{ $gallery->title ?: 'Dokumentasi Galeri Kegiatan Desa Cigagade' }}</image:title>
                <image:caption>{{ $gallery->title ?: 'Dokumentasi kegiatan masyarakat dan pemerintahan Desa Cigagade, Balubur Limbangan, Garut' }}</image:caption>
            </image:image>
            @endif
        @endforeach

        {{-- Landscape Banners --}}
        @foreach($banners as $banner)
            @if($banner->image && file_exists(public_path('storage/' . $banner->image)))
            <image:image>
                <image:loc>{{ asset('storage/' . $banner->image) }}</image:loc>
                <image:title>{{ $banner->title ?: 'Banner Informasi Desa Cigagade' }}</image:title>
                <image:caption>{{ $banner->title ?: 'Informasi dan pengumuman visual Desa Cigagade' }}</image:caption>
            </image:image>
            @endif
        @endforeach

        {{-- Aparatur & Perangkat Desa --}}
        @foreach($ministries as $ministry)
            @if($ministry->image && file_exists(public_path('storage/' . $ministry->image)))
            <image:image>
                <image:loc>{{ asset('storage/' . $ministry->image) }}</image:loc>
                <image:title>{{ $ministry->name }} - {{ $ministry->position }} Desa Cigagade</image:title>
                <image:caption>Aparatur Pemerintah Desa Cigagade: {{ $ministry->name }}, Jabatan {{ $ministry->position }}</image:caption>
            </image:image>
            @endif
        @endforeach
    </url>

    {{-- ─── 2. Halaman Indeks Publik ─── --}}
    <url>
        <loc>{{ route('berita.index') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>

    <url>
        <loc>{{ route('umkm.index') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>

    <url>
        <loc>{{ route('infografis.index') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ route('prestasi-pengumuman') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <url>
        <loc>{{ route('video.index') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

    <url>
        <loc>{{ route('bengkel-ilmu.list') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    {{-- ─── 3. Detail Setiap Berita, Pengumuman, dan Prestasi Beserta Gambarnya ─── --}}
    @foreach($posts as $post)
        @php
            $postUrl = url($post->getShowRoute());
            $imgUrl = asset('storage/' . $post->image);
            $postTitle = $post->getTitle();
            $postExcerpt = $post->getExcerpt() ?: Str::limit(strip_tags($post->getContent()), 200);
            $lastMod = ($post->updated_at ?? $post->created_at ?? now())->toAtomString();
        @endphp
        <url>
            <loc>{{ $postUrl }}</loc>
            <lastmod>{{ $lastMod }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.85</priority>
            @if($post->image && file_exists(public_path('storage/' . $post->image)))
            <image:image>
                <image:loc>{{ $imgUrl }}</image:loc>
                <image:title>{{ $postTitle }} - Berita Desa Cigagade</image:title>
                <image:caption>{{ $postExcerpt }}</image:caption>
            </image:image>
            @endif
        </url>
    @endforeach

    {{-- ─── 4. Detail Setiap Produk UMKM Beserta Gambarnya ─── --}}
    @foreach($umkms as $umkm)
        @php
            $umkmUrl = route('umkm.show', $umkm->slug);
            $umkmImg = $umkm->image_url;
            $umkmTitle = $umkm->name . ' - Produk UMKM Desa Cigagade';
            $umkmDesc = !empty($umkm->description) ? Str::limit(strip_tags($umkm->description), 200) : ('Produk UMKM Unggulan ' . $umkm->name . ' kategori ' . $umkm->category . ' Desa Cigagade');
            $lastMod = ($umkm->updated_at ?? $umkm->created_at ?? now())->toAtomString();
        @endphp
        <url>
            <loc>{{ $umkmUrl }}</loc>
            <lastmod>{{ $lastMod }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.85</priority>
            <image:image>
                <image:loc>{{ $umkmImg }}</image:loc>
                <image:title>{{ $umkmTitle }}</image:title>
                <image:caption>{{ $umkmDesc }}</image:caption>
            </image:image>
        </url>
    @endforeach

</urlset>
