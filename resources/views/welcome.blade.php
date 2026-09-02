<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIPMAS Galung Maloang</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gama-bg">

    <!-- HERO SECTION -->
    <section class="relative overflow-hidden bg-gama-primary">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-gama-gold rounded-full blur-3xl -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-gama-accent rounded-full blur-3xl -ml-20 -mb-20"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8  py-10 md:py-28">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Kiri -->
                <div class="text-white">
                    <div class="inline-flex items-center px-4 py-1.5 bg-white/20 rounded-full text-sm mb-6">
                        <span class="w-2 h-2 bg-gama-gold rounded-full mr-2"></span>
                        Pelayanan Digital Kelurahan Galung Maloang
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
                        Ajukan Surat <br class="hidden sm:block">
                        <span class="text-gama-gold">Tanpa Datang ke Kelurahan</span>
                    </h1>
                    <p class="text-lg text-white/80 mb-8 max-w-lg">
                        SIPMAS Galung Maloang memudahkan Anda mengajukan administrasi surat secara online.
                        Data dan dokumen tersimpan, sehingga tidak perlu upload ulang setiap kali mengajukan.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}"
                            class="px-6 py-3 bg-gama-accent hover:bg-[#4a9e4a] text-white font-semibold rounded-lg transition shadow-lg shadow-gama-accent/30">
                            Mulai Ajukan Surat
                        </a>
                        <a href="#fitur"
                            class="px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-lg transition">
                            Lihat Fitur
                        </a>
                    </div>
                    <div class="flex items-center mt-8 text-white/70 text-sm">
                        <svg class="w-5 h-5 text-gama-gold mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                        Gratis &amp; Terpercaya
                    </div>
                </div>

                <!-- Kanan: Feature Cards -->
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                    <div class="space-y-4">
                        <!-- Card 1 -->
                        <div class="flex items-center gap-4 p-4 bg-white/10 rounded-xl">
                            <div class="w-12 h-12 bg-gama-accent/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">10+ Jenis Surat</h4>
                                <p class="text-white/60 text-sm">Tempat tinggal, Tidak Mampu, SKCK, dan lainnya</p>
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="flex items-center gap-4 p-4 bg-white/10 rounded-xl">
                            <div class="w-12 h-12 bg-gama-gold/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">Proses Cepat</h4>
                                <p class="text-white/60 text-sm">RT approve &amp; Staff proses</p>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="flex items-center gap-4 p-4 bg-white/10 rounded-xl">
                            <div class="w-12 h-12 bg-gama-accent/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">Kirim ke WhatsApp</h4>
                                <p class="text-white/60 text-sm">Surat dikirim langsung ke HP</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================= -->
    <!-- FITUR SECTION -->
    <!-- ============================================= -->
    <section id="fitur" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-sm font-semibold text-gama-accent uppercase tracking-wider">Fitur Unggulan</span>
                <h2 class="text-3xl font-bold text-gama-text mt-2">Layanan Lengkap untuk Masyarakat</h2>
                <p class="text-gama-gray mt-2 max-w-2xl mx-auto">Nikmati kemudahan layanan administrasi surat tanpa
                    harus antri di kelurahan.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Fitur 1 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
                    <div
                        class="w-14 h-14 bg-gama-primary/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-gama-primary group-hover:text-white transition">
                        <svg class="w-7 h-7 text-gama-primary group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gama-text mb-2">Ajukan Surat Online</h3>
                    <p class="text-gama-gray text-sm">Pilih jenis surat, isi data, dan upload dokumen dari mana saja
                        tanpa perlu datang ke kelurahan.</p>
                </div>

                <!-- Fitur 2 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
                    <div
                        class="w-14 h-14 bg-gama-primary/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-gama-primary group-hover:text-white transition">
                        <svg class="w-7 h-7 text-gama-primary group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v16h16M4 20L20 4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 8h8M8 12h6M8 16h4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gama-text mb-2">Reuse Data &amp; Dokumen</h3>
                    <p class="text-gama-gray text-sm">Data dan dokumen tersimpan, tidak perlu upload ulang setiap kali
                        mengajukan surat.</p>
                </div>

                <!-- Fitur 3 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
                    <div
                        class="w-14 h-14 bg-gama-primary/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-gama-primary group-hover:text-white transition">
                        <svg class="w-7 h-7 text-gama-primary group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gama-text mb-2">Kirim ke WhatsApp</h3>
                    <p class="text-gama-gray text-sm">Surat selesai langsung dikirim ke WhatsApp warga. Praktis dan
                        cepat.</p>
                </div>

                <!-- Fitur 4 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
                    <div
                        class="w-14 h-14 bg-gama-primary/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-gama-primary group-hover:text-white transition">
                        <svg class="w-7 h-7 text-gama-primary group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gama-text mb-2">Tracking Status</h3>
                    <p class="text-gama-gray text-sm">Pantau status pengajuan dari RT hingga surat diterbitkan secara
                        real-time.</p>
                </div>

                <!-- Fitur 5 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
                    <div
                        class="w-14 h-14 bg-gama-primary/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-gama-primary group-hover:text-white transition">
                        <svg class="w-7 h-7 text-gama-primary group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gama-text mb-2">Download PDF</h3>
                    <p class="text-gama-gray text-sm">Unduh surat dalam format PDF kapan saja dari halaman riwayat
                        pengajuan.</p>
                </div>

                <!-- Fitur 6 -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
                    <div
                        class="w-14 h-14 bg-gama-primary/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-gama-primary group-hover:text-white transition">
                        <svg class="w-7 h-7 text-gama-primary group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gama-text mb-2">Aman &amp; Terpercaya</h3>
                    <p class="text-gama-gray text-sm">Data pribadi terlindungi dan hanya diakses oleh pihak yang
                        berwenang.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="bg-gama-primary py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Siap Mengajukan Surat?</h2>
            <p class="text-white/80 text-lg mb-8">Daftar sekarang dan nikmati kemudahan layanan administrasi surat
                tanpa antri.</p>
            <a href="{{ route('register') }}"
                class="inline-flex items-center px-8 py-3 bg-gama-accent hover:bg-[#4a9e4a] text-white font-semibold rounded-lg transition shadow-lg shadow-gama-accent/30">
                Daftar Sekarang
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-gray-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gama-gray">
            <p class="mb-2">
                <span class="font-semibold text-gama-text">SIPMAS Galung Maloang</span>
                — Sistem Informasi Pelayanan Masyarakat Kelurahan Galung Maloang
            </p>
            <p>© {{ date('Y') }} Kelurahan Galung Maloang, Kecamatan Bacukiki, Kota Parepare</p>
        </div>
    </footer>

</body>

</html>
