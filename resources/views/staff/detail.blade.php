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
                            <h1 class="text-xl font-bold text-gama-text">Detail Pengajuan</h1>
                            <p class="text-sm text-gama-gray">{{ $application->application_number }}</p>
                        </div>
                        <span
                            class="px-3 py-1 rounded-full text-sm
                            @if ($application->status == 'disetujui_rt') bg-yellow-100 text-yellow-700
                            @elseif($application->status == 'in_progress') bg-blue-100 text-blue-700
                            @elseif($application->status == 'issued') bg-green-100 text-green-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ str_replace('_', ' ', ucfirst($application->status)) }}
                        </span>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    {{-- DATA PEMOHON (LENGKAP) --}}
                    <div>
                        <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-3">Data Pemohon</h3>
                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-gama-bg/60 rounded-xl p-4 border border-gray-100">
                            <div>
                                <span class="text-xs text-gama-gray">Nama Lengkap</span>
                                <br>
                                <span class="text-sm font-medium">{{ $application->user->name }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gama-gray">NIK</span>
                                <br>
                                <span class="text-sm font-medium">{{ $application->user->nik ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gama-gray">Tempat Lahir</span>
                                <br>
                                <span class="text-sm font-medium">{{ $application->user->tempat_lahir ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gama-gray">Tanggal Lahir</span>
                                <br>
                                <span
                                    class="text-sm font-medium">{{ $application->user->tanggal_lahir ? \Carbon\Carbon::parse($application->user->tanggal_lahir)->format('d/m/Y') : '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gama-gray">Jenis Kelamin</span>
                                <br>
                                <span class="text-sm font-medium">
                                    @php
                                        $gender = $application->user->jenis_kelamin ?? '-';
                                        if ($gender == 'L') {
                                            $gender = 'Laki-laki';
                                        } elseif ($gender == 'P') {
                                            $gender = 'Perempuan';
                                        }
                                    @endphp
                                    {{ $gender }}
                                </span>
                            </div>
                            <div>
                                <span class="text-xs text-gama-gray">Agama</span>
                                <br>
                                <span class="text-sm font-medium">{{ $application->user->agama ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gama-gray">Pekerjaan</span>
                                <br>
                                <span class="text-sm font-medium">{{ $application->user->pekerjaan ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gama-gray">No. HP</span>
                                <br>
                                <span class="text-sm font-medium">{{ $application->user->nomor_hp ?? '-' }}</span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="text-xs text-gama-gray">Alamat</span>
                                <br>
                                <span class="text-sm font-medium">{{ $application->user->alamat ?? '-' }}</span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="text-xs text-gama-gray">Email</span>
                                <br>
                                <span class="text-sm font-medium">{{ $application->user->email }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- PREVIEW KTP & KK --}}
                    <div>
                        <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-3">Dokumen Pendukung
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- KTP -->
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
                                            @if ($application->user->ktp_path)
                                                <p class="text-xs text-gama-gray">✓ Dokumen tersedia</p>
                                            @else
                                                <p class="text-xs text-red-500">⚠ Belum upload KTP</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($application->user->ktp_path)
                                        <div class="flex gap-2">
                                            <button type="button" onclick="previewKTP()"
                                                class="px-3 py-1.5 text-sm bg-gama-primary/10 text-gama-primary hover:bg-gama-primary hover:text-white rounded-lg transition">
                                                Lihat
                                            </button>
                                            <a href="{{ route('staff.download.dokumen', ['id' => $application->id, 'type' => 'ktp']) }}"
                                                class="px-3 py-1.5 text-sm bg-gama-primary/10 text-gama-primary hover:bg-gama-primary hover:text-white rounded-lg transition">
                                                Download
                                            </a>
                                        </div>
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
                                            @if ($application->user->kk_path)
                                                <p class="text-xs text-gama-gray">✓ Dokumen tersedia</p>
                                            @else
                                                <p class="text-xs text-red-500">⚠ Belum upload KK</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($application->user->kk_path)
                                        <div class="flex gap-2">
                                            <button type="button" onclick="previewKK()"
                                                class="px-3 py-1.5 text-sm bg-gama-primary/10 text-gama-primary hover:bg-gama-primary hover:text-white rounded-lg transition">
                                                Lihat
                                            </button>
                                            <a href="{{ route('staff.download.dokumen', ['id' => $application->id, 'type' => 'kk']) }}"
                                                class="px-3 py-1.5 text-sm bg-gama-primary/10 text-gama-primary hover:bg-gama-primary hover:text-white rounded-lg transition">
                                                Download
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-xs text-gama-gray">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DATA SURAT --}}
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

                    <!-- FORM PROSES / UPLOAD SURAT                   -->
                    @if ($application->status == 'disetujui_rt')
                        <div>
                            <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-3">Proses
                                Pengajuan</h3>
                            <form action="{{ route('staff.application.process', $application->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-6 py-2.5 bg-gama-accent hover:bg-gama-primary text-white font-medium rounded-lg transition">
                                    🚀 Mulai Proses
                                </button>
                            </form>
                        </div>
                    @elseif($application->status == 'in_progress')
                        <div>
                            <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-3">Upload Surat
                                Jadi</h3>

                            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-4">
                                <p class="text-sm text-yellow-700">
                                    ⚠️ Upload surat yang sudah jadi (sudah dibarcode/ditandatangani).
                                </p>
                            </div>

                            <form action="{{ route('staff.application.upload-surat', $application->id) }}"
                                method="POST" enctype="multipart/form-data" id="uploadForm">
                                @csrf

                                <!-- Drag & Drop Upload Area -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gama-text mb-2">Upload Surat
                                        (PDF)</label>

                                    <div id="uploadArea" class="upload-area"
                                        onclick="document.getElementById('surat_pdf').click()">
                                        <span class="icon">📄</span>
                                        <div class="text">Seret & lepas file PDF di sini</div>
                                        <div class="sub-text">atau klik untuk memilih file</div>
                                        <div class="file-name" id="fileName">📎 <span id="fileNameText"></span>
                                        </div>
                                    </div>

                                    <input type="file" name="surat_pdf" id="surat_pdf" accept=".pdf" required
                                        style="display: none;" onchange="handleFileSelect(event)">

                                    <p class="text-xs text-gama-gray mt-2">* Format PDF, maks 5MB</p>
                                </div>

                                <!-- Tombol -->
                                <div class="flex flex-wrap gap-3">
                                    <button type="submit"
                                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                        📤 Upload Surat
                                    </button>
                                    <button type="button"
                                        onclick="window.location.href='{{ route('staff.applications') }}'"
                                        class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                                        Batal
                                    </button>
                                </div>
                            </form>

                            <!-- Jika sudah upload, tampilkan tombol Terbitkan -->
                            @if ($letter && $letter->pdf_path)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4">
                                        <p class="text-sm text-green-700">
                                            ✅ Surat sudah diupload: <strong>{{ basename($letter->pdf_path) }}</strong>
                                        </p>
                                    </div>
                                    <form action="{{ route('staff.application.terbitkan', $application->id) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                                            🚀 Terbitkan Surat
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @elseif($application->status == 'issued')
                        <div>
                            <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-3">Status Surat
                            </h3>
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                <p class="text-sm text-green-700">
                                    ✅ Surat sudah diterbitkan pada {{ $application->issued_at->format('d/m/Y H:i') }}
                                </p>
                                @if ($letter && $letter->pdf_path)
                                    <a href="{{ asset('storage/' . $letter->pdf_path) }}" target="_blank"
                                        class="mt-2 inline-block px-4 py-2 bg-gama-primary text-white rounded-lg text-sm hover:bg-[#1f3320] transition">
                                        📄 Lihat Surat
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

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
                @if ($application->user->ktp_path)
                    <img src="{{ asset('storage/' . $application->user->ktp_path) }}" alt="KTP"
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
                @if ($application->user->kk_path)
                    <img src="{{ asset('storage/' . $application->user->kk_path) }}" alt="KK"
                        class="w-full h-auto rounded-lg max-h-[500px] object-contain">
                @else
                    <p class="text-gama-gray">Belum ada KK</p>
                @endif
            </div>
        </div>
    </div>

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

    <!-- CSS & JAVASCRIPT                             -->
    <style>
        .upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #f8fafc;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .upload-area:hover {
            border-color: #5cb85c;
            background-color: #f0fdf4;
        }

        .upload-area.dragover {
            border-color: #5cb85c;
            background-color: #dcfce7;
            transform: scale(1.01);
        }

        .upload-area .icon {
            font-size: 48px;
            margin-bottom: 8px;
            display: block;
        }

        .upload-area .text {
            font-size: 16px;
            color: #475569;
        }

        .upload-area .sub-text {
            font-size: 14px;
            color: #94a3b8;
            margin-top: 4px;
        }

        .upload-area .file-name {
            font-weight: 600;
            color: #304d30;
            margin-top: 8px;
            display: none;
        }

        .upload-area.has-file {
            border-color: #5cb85c;
            background-color: #f0fdf4;
        }

        .upload-area.has-file .file-name {
            display: block;
        }
    </style>

    <script>
        // DRAG & DROP UPLOAD
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('surat_pdf');
        const fileNameText = document.getElementById('fileNameText');

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Highlight drop area
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => {
                uploadArea.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => {
                uploadArea.classList.remove('dragover');
            });
        });

        // Handle drop
        uploadArea.addEventListener('drop', function(e) {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect({
                    target: fileInput
                });
            }
        });

        // Handle file select from click
        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2);

                // Validate file type
                if (file.type !== 'application/pdf') {
                    alert('⚠️ Hanya file PDF yang diperbolehkan!');
                    fileInput.value = '';
                    uploadArea.classList.remove('has-file');
                    return;
                }

                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('⚠️ Ukuran file maksimal 5MB!');
                    fileInput.value = '';
                    uploadArea.classList.remove('has-file');
                    return;
                }

                fileNameText.textContent = `${fileName} (${fileSize} MB)`;
                uploadArea.classList.add('has-file');
            }
        }

        // PREVIEW KTP & KK
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

        // REJECT MODAL
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
