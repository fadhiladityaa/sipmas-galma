<nav
    class="bg-gama-primary border-b-2 border-gama-gold/40 shadow-lg shadow-gama-primary/20 lg:sticky top-0 z-50 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Desktop (lg ke atas) -->
        <div class="hidden lg:flex items-center justify-between h-20">
            <!-- Brand desktop -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <img class="h-12 w-auto rounded-full p-[.10rem] bg-white/50" src="{{ asset('img/logo-galma.png') }}"
                        alt="Logo Kelurahan">
                    <img class="h-12 w-auto rounded-full p-[.10rem] bg-white/50" src="{{ asset('img/logo-ith.png') }}"
                        alt="Logo Kampus">
                </div>
                <div class="leading-tight">
                    <h1 class="text-lg font-bold text-white tracking-tight">SIPMAS Galung Maloang</h1>
                    <p class="text-sm text-gama-secondary">Sistem Informasi Pelayanan Masyarakat
                    </p>
                </div>
            </div>

            <!-- Menu desktop (DENGAN INDIKATOR AKTIF) -->
            <div class="flex items-center space-x-6 text-slate-400">

                {{-- navigasi warga --}}

                @auth
                    @if (Auth::user()->role == 'warga')
                        <a href="{{ route('warga.home') }}"
                            class="nav-link {{ request()->routeIs('warga.home*') ? 'text-white' : '' }}">
                            <span>Home</span>
                        </a>
                    @endif
                @endauth

                @auth
                    @if (Auth::user()->role == 'warga')
                        <a href="{{ route('warga.pengajuan-surat') }}"
                            class="nav-link {{ request()->routeIs('warga.pengajuan-surat*') ? 'text-white' : '' }}">
                            <span>Pengajuan</span>
                        </a>
                    @endif
                @endauth

                @auth
                    @if (Auth::user()->role == 'warga')
                        <a href="{{ route('warga.riwayat') }}"
                            class="nav-link {{ request()->routeIs('warga.riwayat*') ? 'text-white' : '' }}">
                            <span>Riwayat</span>
                        </a>
                    @endif
                @endauth
                {{-- end navigasi warga --}}

                {{-- navigasi rt --}}
                @auth
                    @if (Auth::user()->role == 'rt')
                        <a href="{{ route('rt.dashboard') }}"
                            class="nav-link {{ request()->routeIs('rt.dashboard*') ? 'text-white' : '' }}">
                            <span>Dashboard</span>
                        </a>
                    @endif
                @endauth

                @auth
                    @if (Auth::user()->role == 'rt')
                        <a href="{{ route('rt.applications') }}"
                            class="nav-link {{ request()->routeIs('rt.applications*') ? 'text-white' : '' }}">
                            <span>Daftar Pengajuan</span>
                        </a>
                    @endif
                @endauth
                {{-- end navigasi rt --}}

                {{-- navigasi staff --}}
                @auth
                    @if (Auth::user()->role == 'staff')
                        <a href="{{ route('staff.dashboard') }}"
                            class="nav-link {{ request()->routeIs('staff.dashboard*') ? 'text-white' : '' }}">
                            <span>Dashboard</span>
                        </a>
                    @endif
                @endauth

                @auth
                    @if (Auth::user()->role == 'staff')
                        <a href="{{ route('staff.applications') }}"
                            class="nav-link {{ request()->routeIs('staff.applications*') ? 'text-white' : '' }}">
                            <span>Pengajuan</span>
                        </a>
                    @endif
                @endauth

                @auth
                    @if (Auth::user()->role == 'staff')
                        <a href="{{ route('staff.riwayat') }}"
                            class="nav-link {{ request()->routeIs('staff.riwayat*') ? 'text-white' : '' }}">
                            <span>Riwayat Pengajuan</span>
                        </a>
                    @endif
                @endauth
                {{-- end navigasi staff --}}

            </div>

            <!-- Profile desktop -->
            <div x-data="{ open: false }" class="hidden lg:flex items-center space-x-4">
                <div class="relative group">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 bg-white/10 hover:bg-white/20 rounded-full px-3 py-1.5 transition border border-white/10">
                        <div
                            class="w-8 h-8 rounded-full bg-gama-accent text-white flex items-center justify-center text-sm font-bold shadow">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'User' }}</span>
                        <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Dropdown -->
                    <div x-show="open"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gama-text hover:bg-gama-bg transition">
                            <svg class="w-4 h-4 inline mr-2 text-gama-gray" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>
                        <a href="" class="block px-4 py-2 text-sm text-gama-text hover:bg-gama-bg transition">
                            <svg class="w-4 h-4 inline mr-2 text-gama-gray" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Pengaturan
                        </a>
                        <hr class="my-1 border-gray-200">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gama-bg transition">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- MOBILE HEADER -->
        <div class="lg:hidden relative flex items-center justify-center py-3">
            <div class="flex flex-col items-center text-center">
                <div class="flex items-center space-x-3">
                    <img class="h-10 w-auto rounded-full p-[.10rem] bg-white/50"
                        src="{{ asset('img/logo-galma.png') }}" alt="Logo Kelurahan">
                    <img class="h-10 w-auto rounded-full p-[.10rem] bg-white/50" src="{{ asset('img/logo-ith.png') }}"
                        alt="Logo Kampus">
                </div>
                <div class="leading-tight mt-1">
                    <h1 class="text-sm font-bold text-white tracking-tight">SIPMAS Galung Maloang</h1>
                    <p class="text-[10px] text-gama-secondary">Sistem Informasi Pelayanan Masyarakat</p>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Bottom Navigation untuk Mobile -->
<div
    class="lg:hidden fixed bottom-0 left-0 text-slate-300 right-0 bg-gama-primary border-t-2 border-gama-gold/40 shadow-lg shadow-gama-primary/20 z-50">
    <div class="flex items-center justify-around h-16 px-2">
        <!-- Ajukan Surat -->
        <a href="{{ route('warga.home') }}"
            class="bottom-nav-link flex flex-col items-center space-y-0.5 {{ request()->routeIs('home') ? 'active' : '' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span class="text-[10px] font-medium">Ajukan Surat</span>
        </a>
        <!-- Riwayat -->
        <a href="{{ route('warga.riwayat') }}"
            class="bottom-nav-link flex flex-col items-center space-y-0.5 {{ request()->routeIs('warga.riwayat*') ? 'active' : '' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="text-[10px] font-medium">Riwayat</span>
        </a>

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}"
            class="bottom-nav-link flex flex-col items-center space-y-0.5 {{ request()->routeIs('profile*') ? 'active' : '' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-[10px] font-medium">Profile</span>
        </a>
    </div>
</div>

<!-- Style -->
<style>
    .nav-link {
        @apply flex items-center space-x-2 px-3 py-2 rounded-lg text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all duration-200;
    }

    .nav-link.active {
        @apply bg-white/20 text-white shadow-sm font-semibold;
    }

    .nav-link.active svg {
        @apply text-gama-gold;
    }

    .nav-link svg {
        @apply text-white/60;
    }

    .nav-link:hover svg {
        @apply text-white;
    }

    .nav-link.active:hover {
        @apply bg-white/30;
    }

    .bottom-nav-link {
        @apply text-white/60 hover:text-white transition py-1 px-3 rounded-lg hover:bg-white/10;
    }

    .bottom-nav-link.active {
        @apply text-gama-gold font-semibold;
    }

    .bottom-nav-link.active svg {
        @apply text-gama-gold;
    }

    .bottom-nav-link svg {
        @apply text-white/60;
    }

    .bottom-nav-link:hover svg {
        @apply text-white;
    }

    .bottom-nav-link.active:hover {
        @apply text-gama-gold;
    }
</style>
