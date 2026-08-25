<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

                <!-- Header -->
                <div class="bg-gama-bg/50 px-6 py-4 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h1 class="text-xl font-bold text-gama-text">Detail Pengajuan</h1>
                            <p class="text-sm text-gama-gray">{{ $application->application_number }}</p>
                        </div>
                        <span
                            class="px-3 py-1 rounded-full text-sm
                            @if ($application->status == 'menunggu_rt') bg-yellow-100 text-yellow-700
                            @elseif($application->status == 'disetujui_rt') bg-blue-100 text-blue-700
                            @elseif($application->status == 'in_progress') bg-blue-100 text-blue-700
                            @elseif($application->status == 'issued') bg-green-100 text-green-700
                            @elseif($application->status == 'rejected' || $application->status == 'ditolak_rt') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ str_replace('_', ' ', ucfirst($application->status)) }}
                        </span>
                    </div>
                </div>

                <div class="p-6 space-y-6">

                    <!-- Informasi Surat -->
                    <div class="bg-gama-bg/60 rounded-xl p-4 border border-gray-100">
                        <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-3">Informasi Surat
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <span class="text-xs text-gama-gray">Jenis Surat</span>
                                <p class="text-sm font-medium">{{ $application->service->name }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-gama-gray">Tanggal Pengajuan</span>
                                <p class="text-sm">{{ $application->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-gama-gray">Nomor Surat</span>
                                <p class="text-sm">{{ $application->letter->letter_number ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-gama-gray">Status</span>
                                <p class="text-sm font-medium">
                                    {{ str_replace('_', ' ', ucfirst($application->status)) }}
                                </p>
                            </div>
                        </div>

                        <!-- Download PDF (jika sudah issued) -->
                        @if ($application->status == 'issued' && $application->letter && $application->letter->pdf_path)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <a href="{{ route('warga.riwayat.download', $application->id) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-gama-primary hover:bg-[#1f3320] text-white text-sm font-medium rounded-lg transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    Download Surat (PDF)
                                </a>
                            </div>
                        @endif

                        @if ($application->status == 'ditolak_rt' && $application->rt_rejection_reason)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <span class="text-xs text-gama-gray">Alasan Penolakan RT</span>
                                <p class="text-sm text-red-600 mt-1">{{ $application->rt_rejection_reason }}</p>
                            </div>
                        @endif

                        @if ($application->status == 'rejected' && $application->rejected_reason)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <span class="text-xs text-gama-gray">Alasan Penolakan Staff</span>
                                <p class="text-sm text-red-600 mt-1">{{ $application->rejected_reason }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Timeline Status -->
                    <div>
                        <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-4">Timeline Status
                        </h3>
                        <div class="relative">
                            <!-- Garis vertikal -->
                            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

                            <!-- Timeline items -->
                            <div class="space-y-6">
                                @foreach ($timeline as $item)
                                    <div class="flex items-start relative">
                                        <!-- Icon -->
                                        <div
                                            class="z-10 flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center
                                            @if (isset($item['is_rejected']) && $item['is_rejected']) bg-red-100 text-red-600
                                            @elseif($item['is_completed']) bg-green-100 text-green-600
                                            @else bg-gray-100 text-gray-400 @endif">
                                            {{ $item['icon'] }}
                                        </div>

                                        <!-- Konten -->
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center justify-between">
                                                <h4 class="text-sm font-semibold text-gama-text">{{ $item['status'] }}
                                                </h4>
                                                <span class="text-xs text-gama-gray">
                                                    {{ $item['time'] ? \Carbon\Carbon::parse($item['time'])->format('d/m/Y H:i') : '-' }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gama-gray mt-0.5">{{ $item['description'] }}</p>

                                            @if (isset($item['has_pdf']) && $item['has_pdf'])
                                                <div class="mt-2">
                                                    <a href="{{ $item['pdf_url'] }}" target="_blank"
                                                        class="inline-flex items-center text-sm text-gama-accent hover:text-gama-primary">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                                        </svg>
                                                        Download PDF
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="pt-4 border-t border-gray-100">
                        <a href="{{ route('warga.riwayat') }}"
                            class="text-sm text-gama-gray hover:text-gama-primary transition">
                            ← Kembali ke Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
