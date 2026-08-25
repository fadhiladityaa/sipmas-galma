<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <!-- Header dengan background hijau lembut -->
                <div class="bg-slate-300 from-gama-primary/5 to-gama-secondary/30 px-6 py-5 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h1 class="text-xl font-bold text-gama-text flex items-center gap-2">
                                <svg class="w-5 h-5 text-gama-accent" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Detail Pengajuan
                            </h1>
                            <p class="text-sm text-gama-gray font-mono mt-0.5">{{ $application->application_number }}
                            </p>
                        </div>
                        <span
                            class="px-4 py-1.5 rounded-full text-sm font-medium inline-flex items-center gap-1.5 self-start
                            @if ($application->status == 'menunggu_rt') bg-gama-bg text-gama-text border border-gama-secondary
                            @elseif($application->status == 'disetujui_rt') bg-gama-accent/10 text-gama-accent border border-gama-accent/30
                            @elseif($application->status == 'ditolak_rt') bg-red-50 text-red-600 border border-red-200
                            @else bg-gray-50 text-gray-600 border border-gray-200 @endif">
                            <span
                                class="w-1.5 h-1.5 rounded-full inline-block
                                @if ($application->status == 'menunggu_rt') bg-gama-accent
                                @elseif($application->status == 'disetujui_rt') bg-green-500
                                @elseif($application->status == 'ditolak_rt') bg-red-500
                                @else bg-gray-400 @endif">
                            </span>
                            {{ str_replace('_', ' ', ucfirst($application->status)) }}
                        </span>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Data Pemohon -->
                    <div>
                        <h3
                            class="text-sm font-semibold text-gama-text uppercase tracking-wider flex items-center gap-2 mb-3">
                            <svg class="w-4 h-4 text-gama-accent" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Data Pemohon
                        </h3>
                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-slate-200 rounded-xl p-4 border border-green-400">
                            <div class="flex flex-col">
                                <span class="text-xs text-gama-gray uppercase tracking-wider">Nama Lengkap</span>
                                <span class="text-sm font-medium text-gama-text">{{ $application->user->name }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gama-gray uppercase tracking-wider">NIK</span>
                                <span
                                    class="text-sm font-medium text-gama-text">{{ $application->user->nik ?? '-' }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gama-gray uppercase tracking-wider">Email</span>
                                <span class="text-sm text-gama-text">{{ $application->user->email }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs text-gama-gray uppercase tracking-wider">No. HP</span>
                                <span class="text-sm text-gama-text">{{ $application->user->nomor_hp ?? '-' }}</span>
                            </div>
                            <div class="sm:col-span-2 flex flex-col">
                                <span class="text-xs text-gama-gray uppercase tracking-wider">Alamat</span>
                                <span class="text-sm text-gama-text">{{ $application->user->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Surat -->
                    <div>
                        <h3
                            class="text-sm font-semibold text-gama-text uppercase tracking-wider flex items-center gap-2 mb-3">
                            <svg class="w-4 h-4 text-gama-accent" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Informasi Surat
                        </h3>
                        <div class="bg-slate-200 rounded-xl p-4 border border-green-400">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div class="flex flex-col">
                                    <span class="text-xs text-gama-gray uppercase tracking-wider">Jenis Surat</span>
                                    <span
                                        class="text-sm font-semibold text-gama-primary">{{ $application->service->name }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs text-gama-gray uppercase tracking-wider">Tanggal
                                        Pengajuan</span>
                                    <span
                                        class="text-sm text-gama-text">{{ $application->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>

                            <!-- Data Tambahan -->
                            @if ($application->data && count($application->getFormattedData()) > 0)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <span class="text-xs text-gama-gray uppercase tracking-wider">Data Tambahan</span>
                                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach ($application->getFormattedData() as $field)
                                            <div
                                                class="flex justify-between items-center bg-white/70 rounded-lg px-3 py-2 border border-gray-100">
                                                <span class="text-xs text-gama-gray">{{ $field['label'] }}</span>
                                                <span
                                                    class="text-sm font-medium text-gama-text">{{ $field['value'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($application->notes)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <span class="text-xs text-gama-gray uppercase tracking-wider">Catatan</span>
                                    <p
                                        class="text-sm text-gama-text mt-1 bg-white/70 rounded-lg px-3 py-2 border border-gray-100">
                                        {{ $application->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Dokumen -->
                    @if ($application->documents->count() > 0)
                        <div>
                            <h3
                                class="text-sm font-semibold text-gama-text uppercase tracking-wider flex items-center gap-2 mb-3">
                                <svg class="w-4 h-4 text-gama-accent" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                Dokumen Pendukung
                            </h3>
                            <div class="bg-gama-bg/60 rounded-xl p-4 border border-gray-100">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach ($application->documents as $doc)
                                        <div
                                            class="flex items-center gap-2 bg-white/70 rounded-lg px-3 py-2 border border-gray-100">
                                            <svg class="w-4 h-4 text-gama-accent flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span class="text-sm text-gama-text">{{ $doc->label ?? 'Dokumen' }}</span>
                                            <span
                                                class="text-xs text-gama-gray ml-auto">{{ $doc->is_reused ? '📎 Reused' : '📤 Baru' }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Alasan Penolakan -->
                    @if ($application->status == 'ditolak_rt' && $application->rt_rejection_reason)
                        <div class="bg-red-50/80 border border-red-200 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <span class="text-sm font-semibold text-red-700">Alasan Penolakan</span>
                                    <p class="text-sm text-red-600 mt-0.5">{{ $application->rt_rejection_reason }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Tombol Aksi -->
                    @if ($application->status == 'menunggu_rt')
                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <form action="{{ route('rt.application.approve', $application->id) }}" method="POST"
                                class="w-full sm:w-auto">
                                @csrf
                                <button type="submit"
                                    class="w-full sm:w-auto px-6 py-2.5 bg-gama-accent hover:bg-gama-primary text-white font-medium rounded-lg transition shadow-sm hover:shadow flex items-center justify-center gap-2">
                                    Setujui
                                </button>
                            </form>

                            <button onclick="openRejectModal()"
                                class="w-full sm:w-auto px-6 py-2.5 bg-white hover:bg-red-50 text-red-600 border border-red-200 hover:border-red-300 font-medium rounded-lg transition flex items-center justify-center gap-2">
                                Tolak
                            </button>
                        </div>
                    @endif

                    <!-- Tombol Kembali -->
                    <div class="pt-4 border-t border-gray-100">
                        <a href="{{ route('rt.dashboard') }}"
                            class="inline-flex items-center gap-2 text-sm text-gama-gray hover:text-gama-primary transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tolak -->
    <div id="rejectModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden items-center justify-center"
        onclick="closeRejectModal()">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6 shadow-2xl" onclick="event.stopPropagation()">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gama-text">Tolak Pengajuan</h3>
            </div>
            <p class="text-sm text-gama-gray mb-4">Berikan alasan penolakan agar pemohon dapat memperbaiki
                pengajuannya.</p>

            <form action="{{ route('rt.application.reject', $application->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="reason" class="block text-sm font-medium text-gama-text mb-1">Alasan
                        Penolakan</label>
                    <textarea name="reason" id="reason" rows="4" required
                        class="w-full border-gray-200 rounded-xl focus:border-gama-accent focus:ring-2 focus:ring-gama-accent/20 transition"
                        placeholder="Tulis alasan penolakan dengan jelas..."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 text-sm text-gama-gray hover:text-gama-text transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition shadow-sm hover:shadow">
                        Ya, Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejectModal').classList.add('flex');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejectModal').classList.remove('flex');
        }
    </script>
</x-app-layout>
