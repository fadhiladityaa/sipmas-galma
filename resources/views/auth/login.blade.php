<x-guest-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h2 class="text-2xl font-bold text-gama-text">Silahkan Login</h2>
            <p class="text-sm text-gama-gray mt-1">Masuk menggunakan akun yang telah anda buat!</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gama-text font-medium text-sm" />
                <x-text-input id="email"
                    class="block mt-1 w-full border-gray-200 focus:border-gama-accent focus:ring-gama-accent rounded-lg"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    placeholder="nama@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-gama-text font-medium text-sm" />
                <x-text-input id="password"
                    class="block mt-1 w-full border-gray-200 focus:border-gama-accent focus:ring-gama-accent rounded-lg"
                    type="password" name="password" required autocomplete="current-password"
                    placeholder="Masukkan kata sandi" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember & Lupa Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-gama-accent shadow-sm focus:ring-gama-accent"
                        name="remember">
                    <span class="ms-2 text-sm text-gama-text">{{ __('Ingat saya') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-gama-accent hover:text-gama-primary font-medium"
                        href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>

            <!-- Tombol Login -->
            <button type="submit"
                class="w-full bg-gama-primary hover:bg-[#1f3320] text-white font-semibold py-2.5 rounded-lg transition duration-200">
                MASUK
            </button>
        </form>

        <!-- Link Register -->
        <p class="text-center text-sm text-gama-text">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium text-gama-accent hover:text-gama-primary">
                Daftar di sini
            </a>
        </p>
    </div>
</x-guest-layout>
