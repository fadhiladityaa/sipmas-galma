<x-app-layout>
    <div class="py-8 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6 text-center lg:text-left">
                <h1 class="text-2xl font-bold text-gama-text">Dashboard RW</h1>
                <p class="text-gama-gray">{{ Auth::user()->rwProfile->full_name }}</p>
            </div>

            <!-- Statistik -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-xs text-gama-gray uppercase">Total</p>
                    <p class="text-2xl font-bold text-gama-text">{{ $total }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-yellow-100 p-4">
                    <p class="text-xs text-yellow-600 uppercase">Menunggu</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $waiting }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-green-100 p-4">
                    <p class="text-xs text-green-600 uppercase">Disetujui</p>
                    <p class="text-2xl font-bold text-green-600">{{ $approved }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-red-100 p-4">
                    <p class="text-xs text-red-600 uppercase">Ditolak</p>
                    <p class="text-2xl font-bold text-red-600">{{ $rejected }}</p>
                </div>
            </div>

            <!-- Pengajuan Terbaru -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gama-text mb-4">Pengajuan Menunggu Persetujuan</h3>

                @if ($recentApplications->count() > 0)
                    <div class="space-y-3">
                        @foreach ($recentApplications as $app)
                            <div class="flex items-center justify-between p-3 bg-gama-bg rounded-lg">
                                <div>
                                    <p class="font-medium text-gama-text">{{ $app->user->name }}</p>
                                    <p class="text-sm text-gama-gray">{{ $app->service->name }} •
                                        {{ $app->application_number }}</p>
                                </div>
                                <a href="{{ route('rw.application.detail', $app->id) }}"
                                    class="px-4 py-2 bg-gama-primary text-white rounded-lg text-sm hover:bg-[#1f3320] transition">
                                    Proses
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gama-gray text-center py-4">Tidak ada pengajuan yang menunggu persetujuan.</p>
                @endif

                <div class="mt-4 text-right">
                    <a href="{{ route('rt.applications') }}" class="text-sm text-gama-accent hover:text-gama-primary">
                        Lihat semua →
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
