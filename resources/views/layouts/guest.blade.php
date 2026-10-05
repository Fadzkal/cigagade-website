@php
    use App\Models\Setting;
    use Illuminate\Support\Facades\Storage;

    $settings = Setting::pluck('value', 'key');
    $logoPath = $settings['logo_path'] ?? null;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Desa Cigagade') }}</title>

        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23059669'><path d='M12 2L2 9.5V11H4V20H9V14H15V20H20V11H22V9.5L12 2Z'/></svg>">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-slate-50 dark:bg-slate-900 flex flex-col min-h-screen">

        <div class="flex-grow flex flex-col justify-center items-center p-6">
            {{-- Logo & Title --}}
            <div class="mb-10 text-center">
                <a href="/" class="inline-flex flex-col items-center gap-4 group">
                    <div class="w-16 h-16 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center shadow-sm border border-slate-200 dark:border-slate-700 group-hover:border-emerald-500 transition-colors">
                        @if ($logoPath && file_exists(public_path('storage/' . $logoPath)))
                            <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo Desa Cigagade" class="w-10 h-10 object-contain">
                        @else
                            <x-application-logo class="w-10 h-10 text-emerald-600 dark:text-emerald-400 fill-current" />
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Desa Cigagade</h1>
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Balubur Limbangan, Garut</p>
                    </div>
                </a>
            </div>

            {{-- Auth Card --}}
            <div class="w-full sm:max-w-md bg-white dark:bg-slate-800 shadow-xl sm:rounded-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-8 py-10">
                    <h2 class="text-2xl font-bold text-center text-slate-900 dark:text-white mb-8">
                        @if(request()->routeIs('login'))
                            Masuk ke Portal Admin
                        @elseif(request()->routeIs('register'))
                            Daftar Akun Baru
                        @elseif(request()->routeIs('password.request'))
                            Reset Password
                        @elseif(request()->routeIs('password.reset'))
                            Password Baru
                        @elseif(request()->routeIs('verification.notice') || request()->routeIs('verification.verify'))
                            Verifikasi Email
                        @else
                            Autentikasi
                        @endif
                    </h2>

                    {{ $slot }}
                </div>

                {{-- Footer Links inside card --}}
                <div class="bg-slate-50 dark:bg-slate-800/50 px-8 py-5 border-t border-slate-100 dark:border-slate-700">
                    <div class="text-center text-sm text-slate-600 dark:text-slate-400">
                        @if(request()->routeIs('login'))
                            <p>Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">Daftar di sini</a></p>
                        @elseif(request()->routeIs('register'))
                            <p>Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">Masuk di sini</a></p>
                        @elseif(request()->routeIs('password.request'))
                            <p>Ingat password? <a href="{{ route('login') }}" class="font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">Kembali ke login</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Page Footer --}}
        <div class="py-6 text-center text-sm text-slate-400 dark:text-slate-500">
            &copy; {{ date('Y') }} Pemerintah Desa Cigagade. Hak Cipta Dilindungi.
        </div>

    </body>
</html>
