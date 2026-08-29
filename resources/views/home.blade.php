<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Selamat Datang -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gama-text">
                        Selamat Datang, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-gama-gray mt-1 text-sm md:text-base max-w-2xl">
                        SIPMAS Galung Maloang memudahkan Anda mengajukan layanan administrasi surat secara online dari
                        mana saja, tanpa perlu datang langsung ke kantor kelurahan. Surat yang telah diterbitkan akan
                        dikirimkan langsung ke nomor WhatsApp Anda.
                    </p>
                </div>
                <div class="mt-4 md:mt-0 flex-shrink-0">
                    <a href="{{ route('warga.pengajuan-surat') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-gama-primary hover:bg-[#1f3320] text-white font-medium rounded-lg transition shadow-sm hover:shadow">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajukan Surat
                    </a>
                </div>
            </div>
        </div>

        <!-- ============================================= -->
        <!-- STATISTIK DINAMIS                             -->
        <!-- ============================================= -->
        @php
            $total = App\Models\Application::where('user_id', Auth::id())->count();
            $processed = App\Models\Application::where('user_id', Auth::id())
                ->whereIn('status', ['menunggu_rt', 'disetujui_rt', 'in_progress'])
                ->count();
            $completed = App\Models\Application::where('user_id', Auth::id())->where('status', 'issued')->count();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-gama-primary/10 text-gama-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gama-gray uppercase tracking-wider">Total Pengajuan</p>
                        <p class="text-xl font-bold text-gama-text">{{ $total }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-yellow-50 text-yellow-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gama-gray uppercase tracking-wider">Sedang Diproses</p>
                        <p class="text-xl font-bold text-yellow-600">{{ $processed }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-green-50 text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gama-gray uppercase tracking-wider">Selesai</p>
                        <p class="text-xl font-bold text-green-600">{{ $completed }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Tambahan -->
        <div class="bg-gama-bg/50 rounded-xl border border-gama-secondary/30 p-6 text-center text-sm text-gama-gray">
            <svg class="w-5 h-5 mx-auto mb-2 text-gama-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p>Surat yang telah diterbitkan akan tersimpan di arsip dan dapat diunduh kapan saja melalui halaman
                <strong>Riwayat</strong>.
            </p>
        </div>
    </div>
</x-app-layout>
