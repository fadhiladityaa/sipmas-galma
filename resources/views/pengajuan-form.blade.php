<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
            <div class="border-b border-gray-100 pb-4 mb-6">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h1 class="text-2xl font-bold text-gama-text">
                    {{ isset($service) ? 'Form Pengajuan: ' . $service->name : 'Form Pengajuan (Lainnya)' }}
                </h1>
                <p class="text-gama-gray text-sm mt-1">
                    Isi data di bawah. Data pribadi Anda sudah terisi otomatis.
                </p>
            </div>

            <form method="POST" action="{{ route('pengajuan.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Hidden untuk service_id -->
                @if (isset($service))
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                @else
                    <input type="hidden" name="service_id" value="">
                @endif

                <!-- Informasi Data Pribadi (read-only) -->
                <div class="bg-gama-bg/50 rounded-lg p-4 mb-6">
                    <h3 class="text-sm font-medium text-gama-text mb-2">Data Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                        <div><span class="text-gama-gray">Nama:</span> {{ Auth::user()->name }}</div>
                        <div><span class="text-gama-gray">NIK:</span> {{ Auth::user()->nik ?? '-' }}</div>
                        <div><span class="text-gama-gray">Email:</span> {{ Auth::user()->email }}</div>
                        <div><span class="text-gama-gray">No. HP:</span> {{ Auth::user()->nomor_hp ?? '-' }}</div>
                        <div class="md:col-span-2"><span class="text-gama-gray">Alamat:</span>
                            {{ Auth::user()->alamat ?? '-' }}</div>
                    </div>
                </div>

                <!-- Field Dinamis dari definisi service -->
                <!-- Field Dinamis dari definisi service -->
                @if (isset($service) && $service->fields)
                    @foreach (json_decode($service->fields, true) as $field)
                        <div class="mb-4">
                            <label for="field_{{ $field['name'] }}" class="block text-sm font-medium text-gama-text">
                                {{ $field['label'] }}
                                @if ($field['required'] ?? false)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>

                            @if ($field['type'] == 'text')
                                <input type="text" name="data[{{ $field['name'] }}]"
                                    id="field_{{ $field['name'] }}"
                                    class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent"
                                    @if ($field['required'] ?? false) required @endif>
                            @elseif($field['type'] == 'number')
                                <input type="number" name="data[{{ $field['name'] }}]"
                                    id="field_{{ $field['name'] }}"
                                    class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent"
                                    @if ($field['required'] ?? false) required @endif>
                            @elseif($field['type'] == 'date')
                                <input type="date" name="data[{{ $field['name'] }}]"
                                    id="field_{{ $field['name'] }}"
                                    class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent"
                                    @if ($field['required'] ?? false) required @endif>
                            @elseif($field['type'] == 'textarea')
                                <textarea name="data[{{ $field['name'] }}]" id="field_{{ $field['name'] }}" rows="3"
                                    class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent"
                                    @if ($field['required'] ?? false) required @endif></textarea>
                            @elseif($field['type'] == 'select')
                                <select name="data[{{ $field['name'] }}]" id="field_{{ $field['name'] }}"
                                    class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent"
                                    @if ($field['required'] ?? false) required @endif>
                                    <option value="">Pilih</option>
                                    @foreach ($field['options'] ?? [] as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    @endforeach
                @else
                    <!-- Custom: input nama surat -->
                    <div class="mb-4">
                        <label for="custom_service_name" class="block text-sm font-medium text-gama-text">
                            Nama Surat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="custom_service_name" id="custom_service_name" required
                            class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent"
                            placeholder="Tulis jenis surat yang Anda perlukan">
                    </div>
                @endif

                <!-- Catatan (opsional) -->
                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gama-text">Catatan (opsional)</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent"
                        placeholder="Tambahkan keterangan jika diperlukan"></textarea>
                </div>

                <!-- Dokumen Pendukung -->
                <!-- Dokumen Pendukung (dari Profil) -->
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gama-text mb-3">Dokumen Pendukung</h3>

                    <!-- KTP -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between bg-gama-bg/50 rounded-lg p-3">
                            <div class="flex items-center space-x-3">
                                <svg class="w-8 h-8 text-gama-primary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gama-text">KTP</p>
                                    @if (Auth::user()->ktp_path)
                                        <p class="text-xs text-gama-gray">✓ Dokumen tersimpan</p>
                                    @else
                                        <p class="text-xs text-red-500">⚠ Belum upload KTP di profil</p>
                                    @endif
                                </div>
                            </div>
                            @if (Auth::user()->ktp_path)
                                <button type="button" onclick="previewKTP()"
                                    class="text-sm text-gama-accent hover:text-gama-primary">
                                    Lihat Preview
                                </button>
                            @else
                                <a href="{{ route('profile.edit') }}"
                                    class="text-sm text-gama-accent hover:text-gama-primary">
                                    Upload di Profil
                                </a>
                            @endif
                        </div>
                        <!-- Hidden input untuk mengirimkan path KTP -->
                        <input type="hidden" name="ktp_path" value="{{ Auth::user()->ktp_path }}">
                    </div>

                    <!-- KK -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between bg-gama-bg/50 rounded-lg p-3">
                            <div class="flex items-center space-x-3">
                                <svg class="w-8 h-8 text-gama-primary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gama-text">KK</p>
                                    @if (Auth::user()->kk_path)
                                        <p class="text-xs text-gama-gray">✓ Dokumen tersimpan</p>
                                    @else
                                        <p class="text-xs text-red-500">⚠ Belum upload KK di profil</p>
                                    @endif
                                </div>
                            </div>
                            @if (Auth::user()->kk_path)
                                <button type="button" onclick="previewKK()"
                                    class="text-sm text-gama-accent hover:text-gama-primary">
                                    Lihat Preview
                                </button>
                            @else
                                <a href="{{ route('profile.edit') }}"
                                    class="text-sm text-gama-accent hover:text-gama-primary">
                                    Upload di Profil
                                </a>
                            @endif
                        </div>
                        <input type="hidden" name="kk_path" value="{{ Auth::user()->kk_path }}">
                    </div>

                    <!-- Catatan jika ada dokumen lain yang diperlukan -->
                    @if (isset($service) && $service->id)
                        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-xs text-yellow-700">
                                <span class="font-medium">Catatan:</span> Dokumen KTP dan KK akan diambil dari profil
                                Anda.
                                @if (!Auth::user()->ktp_path || !Auth::user()->kk_path)
                                    <span class="text-red-600">Silakan lengkapi di halaman profil terlebih
                                        dahulu.</span>
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Modal Preview KTP -->
                <div id="ktp-modal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center"
                    onclick="closePreview('ktp-modal')">
                    <div class="bg-white rounded-lg p-4 max-w-lg max-h-[90vh] overflow-auto"
                        onclick="event.stopPropagation()">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-semibold">Preview KTP</h3>
                            <button onclick="closePreview('ktp-modal')" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @if (Auth::user()->ktp_path)
                            <img src="{{ asset('storage/' . Auth::user()->ktp_path) }}" alt="KTP"
                                class="w-full h-auto rounded">
                        @else
                            <p class="text-center text-gray-500 py-8">Belum ada KTP</p>
                        @endif
                    </div>
                </div>

                <!-- Modal Preview KK -->
                <div id="kk-modal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center"
                    onclick="closePreview('kk-modal')">
                    <div class="bg-white rounded-lg p-4 max-w-lg max-h-[90vh] overflow-auto"
                        onclick="event.stopPropagation()">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-semibold">Preview KK</h3>
                            <button onclick="closePreview('kk-modal')" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        @if (Auth::user()->kk_path)
                            <img src="{{ asset('storage/' . Auth::user()->kk_path) }}" alt="KK"
                                class="w-full h-auto rounded">
                        @else
                            <p class="text-center text-gray-500 py-8">Belum ada KK</p>
                        @endif
                    </div>
                </div>

                <script>
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


                <!-- Tombol submit -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <a href="{{ route('pengajuan-surat') }}"
                        class="text-sm text-gama-gray hover:text-gama-primary transition">← Kembali</a>
                    <button type="submit"
                        class="px-6 py-2.5 bg-gama-primary hover:bg-[#1f3320] text-white font-medium rounded-lg transition shadow-sm hover:shadow">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
