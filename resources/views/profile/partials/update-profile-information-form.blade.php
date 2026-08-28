<form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <!-- Data Diri -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Nama Lengkap -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Pilih RT -->
        <div>
            <x-input-label for="rt_id" :value="__('RT')" />
            <select id="rt_id" name="rt_id"
                class="mt-1 block w-full border-gray-300 focus:border-gama-accent focus:ring-gama-accent rounded-md shadow-sm">
                <option value="">Pilih RT</option>
                @foreach ($rts as $rt)
                    <option value="{{ $rt->id }}" @selected(old('rt_id', $user->rt_id) == $rt->id)>
                        {{ $rt->full_name }} {{ $rt->alamat ? '- ' . $rt->alamat : '' }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('rt_id')" />
        </div>

        {{-- pilih rw --}}
        <div>
            <x-input-label for="rw_id" :value="__('RW')" />
            <select id="rw_id" name="rw_id"
                class="mt-1 block w-full border-gray-300 focus:border-gama-accent focus:ring-gama-accent rounded-md shadow-sm">
                <option value="">Pilih RW</option>
                @foreach ($rws as $rt)
                    <option value="{{ $rt->id }}" @selected(old('rw_id', $user->rw_id) == $rt->id)>
                        {{ $rt->full_name }} {{ $rt->alamat ? '- ' . $rt->alamat : '' }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('rw_id')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- NIK -->
        <div>
            <x-input-label for="nik" :value="__('NIK')" />
            <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full" :value="old('nik', $user->nik)" />
            <x-input-error class="mt-2" :messages="$errors->get('nik')" />
        </div>

        <!-- Nomor HP -->
        <div>
            <x-input-label for="nomor_hp" :value="__('Nomor HP')" />
            <x-text-input id="nomor_hp" name="nomor_hp" type="text" class="mt-1 block w-full" :value="old('nomor_hp', $user->nomor_hp)" />
            <x-input-error class="mt-2" :messages="$errors->get('nomor_hp')" />
        </div>

        <!-- Tempat Lahir -->
        <div>
            <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
            <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full"
                :value="old('tempat_lahir', $user->tempat_lahir)" />
            <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir')" />
        </div>

        <!-- Tanggal Lahir -->
        <div>
            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
            <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full"
                :value="old('tanggal_lahir', $user->tanggal_lahir?->format('Y-m-d'))" />
            <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
        </div>

        <!-- Jenis Kelamin -->
        <div>
            <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
            <select id="jenis_kelamin" name="jenis_kelamin"
                class="mt-1 block w-full border-gray-300 focus:border-gama-accent focus:ring-gama-accent rounded-md shadow-sm">
                <option value="">Pilih</option>
                <option value="L" @selected(old('jenis_kelamin', $user->jenis_kelamin) == 'L')>Laki-laki</option>
                <option value="P" @selected(old('jenis_kelamin', $user->jenis_kelamin) == 'P')>Perempuan</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
        </div>

        <!-- Agama -->
        <div>
            <x-input-label for="agama" :value="__('Agama')" />
            <select id="agama" name="agama"
                class="mt-1 block w-full border-gray-300 focus:border-gama-accent focus:ring-gama-accent rounded-md shadow-sm">
                <option value="">Pilih</option>
                <option value="Islam" @selected(old('agama', $user->agama) == 'Islam')>Islam</option>
                <option value="Kristen" @selected(old('agama', $user->agama) == 'Kristen')>Kristen</option>
                <option value="Katolik" @selected(old('agama', $user->agama) == 'Katolik')>Katolik</option>
                <option value="Hindu" @selected(old('agama', $user->agama) == 'Hindu')>Hindu</option>
                <option value="Buddha" @selected(old('agama', $user->agama) == 'Buddha')>Buddha</option>
                <option value="Konghucu" @selected(old('agama', $user->agama) == 'Konghucu')>Konghucu</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('agama')" />
        </div>

        <!-- Pekerjaan -->
        <div>
            <x-input-label for="pekerjaan" :value="__('Pekerjaan')" />
            <x-text-input id="pekerjaan" name="pekerjaan" type="text" class="mt-1 block w-full" :value="old('pekerjaan', $user->pekerjaan)" />
            <x-input-error class="mt-2" :messages="$errors->get('pekerjaan')" />
        </div>

        <!-- Alamat (full width) -->
        <div class="md:col-span-2">
            <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
            <textarea id="alamat" name="alamat" rows="3"
                class="mt-1 block w-full border-gray-300 focus:border-gama-accent focus:ring-gama-accent rounded-md shadow-sm">{{ old('alamat', $user->alamat) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
        </div>
    </div>

    <hr class="my-6">

    <!-- Upload KTP -->
    <div>
        <h3 class="text-lg font-medium text-gama-text mb-3">Dokumen KTP</h3>
        <div class="flex flex-col md:flex-row gap-6">
            <div class="flex-1">
                <x-input-label for="ktp" :value="__('Upload KTP (max 2MB, JPG/PNG)')" />
                <input type="file" id="ktp" name="ktp" accept=".jpg,.jpeg,.png"
                    class="mt-1 block w-full text-sm text-gama-gray file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gama-primary/10 file:text-gama-primary hover:file:bg-gama-primary/20"
                    onchange="previewImage(this, 'ktp-preview')" />
                <x-input-error class="mt-2" :messages="$errors->get('ktp')" />
                <p class="text-xs text-gama-gray mt-1">* Kosongkan jika tidak ingin mengubah</p>
            </div>
            <div class="flex-shrink-0">
                <p class="text-sm font-medium text-gama-text mb-2">Preview KTP</p>
                <div id="ktp-preview-container"
                    class="w-40 h-52 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                    @if ($user->ktp_path)
                        <img src="{{ asset('storage/' . $user->ktp_path) }}" id="ktp-preview"
                            class="w-full h-full object-cover" alt="KTP">
                    @else
                        <span class="text-gray-400 text-sm" id="ktp-placeholder">Belum ada KTP</span>
                        <img src="" id="ktp-preview" class="w-full h-full object-cover hidden"
                            alt="Preview KTP">
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Upload KK -->
    <div>
        <h3 class="text-lg font-medium text-gama-text mb-3">Dokumen KK</h3>
        <div class="flex flex-col md:flex-row gap-6">
            <div class="flex-1">
                <x-input-label for="kk" :value="__('Upload KK (max 2MB, JPG/PNG)')" />
                <input type="file" id="kk" name="kk" accept=".jpg,.jpeg,.png"
                    class="mt-1 block w-full text-sm text-gama-gray file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gama-primary/10 file:text-gama-primary hover:file:bg-gama-primary/20"
                    onchange="previewImage(this, 'kk-preview')" />
                <x-input-error class="mt-2" :messages="$errors->get('kk')" />
                <p class="text-xs text-gama-gray mt-1">* Kosongkan jika tidak ingin mengubah</p>
            </div>
            <div class="flex-shrink-0">
                <p class="text-sm font-medium text-gama-text mb-2">Preview KK</p>
                <div id="kk-preview-container"
                    class="w-40 h-52 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                    @if ($user->kk_path)
                        <img src="{{ asset('storage/' . $user->kk_path) }}" id="kk-preview"
                            class="w-full h-full object-cover" alt="KK">
                    @else
                        <span class="text-gray-400 text-sm" id="kk-placeholder">Belum ada KK</span>
                        <img src="" id="kk-preview" class="w-full h-full object-cover hidden"
                            alt="Preview KK">
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-4 pt-4">
        <x-primary-button>{{ __('Simpan Profile') }}</x-primary-button>

        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                class="text-sm text-green-600">
                {{ __('Profile berhasil diperbarui.') }}
            </p>
        @endif
    </div>
</form>

<!-- JavaScript Preview -->
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const placeholder = document.getElementById(previewId.replace('-preview', '-placeholder'));
        const container = document.getElementById(previewId + '-container');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            // Jika file dihapus, tampilkan placeholder
            if (!preview.src || preview.src === '') {
                preview.classList.add('hidden');
                if (placeholder) placeholder.style.display = 'block';
            }
        }
    }
</script>
