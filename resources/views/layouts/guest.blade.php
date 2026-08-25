<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIPMAS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    {{-- google fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gama-bg">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div
            class="w-full max-w-6xl bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden flex flex-col md:flex-row">

            <!-- Panel Kiri: Branding -->
            <div
                class="w-full md:w-5/12 bg-gama-primary p-8 md:p-12 flex flex-col items-center justify-center text-center text-white relative">
                <!-- Dekorasi -->
                <div
                    class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgdmlld0JveD0iMCAwIDYwIDYwIj48cGF0aCBkPSJNMzAgMTBhMjAgMjAgMCAwIDEtMjAgMjAgMjAgMjAgMCAwIDEtMjAtMjAgMjAgMjAgMCAwIDEgMjAtMjAgMjAgMjAgMCAwIDEgMjAgMjB6IiBmaWxsPSIjZmZmIiBmaWxsLW9wYWNpdHk9IjAuMDYiLz48L3N2Zz4=')] opacity-20">
                </div>

                <div class="relative z-10 space-y-6">
                    <!-- Logo -->
                    <div class="flex justify-center gap-4">
                        <div
                            class="bg-white/10 backdrop-blur-sm rounded-full p-2 w-20 h-20 flex items-center justify-center">
                            <img src="{{ asset('img/logo-galma.png') }}" alt="Logo Kelurahan"
                                class="w-full h-full object-contain rounded-full">
                        </div>
                        <div
                            class="bg-white/10 backdrop-blur-sm rounded-lg p-2 w-20 h-20 flex items-center justify-center">
                            <img src="{{ asset('img/logo-ith.png') }}" alt="Logo Kampus"
                                class="w-full h-full object-contain">
                        </div>
                    </div>

                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold tracking-tight">SIPMAS</h1>
                        <p class="text-gama-secondary text-sm md:text-base mt-2 opacity-90">Sistem Informasi Pelayanan
                            Masyarakat Kelurahan Galung Maloang</p>
                    </div>

                    <div class="w-12 h-1 bg-gama-gold mx-auto rounded-full"></div>

                    <p class="text-xs text-gama-secondary/70 mt-4 max-w-xs mx-auto">
                        Melayani administrasi surat secara digital untuk masyarakat Kelurahan Galung Maloang
                    </p>
                </div>
            </div>

            <!-- Panel Kanan: Form -->
            <div class="w-full md:w-7/12 p-8 md:p-12 flex items-center">
                <div class="w-full max-w-sm mx-auto">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </div>
</body>

</html>
