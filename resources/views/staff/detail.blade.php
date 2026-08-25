<x-app-layout>
    <div class="py-8 my-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Header -->
                <div class="bg-gama-bg/50 px-6 py-4 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h1 class="text-xl font-bold text-gama-text">Proses Pengajuan</h1>
                            <p class="text-sm text-gama-gray">{{ $application->application_number }}</p>
                        </div>
                        <span
                            class="px-3 py-1 rounded-full text-sm
                            @if ($application->status == 'disetujui_rt') bg-yellow-100 text-yellow-700
                            @elseif($application->status == 'in_progress') bg-blue-100 text-blue-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ str_replace('_', ' ', ucfirst($application->status)) }}
                        </span>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Data Pemohon -->
                    <div>
                        <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-3">Data Pemohon</h3>
                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-gama-bg/60 rounded-xl p-4 border border-gray-100">
                            <div>
                                <span class="text-xs text-gama-gray">Nama</span>
                                <br>
                                <span class="text-sm font-medium">{{ $application->user->name }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gama-gray">NIK</span>
                                <br>
                                <span class="text-sm font-medium">{{ $application->user->nik ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gama-gray">No. HP</span>
                                <br>
                                <span class="text-sm">{{ $application->user->nomor_hp ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gama-gray">Alamat</span>
                                <br>
                                <span class="text-sm">{{ $application->user->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen KTP & KK -->
                    <div>
                        <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-3">Dokumen Pendukung
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- KTP -->
                            <div class="bg-gama-bg/60 rounded-xl p-4 border border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-6 h-6 text-gama-primary" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gama-text">KTP</p>
                                            @if ($user->ktp_path)
                                                <p class="text-xs text-gama-gray">✓ Dokumen tersedia</p>
                                            @else
                                                <p class="text-xs text-red-500">⚠ Belum upload KTP</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($user->ktp_path)
                                        <button type="button" onclick="previewKTP()"
                                            class="px-3 py-1.5 text-sm bg-gama-primary/10 text-gama-primary hover:bg-gama-primary hover:text-white rounded-lg transition">
                                            Lihat
                                        </button>
                                    @else
                                        <span class="text-xs text-gama-gray">-</span>
                                    @endif
                                </div>
                            </div>

                            <!-- KK -->
                            <div class="bg-gama-bg/60 rounded-xl p-4 border border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-6 h-6 text-gama-primary" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gama-text">KK</p>
                                            @if ($user->kk_path)
                                                <p class="text-xs text-gama-gray">✓ Dokumen tersedia</p>
                                            @else
                                                <p class="text-xs text-red-500">⚠ Belum upload KK</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($user->kk_path)
                                        <button type="button" onclick="previewKK()"
                                            class="px-3 py-1.5 text-sm bg-gama-primary/10 text-gama-primary hover:bg-gama-primary hover:text-white rounded-lg transition">
                                            Lihat
                                        </button>
                                    @else
                                        <span class="text-xs text-gama-gray">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Surat -->
                    <div>
                        <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-3">Data Surat</h3>
                        <div class="bg-gama-bg/60 rounded-xl p-4 border border-gray-100">
                            <p>
                                <span class="text-xs text-gama-gray">Jenis Surat</span>
                                <br>
                                <span
                                    class="text-sm font-semibold text-gama-primary">{{ $application->service->name }}</span>
                            </p>

                            @if ($application->data && count($application->getFormattedData()) > 0)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <span class="text-xs text-gama-gray">Data Tambahan</span>
                                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach ($application->getFormattedData() as $field)
                                            <div
                                                class="flex justify-between bg-white/70 rounded-lg px-3 py-2 border border-gray-100">
                                                <span class="text-xs text-gama-gray">{{ $field['label'] }}</span>
                                                <span class="text-sm font-medium">{{ $field['value'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($application->notes)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <span class="text-xs text-gama-gray">Catatan Pemohon</span>
                                    <p class="text-sm bg-white/70 rounded-lg px-3 py-2 border border-gray-100 mt-1">
                                        {{ $application->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Editor Surat -->
                    <div>
                        <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-3">Isi Surat</h3>

                        @if ($application->status == 'disetujui_rt')
                            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-4">
                                <p class="text-sm text-yellow-700">
                                    ⚠️ Klik <strong>"Mulai Proses"</strong> untuk mulai menyusun surat.
                                </p>
                            </div>
                            <form action="{{ route('staff.application.process', $application->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-6 py-2.5 bg-gama-accent hover:bg-gama-primary text-white font-medium rounded-lg transition">
                                    🚀 Mulai Proses
                                </button>
                            </form>
                        @elseif($application->status == 'in_progress')
                            <form action="{{ route('staff.application.approve', $application->id) }}" method="POST">
                                @csrf

                                <!-- Field nomor surat -->
                                <div class="mb-4">
                                    <label for="letter_number" class="block text-sm font-medium text-gama-text">Nomor
                                        Surat</label>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span
                                            class="text-sm text-gama-gray bg-gama-bg px-3 py-2 rounded-lg border border-gray-200">148.3/</span>
                                        <input type="text" name="letter_number" id="letter_number"
                                            value="{{ old('letter_number', $letter->letter_number ?? '') }}"
                                            placeholder="Contoh: 001"
                                            class="flex-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent">
                                        <span
                                            class="text-sm text-gama-gray bg-gama-bg px-3 py-2 rounded-lg border border-gray-200">/GLM</span>
                                    </div>
                                    <p class="text-xs text-gama-gray mt-1">* Kosongkan untuk auto-generate nomor</p>
                                </div>

                                <!-- Isi Surat -->
                                <div class="mb-4">
                                    <label for="content" class="block text-sm font-medium text-gama-text">Isi
                                        Surat</label>
                                    <textarea name="content" id="content" rows="15"
                                        class="w-full border-gray-200 rounded-xl focus:border-gama-accent focus:ring-2 focus:ring-gama-accent/20 font-mono text-sm p-4"
                                        placeholder="Tulis isi surat di sini...">{{ old('content', $letter->content ?? '') }}</textarea>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="flex flex-wrap gap-3">
                                    <button type="submit"
                                        class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                                        Terbitkan Surat
                                    </button>
                                    <button type="button" onclick="submitPreview()"
                                        class="px-6 py-2.5 bg-gama-primary hover:bg-[#1f3320] text-white font-medium rounded-lg transition">
                                        Preview
                                    </button>
                                </div>
                            </form>

                            <!-- Tombol Tolak -->
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <button onclick="openRejectModal()"
                                    class="px-6 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-medium rounded-lg transition">
                                    Tolak Pengajuan
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="pt-4 border-t border-gray-100">
                        <a href="{{ route('staff.dashboard') }}"
                            class="text-sm text-gama-gray hover:text-gama-primary transition">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview KTP -->
    <div id="ktp-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center"
        onclick="closePreview('ktp-modal')">
        <div class="bg-white rounded-2xl max-w-lg w-full mx-4 p-6 shadow-2xl" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gama-text">Preview KTP</h3>
                <button onclick="closePreview('ktp-modal')" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center justify-center min-h-[200px]">
                @if ($user->ktp_path)
                    <img src="{{ asset('storage/' . $user->ktp_path) }}" alt="KTP"
                        class="w-full h-auto rounded-lg max-h-[500px] object-contain">
                @else
                    <p class="text-gama-gray">Belum ada KTP</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Preview KK -->
    <div id="kk-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center"
        onclick="closePreview('kk-modal')">
        <div class="bg-white rounded-2xl max-w-lg w-full mx-4 p-6 shadow-2xl" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gama-text">Preview KK</h3>
                <button onclick="closePreview('kk-modal')" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center justify-center min-h-[200px]">
                @if ($user->kk_path)
                    <img src="{{ asset('storage/' . $user->kk_path) }}" alt="KK"
                        class="w-full h-auto rounded-lg max-h-[500px] object-contain">
                @else
                    <p class="text-gama-gray">Belum ada KK</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Form Preview (Hidden) -->
    <form id="previewForm" action="{{ route('staff.application.preview', $application->id) }}" method="GET"
        target="_blank">
        <input type="hidden" name="content" id="preview_content">
        <input type="hidden" name="letter_number" id="preview_letter_number">
    </form>

    <!-- Modal Tolak -->
    <div id="rejectModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden items-center justify-center"
        onclick="closeRejectModal()">
        <div class="bg-white rounded-2xl max-w-md w-full mx-4 p-6 shadow-2xl" onclick="event.stopPropagation()">
            <h3 class="text-lg font-bold text-gama-text mb-2">Tolak Pengajuan</h3>
            <p class="text-sm text-gama-gray mb-4">Berikan alasan penolakan.</p>
            <form action="{{ route('staff.application.reject', $application->id) }}" method="POST">
                @csrf
                <textarea name="reason" rows="4" required
                    class="w-full border-gray-200 rounded-xl focus:border-gama-accent focus:ring-2 focus:ring-gama-accent/20 mb-4"
                    placeholder="Tulis alasan..."></textarea>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 text-sm text-gama-gray hover:text-gama-text">Batal</button>
                    <button type="submit"
                        class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg">Ya,
                        Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejectModal').classList.add('flex');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejectModal').classList.remove('flex');
        }

        function submitPreview() {
            var content = document.getElementById('content').value;
            var letterNumber = document.getElementById('letter_number').value;

            document.getElementById('preview_content').value = content;
            document.getElementById('preview_letter_number').value = letterNumber;
            document.getElementById('previewForm').submit();
        }

        function previewKTP() {
            document.getElementById('ktp-modal').classList.remove('hidden');
            document.getElementById('ktp-modal').classList.add('flex');
        }

        function previewKK() {
            document.getElementById('kk-modal').classList.remove('hidden');
            document.getElementById('kk-modal').classList.add('flex');
        }

        function closePreview(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }
    </script>
</x-app-layout>
