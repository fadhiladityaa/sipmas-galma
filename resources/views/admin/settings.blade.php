@php use App\Models\Setting; @endphp

<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h1 class="text-2xl font-bold text-gama-text mb-6">⚙️ Pengaturan Surat</h1>
                <p class="text-sm text-gama-gray mb-6">Kelola data Lurah dan barcode yang akan muncul di surat.</p>

                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Data Lurah -->
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-3">Data Lurah</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="lurah_name" class="block text-sm font-medium text-gama-text">Nama
                                    Lurah</label>
                                <input type="text" name="lurah_name" id="lurah_name"
                                    value="{{ Setting::get('lurah_name', '') }}"
                                    class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent">
                            </div>
                            <div>
                                <label for="lurah_pangkat"
                                    class="block text-sm font-medium text-gama-text">Pangkat</label>
                                <input type="text" name="lurah_pangkat" id="lurah_pangkat"
                                    value="{{ Setting::get('lurah_pangkat', '') }}"
                                    class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent">
                            </div>
                            <div>
                                <label for="lurah_nip" class="block text-sm font-medium text-gama-text">NIP</label>
                                <input type="text" name="lurah_nip" id="lurah_nip"
                                    value="{{ Setting::get('lurah_nip', '') }}"
                                    class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent">
                            </div>
                        </div>
                    </div>

                    <!-- Barcode -->
                    <div class="mb-6 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-3">Barcode Lurah
                        </h3>

                        <!-- Preview barcode saat ini -->
                        <div class="bg-gama-bg/60 rounded-xl p-4 border border-gray-100 mb-4">
                            <p class="text-xs text-gama-gray mb-2">Barcode Saat Ini:</p>
                            @php $barcodeImage = Setting::get('barcode_image'); @endphp
                            @if ($barcodeImage && Storage::disk('public')->exists($barcodeImage))
                                <img src="{{ asset('storage/' . $barcodeImage) }}" alt="Barcode"
                                    style="max-height: 100px; width: auto;">
                                <p class="text-xs text-green-600 mt-2">✓ Barcode tersedia</p>
                            @else
                                <p class="text-sm text-gama-gray">Belum ada barcode yang diupload</p>
                            @endif
                        </div>

                        <!-- Upload barcode baru -->
                        <div>
                            <label for="barcode_image" class="block text-sm font-medium text-gama-text">
                                Upload Barcode Baru
                            </label>
                            <input type="file" name="barcode_image" id="barcode_image" accept=".png,.jpg,.jpeg"
                                class="mt-1 block w-full text-sm text-gama-gray file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gama-primary/10 file:text-gama-primary hover:file:bg-gama-primary/20">
                            <p class="text-xs text-gama-gray mt-1">* Format: PNG/JPG, maks 2MB</p>
                            <p class="text-xs text-gama-gray">* Kosongkan jika tidak ingin mengubah</p>
                        </div>
                    </div>

                    <!-- Kop Surat -->
                    <div class="mb-6 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gama-text uppercase tracking-wider mb-3">Kop Surat</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="kop_alamat" class="block text-sm font-medium text-gama-text">Alamat</label>
                                <input type="text" name="kop_alamat" id="kop_alamat"
                                    value="{{ Setting::get('kop_alamat', '') }}"
                                    class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent">
                            </div>
                            <div>
                                <label for="kop_telepon"
                                    class="block text-sm font-medium text-gama-text">Telepon</label>
                                <input type="text" name="kop_telepon" id="kop_telepon"
                                    value="{{ Setting::get('kop_telepon', '') }}"
                                    class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent">
                            </div>
                            <div>
                                <label for="kop_kota" class="block text-sm font-medium text-gama-text">Kota</label>
                                <input type="text" name="kop_kota" id="kop_kota"
                                    value="{{ Setting::get('kop_kota', '') }}"
                                    class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent">
                            </div>
                            <div>
                                <label for="kop_kode_pos" class="block text-sm font-medium text-gama-text">Kode
                                    Pos</label>
                                <input type="text" name="kop_kode_pos" id="kop_kode_pos"
                                    value="{{ Setting::get('kop_kode_pos', '') }}"
                                    class="mt-1 block w-full border-gray-200 rounded-lg focus:border-gama-accent focus:ring-gama-accent">
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="px-6 py-2.5 bg-gama-primary hover:bg-[#1f3320] text-white font-medium rounded-lg transition">
                        💾 Simpan Pengaturan
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
