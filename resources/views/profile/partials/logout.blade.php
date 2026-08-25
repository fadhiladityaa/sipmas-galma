<section class="flex flex-col gap-3">
    <h2 class="text-lg font-medium text-gray-900">
        {{ __('Logout') }}
    </h2>
    <p class="font-normal text-sm
     text-gray-900">
        {{ __('Tekan tombol ini untuk keluar dari akun anda!') }}
    </p>
    <form class="lg:hidden mr-0 w-" method="POST" action="{{ route('logout') }}">
        @csrf
        <x-primary-button type="submit"
            class="w-1/3 text-left px-4 py-2 text-sm text-red-600 hover:bg-gama-bg transition">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Logout
        </x-primary-button>
    </form>
</section>
