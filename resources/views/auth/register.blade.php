<x-guest-layout>
    <div class="space-y-6">
        <!-- Header Form -->
        <div>
            <h2 class="text-2xl font-bold text-gama-text">Daftar Akun</h2>
            <p class="text-sm text-gama-gray mt-1">Silahkan isi sesuai dengan data diri anda!</p>
        </div>

        <!-- Form Register -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Nama -->
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gama-text font-medium text-sm" />
                <x-text-input id="name"
                    class="block mt-1 w-full border-gray-200 focus:border-gama-accent focus:ring-gama-accent rounded-lg"
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                    placeholder="Masukkan nama lengkap" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gama-text font-medium text-sm" />
                <x-text-input id="email"
                    class="block mt-1 w-full border-gray-200 focus:border-gama-accent focus:ring-gama-accent rounded-lg"
                    type="email" name="email" :value="old('email')" required autocomplete="username"
                    placeholder="nama@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Kata Sandi')" class="text-gama-text font-medium text-sm" />
                <x-text-input id="password"
                    class="block mt-1 w-full border-gray-200 focus:border-gama-accent focus:ring-gama-accent rounded-lg"
                    type="password" name="password" required autocomplete="new-password"
                    placeholder="Minimal 8 karakter" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')"
                    class="text-gama-text font-medium text-sm" />
                <x-text-input id="password_confirmation"
                    class="block mt-1 w-full border-gray-200 focus:border-gama-accent focus:ring-gama-accent rounded-lg"
                    type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="Ulangi kata sandi" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Tombol Daftar -->
            <button type="submit"
                class="w-full bg-gama-primary hover:bg-[#1f3320] text-white font-semibold py-2.5 rounded-lg transition duration-200">
                Daftar
            </button>
        </form>

        <!-- Link ke Login -->
        <p class="text-center text-sm text-gama-text">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium text-gama-accent hover:text-gama-primary">
                Masuk di sini
            </a>
        </p>
    </div>
</x-guest-layout>
