<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-custom-blue text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg-px-8">
        <div class="flex items-center justify-between h-16">
            
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}">
                    <img class="h-8 w-auto" src="{{ asset('image/icon.png') }}" alt="Logo">
                </a>
            </div>
            <!-- Navbar -->

            {{-- Link navigasi utama --}}
            <div class="hidden md:flex md:items-center md:space-x-6">
                {{-- INI BAGIAN YANG DIPERBARUI --}}
                @guest
                    {{-- Tampil untuk Tamu (akan diredirect ke login oleh middleware) --}}
                    <a href="{{ route('report.step1.show') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Make a Report</a>
                    <a href="{{ route('consultation') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Consultation</a>
                    <a href="{{ route('community') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Community</a>
                    <a href="{{ route('information') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Information</a>
                @endguest
                
                @auth
                    {{-- Tampil untuk SEMUA role yang login (user DAN psychologist) --}}
                    <a href="{{ route('report.step1.show') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Make a Report</a>
                    <a href="{{ route('consultation') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Consultation</a>
                    <a href="{{ route('community') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Community</a>
                    <a href="{{ route('information') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Information</a>
                @endauth
                {{-- AKHIR BAGIAN YANG DIPERBARUI --}}
            </div>

            {{-- Bagian Autentikasi (Login/Register atau Dropdown Profil) --}}
            @guest
                {{-- Tampil jika pengguna adalah Tamu --}}
                <div class="hidden md:flex md:items-center md:space-x-3">
                    <a href="{{ route('register') }}" class="px-4 py-2 border border-white rounded-md text-sm font-medium transition-colors hover:bg-white hover:text-custom-blue">
                        Register
                    </a>
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-white text-custom-blue rounded-md text-sm font-medium transition-colors hover:bg-gray-100">
                        Login
                    </a>
                </div>
            @endguest

            @auth
                {{-- Tampil jika pengguna sudah Login (user ATAU psychologist) --}}
                <div class="hidden md:flex md:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            {{-- Tombol Trigger Dropdown (Profil) --}}
                            <button class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white hover:bg-opacity-10 focus:outline-none transition ease-in-out duration-150">
                                {{-- Placeholder Ikon Profil --}}
                                <div class="w-8 h-8 rounded-full bg-white bg-opacity-25 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Link Profil --}}
                            <x-dropdown-link :href="route('profile.show')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            {{-- Tombol Logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth
            
            {{-- Tombol Menu Mobile --}}
            <div class="-mr-2 flex md:hidden">
                <button @click="open = !open" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-300 hover:text-white hover:bg-white hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Buka menu utama</span>
                    <svg :class="{'hidden': open, 'block': !open }" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg :class="{'block': open, 'hidden': !open }" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- Menu Mobile --}}
    <div x-show="open" class="md:hidden" id="mobile-menu"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95">
        
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            {{-- INI BAGIAN YANG DIPERBARUI (MOBILE) --}}
            @guest
                {{-- Tampil untuk Tamu --}}
                <a href="{{ route('report.step1.show') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Make a Report</a>
                <a href="{{ route('consultation') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Consultation</a>
                <a href="{{ route('community') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Community</a>
                <a href="{{ route('information') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Information</a>
            @endguest
            @auth
                {{-- Tampil untuk SEMUA role yang login (user DAN psychologist) --}}
                <a href="{{ route('report.step1.show') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Make a Report</a>
                <a href="{{ route('consultation') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Consultation</a>
                <a href="{{ route('community') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Community</a>
                <a href="{{ route('information') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Information</a>
            @endauth
            {{-- AKHIR BAGIAN YANG DIPERBARUI (MOBILE) --}}
        </div>
        
        @guest
            {{-- Tombol Auth Mobile untuk Tamu --}}
            <div class="pt-3 pb-3 px-2 border-t border-gray-700 space-y-2">
                <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 border border-white rounded-md text-base font-medium transition-colors hover:bg-white hover:text-custom-blue">
                    Register
                </a>
                <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 bg-white text-custom-blue rounded-md text-base font-medium transition-colors hover:bg-gray-100">
                    Login
                </a>
            </div>
        @endguest

        @auth
            {{-- Menu Profil Mobile untuk Pengguna Login --}}
            <div class="pt-4 pb-3 border-t border-gray-700">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        {{-- Placeholder Ikon Profil --}}
                        <div class="w-10 h-10 rounded-full bg-white bg-opacity-25 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-300">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 px-2 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white hover:bg-opacity-10">{{ __('Profile') }}</a>
                    
                    {{-- Tombol Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white hover:bg-opacity-1s0">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>