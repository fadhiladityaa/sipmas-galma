<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gama-text">Detail Pengajuan</h1>
                        <p class="text-sm text-gama-gray">{{ $application->application_number }}</p>
                    </div>
                    <span
                        class="px-3 py-1 rounded-full text-sm
                        @if ($application->status == 'menunggu_rt') bg-yellow-100 text-yellow-700
                        @elseif($application->status == 'disetujui_rt') bg-blue-100 text-blue-700
                        @elseif($application->status == 'in_progress') bg-blue-100 text-blue-700
                        @elseif($application->status == 'issued') bg-green-100 text-green-700
                        @elseif($application->status == 'rejected') bg-red-100 text-red-700
                        @else bg-gray-100 text-gray-700 @endif">
                        {{ str_replace('_', ' ', ucfirst($application->status)) }}
                    </span>
                </div>

                <!-- Timeline Status -->
                <div class="bg-gama-bg/50 rounded-xl p-4 mb-6">
                    <h3 class="text-sm font-semibold text-gama-text mb-3">Timeline</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-500 mt-1.5"></div>
                            <div>
                                <p class="text-sm font-medium text-gama-text">Pengajuan Dikirim</p>
                                <p class="text-xs text-gama-gray">{{ $application->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                        @if ($application->status != 'menunggu_rt')
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 rounded-full bg-green-500 mt-1.5"></div>
                                <div>
                                    <p class="text-sm font-medium text-gama-text">Disetujui RT</p>
                                    <p class="text-xs text-gama-gray">
                                        {{ $application->rt_approved_at ? \Carbon\Carbon::parse($application->rt_approved_at)->format('d/m/Y H:i') : '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if ($application->status == 'issued')
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 rounded-full bg-green-500 mt-1.5"></div>
                                <div>
                                    <p class="text-sm font-medium text-gama-text">Surat Diterbitkan</p>
                                    <p class="text-xs text-gama-gray">
                                        {{ $application->issued_at ? \Carbon\Carbon::parse($application->issued_at)->format('d/m/Y H:i') : '-' }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        @if ($application->status == 'rejected')
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 rounded-full bg-red-500 mt-1.5"></div>
                                <div>
                                    <p class="text-sm font-medium text-red-600">Ditolak</p>
                                    <p class="text-xs text-gama-gray">
                                        {{ $application->updated_at->format('d/m/Y H:i') }}</p>
                                    @if ($application->rejected_reason)
                                        <p class="text-sm text-red-600 mt-1">Alasan: {{ $application->rejected_reason }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Informasi Surat -->
                <div class="bg-gama-bg/50 rounded-xl p-4 mb-6">
                    <h3 class="text-sm font-semibold text-gama-text mb-2">Informasi Surat</h3>
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div><span class="text-gama-gray">Jenis Surat:</span> {{ $application->service->name ?? '-' }}
                        </div>
                        <div><span class="text-gama-gray">RT:</span> {{ $application->rt->full_name ?? '-' }}</div>
                    </div>
                    @if ($application->notes)
                        <div class="mt-2">
                            <span class="text-gama-gray text-sm">Catatan:</span>
                            <p class="text-sm">{{ $application->notes }}</p>
                        </div>
                    @endif
                </div>

                <!-- Tombol -->
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('warga.riwayat') }}"
                        class="text-sm text-gama-gray hover:text-gama-primary transition">
                        ← Kembali ke Riwayat
                    </a>
                    @if ($application->status == 'issued' && isset($letter) && $letter->hasPdf())
                        <a href="{{ route('warga.riwayat.download', $application->id) }}"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm transition">
                            📄 Download PDF
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
