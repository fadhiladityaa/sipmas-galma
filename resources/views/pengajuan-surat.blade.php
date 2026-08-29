<x-app-layout>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
            <div class="border-b border-gray-100 pb-4 mb-6">

                @if (Auth::user() && !Auth::user()->hasCompleteProfile())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium">Data Profil Belum Lengkap</p>
                                <p class="text-sm">Silakan lengkapi data profil Anda sebelum mengajukan surat.</p>
                                <a href="{{ route('profile.edit') }}"
                                    class="text-sm font-medium text-red-700 hover:text-red-900 underline">
                                    Lengkapi Profil →
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <h1 class="text-2xl font-bold text-gama-text">Pilih Jenis Surat</h1>
                <p class="text-gama-gray text-sm mt-1">
                    Pilih salah satu jenis surat yang ingin Anda ajukan. Data dan dokumen Anda akan digunakan secara
                    otomatis.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($services as $service)
                    <a href="{{ route('warga.pengajuan.create', $service->id) }}"
                        class="block p-4 border border-gray-200 rounded-xl hover:shadow-md hover:border-gama-accent transition group">
                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 bg-gama-primary/10 p-2.5 rounded-lg text-gama-primary group-hover:bg-gama-primary group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gama-text group-hover:text-gama-primary transition">
                                    {{ $service->name }}
                                </h3>
                                <p class="text-xs text-gama-gray mt-0.5">{{ $service->description }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-8 text-gama-gray">
                        <p>Belum ada jenis surat yang tersedia.</p>
                    </div>
                @endforelse

                <!-- Opsi Lainnya -->
                <a href="{{ route('warga.pengajuan.create', ['custom' => true]) }}"
                    class="block p-4 border border-dashed border-gray-300 rounded-xl hover:border-gama-accent hover:bg-gama-bg/50 transition group">
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 bg-gray-100 p-2.5 rounded-lg text-gray-500 group-hover:text-gama-primary group-hover:bg-gama-primary/10 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gama-text group-hover:text-gama-primary transition">
                                Lainnya</h3>
                            <p class="text-xs text-gama-gray mt-0.5">Jika jenis surat tidak ada di daftar, silakan tulis
                                manual</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="mt-8 pt-4 border-t border-gray-100">
                <a href="{{ route('warga.home') }}"
                    class="inline-flex items-center text-sm text-gama-gray hover:text-gama-primary transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
