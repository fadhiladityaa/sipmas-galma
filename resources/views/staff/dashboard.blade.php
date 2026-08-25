<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gama-text">Dashboard Staff</h1>
                <p class="text-gama-gray">Kelola pengajuan surat yang sudah disetujui RT</p>
            </div>

            <!-- Statistik -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-xs text-gama-gray uppercase">Menunggu Diproses</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-4">
                    <p class="text-xs text-blue-600 uppercase">Sedang Diproses</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['in_progress'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-green-100 p-4">
                    <p class="text-xs text-green-600 uppercase">Selesai</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-red-100 p-4">
                    <p class="text-xs text-red-600 uppercase">Ditolak</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
                </div>
            </div>

            <!-- Pengajuan Menunggu -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gama-text mb-4">🕐 Menunggu Diproses</h3>
                @if ($pending->count() > 0)
                    <div class="space-y-3">
                        @foreach ($pending as $app)
                            <div
                                class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                                <div>
                                    <p class="font-medium text-gama-text">{{ $app->user->name }}</p>
                                    <p class="text-sm text-gama-gray">{{ $app->service->name }} •
                                        {{ $app->application_number }}</p>
                                </div>
                                <a href="{{ route('staff.application.detail', $app->id) }}"
                                    class="px-4 py-2 bg-gama-primary text-white rounded-lg text-sm hover:bg-[#1f3320] transition">
                                    Proses
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gama-gray text-center py-4">Tidak ada pengajuan yang menunggu.</p>
                @endif
            </div>

            <!-- Sedang Diproses -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gama-text mb-4">⚙️ Sedang Diproses</h3>
                @if ($inProgress->count() > 0)
                    <div class="space-y-3">
                        @foreach ($inProgress as $app)
                            <div
                                class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-100">
                                <div>
                                    <p class="font-medium text-gama-text">{{ $app->user->name }}</p>
                                    <p class="text-sm text-gama-gray">{{ $app->service->name }} •
                                        {{ $app->application_number }}</p>
                                </div>
                                <a href="{{ route('staff.application.detail', $app->id) }}"
                                    class="px-4 py-2 bg-gama-accent text-white rounded-lg text-sm hover:bg-gama-primary transition">
                                    Lanjutkan
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gama-gray text-center py-4">Tidak ada pengajuan yang sedang diproses.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
