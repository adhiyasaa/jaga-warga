<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-custom-blue text-white shadow-md" style="font-family: 'Agrandir'">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">

      <!-- Logo -->
      <a href="{{ route('home') }}" class="flex-shrink-0">
        <img class="h-8 w-auto" src="https://muabtceunyjvfxfkclzs.supabase.co/storage/v1/object/public/images/icon.png" alt="Logo">
      </a>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center space-x-6">
        @foreach ([
          'home' => 'Home',
          'report.step1.show' => 'Make a Report',
          'consultation' => 'Consultation',
          'community' => 'Community',
          'information' => 'Information'
        ] as $route => $label)
          @php
            $isPsychologist = Auth::check() && Auth::user()->role === 'Psychologist';
            
            // 1. Hapus menu 'Make a Report' untuk Psikolog
            if ($route === 'report.step1.show' && $isPsychologist) {
                continue;
            }

            // 2. Ubah nama 'Consultation' jadi 'Client Chat' khusus Psikolog
            if ($route === 'consultation' && $isPsychologist) {
                $label = 'Client Chat'; 
            }
          @endphp
          <a href="{{ route($route) }}" class="px-3 py-2 rounded-md text-md hover:bg-white hover:bg-opacity-10 transition">{{ $label }}</a>
        @endforeach
      </div>

      <!-- Auth Buttons -->
      <div class="hidden md:flex items-center space-x-3">
        @guest
          <a href="{{ route('register') }}" class="px-4 py-2 border border-white rounded-md text-sm hover:bg-white hover:text-custom-blue transition">Register</a>
          <a href="{{ route('login') }}" class="px-4 py-2 bg-white text-custom-blue rounded-md text-sm hover:bg-gray-100 transition">Login</a>
        @endguest

        @auth
          <div x-data="{ menu: false }" @click.outside="menu = false" class="relative">
            <button @click="menu = !menu" class="flex items-center gap-3 px-3 py-2 rounded-md text-md hover:bg-white hover:bg-opacity-10 transition focus:outline-none">
              
              {{-- TAMPILKAN FOTO PROFIL --}}
              <div class="h-8 w-8 relative">
                  @if(Auth::user()->avatar_url)
                      <img class="h-8 w-8 rounded-full object-cover border border-white/50" 
                           src="{{ Auth::user()->avatar_url }}" 
                           alt="{{ Auth::user()->name }}">
                  @else
                      <img class="h-8 w-8 rounded-full border border-white/50" 
                           src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff&size=128" 
                           alt="{{ Auth::user()->name }}">
                  @endif
              </div>

              <span class="font-medium">{{ Auth::user()->name }}</span>
              
              <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
              </svg>
            </button>

            {{-- Dropdown Menu --}}
            <div x-show="menu" x-cloak x-transition 
                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 text-gray-700 z-50 origin-top-right ring-1 ring-black ring-opacity-5">
              
              <div class="px-4 py-2 border-b border-gray-100">
                  <p class="text-xs text-gray-500">Signed in as</p>
                  <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email }}</p>
              </div>

              <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 transition">My Profile</a>
              <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 transition">Settings</a>
              
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 text-red-600 transition">Logout</button>
              </form>
            </div>
          </div>
        @endauth
      </div>

      <!-- Mobile Menu Button -->
      <button @click="open = !open" class="md:hidden p-2 rounded-md text-gray-300 hover:bg-white hover:bg-opacity-10 focus:outline-none">
        <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg x-show="open" class="h-6 w-6" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

    </div>
  </div>

  <!-- Mobile Menu -->
  <div x-show="open" x-transition class="md:hidden bg-custom-blue border-t border-white/10" id="mobile-menu">
    <div class="px-2 pt-2 pb-3 space-y-1">
      @foreach ([
        'home' => 'Home',
        'report.step1.show' => 'Make a Report',
        'consultation' => 'Consultation',
        'community' => 'Community',
        'information' => 'Information'
      ] as $route => $label)
        @php
            $isPsychologist = Auth::check() && Auth::user()->role === 'Psychologist';
            
            if ($route === 'report.step1.show' && $isPsychologist) {
                continue;
            }
            
            if ($route === 'consultation' && $isPsychologist) {
                $label = 'Client Chat'; 
            }
        @endphp
        <a href="{{ route($route) }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10 transition">{{ $label }}</a>
      @endforeach
    </div>

    <div class="pt-4 pb-3 border-t border-white/10">
      @guest
        <div class="px-2 space-y-1">
            <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10 transition">Register</a>
            <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10 transition">Login</a>
        </div>
      @endguest

      @auth
        <div class="flex items-center px-5 mb-3">
            {{-- FOTO PROFIL MOBILE --}}
            <div class="flex-shrink-0">
                @if(Auth::user()->avatar_url)
                    <img class="h-10 w-10 rounded-full object-cover border-2 border-white/30" 
                         src="{{ Auth::user()->avatar_url }}" 
                         alt="{{ Auth::user()->name }}">
                @else
                    <img class="h-10 w-10 rounded-full border-2 border-white/30" 
                         src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff&size=128" 
                         alt="{{ Auth::user()->name }}">
                @endif
            </div>
            <div class="ml-3">
                <div class="text-base font-medium leading-none text-white">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium leading-none text-gray-300 mt-1">{{ Auth::user()->email }}</div>
            </div>
        </div>

        <div class="mt-3 px-2 space-y-1">
          <a href="{{ route('profile.show') }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10 transition">My Profile</a>
          <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10 transition">Settings</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="block w-full text-left px-3 py-2 rounded-md text-base hover:bg-red-500 hover:text-white text-red-200 transition">Logout</button>
          </form>
        </div>
      @endauth
    </div>
  </div>
</nav>