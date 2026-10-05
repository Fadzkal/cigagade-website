@php
    $settings = \App\Models\Setting::pluck('value', 'key');
    $logo = $settings['logo_path'] ?? null;
@endphp

@if ($logo && file_exists(public_path('storage/' . $logo)))
    <img src="{{ asset('storage/' . $logo) }}" alt="Logo Kabupaten Garut - Desa Cigagade" {{ $attributes->merge(['class' => 'h-10 w-auto object-contain drop-shadow-sm']) }}>
@elseif (file_exists(public_path('images/LOGO_GARUT.png')))
    <img src="{{ asset('images/LOGO_GARUT.png') }}" alt="Logo Kabupaten Garut - Desa Cigagade" {{ $attributes->merge(['class' => 'h-10 w-auto object-contain drop-shadow-sm']) }}>
@else
    <svg {{ $attributes->merge(['class' => 'h-10 w-10 text-emerald-600', 'viewBox' => '0 0 40 40', 'fill' => 'none', 'xmlns' => 'http://www.w3.org/2000/svg']) }}>
        <rect width="40" height="40" rx="10" fill="currentColor" fill-opacity="0.15" />
        <rect x="0.5" y="0.5" width="39" height="39" rx="9.5" stroke="currentColor" stroke-opacity="0.35" />
        <path d="M20 8L7 15V17H33V15L20 8Z" fill="currentColor" />
        <rect x="10" y="19" width="3" height="10" rx="1" fill="currentColor" />
        <rect x="16" y="19" width="3" height="10" rx="1" fill="currentColor" />
        <rect x="21" y="19" width="3" height="10" rx="1" fill="currentColor" />
        <rect x="27" y="19" width="3" height="10" rx="1" fill="currentColor" />
        <rect x="6" y="30" width="28" height="3" rx="1" fill="currentColor" />
    </svg>
@endif
