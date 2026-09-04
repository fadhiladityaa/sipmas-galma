<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Notifikasi Error (jika ada) -->
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                    {!! session('error') !!}
                </div>
            @endif

            <!-- Progress Bar -->
            @php
                $user = Auth::user();
                $completed = 0;
                $total = 12;
                if ($user->nik) {
                    $completed++;
                }
                if ($user->tempat_lahir) {
                    $completed++;
                }

                if ($user->rw_id) {
                    $completed++;
                }

                if ($user->tanggal_lahir) {
                    $completed++;
                }
                if ($user->jenis_kelamin) {
                    $completed++;
                }
                if ($user->alamat) {
                    $completed++;
                }
                if ($user->agama) {
                    $completed++;
                }
                if ($user->pekerjaan) {
                    $completed++;
                }
                if ($user->nomor_hp) {
                    $completed++;
                }
                if ($user->ktp_path) {
                    $completed++;
                }
                if ($user->kk_path) {
                    $completed++;
                }
                if ($user->rt_id) {
                    $completed++;
                }
                $percent = round(($completed / $total) * 100);
            @endphp

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 bg-gama-bg/50 border-b">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gama-text">Kelengkapan Profil</p>
                            <p class="text-xs text-gama-gray">{{ $completed }} dari {{ $total }} data terisi
                            </p>
                        </div>
                        <span class="text-sm font-bold text-gama-primary">{{ $percent }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-gama-accent h-2 rounded-full transition-all duration-500"
                            style="width: {{ $percent }}%"></div>
                    </div>
                    @if ($percent < 100)
                        <p class="text-xs text-red-500 mt-2">Lengkapi semua data untuk dapat mengajukan surat.</p>
                    @else
                        <p class="text-xs text-green-600 mt-2">Semua data lengkap! Anda dapat mengajukan surat.</p>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gama-text mb-6">Informasi Profil</h2>
                    <p class="text-sm text-gama-gray mb-6">Lengkapi data diri Anda. Data ini akan digunakan otomatis
                        saat mengajukan surat.</p>

                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-11">
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-11">
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <div class="bg-white lg:hidden overflow-hidden shadow-sm sm:rounded-lg my-11">
                <div class="p-6">
                    @include('profile.partials.logout')
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
