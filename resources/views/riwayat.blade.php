<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-3">

            <!-- Header -->
            <div class="mb-6 text-center lg:text-left">
                <h1 class="text-2xl font-bold text-gama-text">Riwayat Pengajuan</h1>
                <p class="text-gama-gray text-sm">Pantau status pengajuan surat Anda di sini.</p>
            </div>

            <!-- Statistik -->
            <div class="grid grid-cols-2 md:grid-cols-5 px-3 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
                    <p class="text-2xl font-bold text-gama-text">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gama-gray uppercase">Total</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-yellow-100 p-4 text-center">
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                    <p class="text-xs text-yellow-600 uppercase">Menunggu RT</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-4 text-center">
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['processed'] }}</p>
                    <p class="text-xs text-blue-600 uppercase">Diproses</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-green-100 p-4 text-center">
                    <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
                    <p class="text-xs text-green-600 uppercase">Selesai</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-red-100 p-4 text-center">
                    <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
                    <p class="text-xs text-red-600 uppercase">Ditolak</p>
                </div>
            </div>

            <!-- Daftar Pengajuan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @if ($applications->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gama-bg">
                                <tr>
                                    <th class="px-4 py-3 text-left">No. Pengajuan</th>
                                    <th class="px-4 py-3 text-left">Jenis Surat</th>
                                    <th class="px-4 py-3 text-left">Status</th>
                                    <th class="px-4 py-3 text-left">Tanggal</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $app)
                                    <tr class="border-b border-gray-100 hover:bg-gama-bg/30 transition">
                                        <td class="px-4 py-3 font-mono text-xs">{{ $app->application_number }}</td>
                                        <td class="px-4 py-3">{{ $app->service->name ?? '-' }}</td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="px-2 py-1 rounded-full text-xs
                                                @if ($app->status == 'menunggu_rt') bg-yellow-100 text-yellow-700
                                                @elseif($app->status == 'disetujui_rt') bg-blue-100 text-blue-700
                                                @elseif($app->status == 'in_progress') bg-blue-100 text-blue-700
                                                @elseif($app->status == 'issued') bg-green-100 text-green-700
                                                @elseif($app->status == 'rejected') bg-red-100 text-red-700
                                                @else bg-gray-100 text-gray-700 @endif">
                                                {{ str_replace('_', ' ', ucfirst($app->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-gama-gray">
                                            {{ $app->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-3 flex">
                                            <a href="{{ route('warga.riwayat.tracking', $app->id) }}"
                                                class="text-gama-accent hover:text-gama-primary text-sm">
                                                Detail
                                            </a>
                                            @if ($app->status == 'issued' && isset($app->letter) && $app->letter->hasPdf())
                                                <span class="text-gama-gray mx-1">|</span>
                                                <a href="{{ asset('storage/' . $app->letter->pdf_path) }}"
                                                    class="text-green-600 hover:text-green-700 text-sm">
                                                    PDF
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-gray-100">
                        {{ $applications->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gama-gray/50 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gama-gray">Belum ada pengajuan surat.</p>
                        <a href="{{ route('warga.pengajuan-surat') }}"
                            class="mt-4 inline-block px-4 py-2 bg-gama-primary text-white rounded-lg text-sm hover:bg-[#1f3320] transition">
                            Ajukan Surat Sekarang
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
