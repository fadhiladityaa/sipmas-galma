<x-guest-layout>
    <div class="text-center space-y-4">
        <p class="text-gray-700">
            Anda sudah login sebagai <strong>{{ $user->name }}</strong>
            ({{ $user->nim ?? $user->role }}), Anda perlu logout terlebih dahulu
            sebelum login sebagai pengguna lain.
        </p>

        <div class="flex justify-center gap-3">
            <a href="{{ route($user->dashboardRouteName()) }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                Ke Dashboard
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">
                    Logout
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
