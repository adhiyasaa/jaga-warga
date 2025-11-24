<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-custom-blue text-white shadow-md font-sans">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">

      <!-- Logo -->
      <div class="flex-shrink-0 flex items-center">
        <a href="{{ route('home') }}">
          <img class="h-8 w-auto" src="{{ asset('image/icon.png') }}" alt="Logo" 
               onerror="this.onerror=null; this.src=''; this.outerHTML='<span class=\'font-bold text-xl\'>Jaga Warga</span>'">
        </a>
      </div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center space-x-6">
        
        {{-- LOGIKA: Tampilkan Make a Report HANYA jika Guest ATAU bukan Psikolog --}}
        @if(!Auth::check() || Auth::user()->role !== 'psychologist')
            <a href="{{ route('report.step1.show') }}" class="px-3 py-2 rounded-md text-md hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('report*') ? 'bg-white bg-opacity-20 font-bold' : '' }}">
                Make a Report
            </a>
        @endif

        <a href="{{ route('consultation') }}" class="px-3 py-2 rounded-md text-md hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('consultation*') || request()->routeIs('chat*') ? 'bg-white bg-opacity-20 font-bold' : '' }}">
            Consultation
        </a>
        <a href="{{ route('community') }}" class="px-3 py-2 rounded-md text-md hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('community*') ? 'bg-white bg-opacity-20 font-bold' : '' }}">
            Community
        </a>

        {{-- Public Links --}}
        <a href="{{ route('information') }}" class="px-3 py-2 rounded-md text-md hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('information') ? 'bg-white bg-opacity-20 font-bold' : '' }}">
            Information
        </a>
      </div>

      <!-- Right Side (Login/Register/Profile) -->
      <div class="hidden md:flex items-center space-x-3">
        @guest
          <a href="{{ route('register') }}" class="px-4 py-2 border border-white rounded-md text-sm hover:bg-white hover:text-custom-blue transition">
            Register
          </a>
          <a href="{{ route('login') }}" class="px-4 py-2 bg-white text-custom-blue rounded-md text-sm hover:bg-gray-100 transition">
            Login
          </a>
        @endguest

        @auth
          <div x-data="{ menu: false }" @click.outside="menu = false" class="relative">
            <button @click="menu = !menu"
                    class="flex items-center px-4 py-2 rounded-md text-md hover:bg-white hover:bg-opacity-10 transition">
              <span>Hi, {{ Auth::user()->name }}</span>
              <svg class="ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
              </svg>
            </button>

            <div x-show="menu" x-cloak 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 text-gray-700 ring-1 ring-black ring-opacity-5 z-50 font-sans">
              
              <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                  My Profile
              </a>
              
              <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">
                  Settings
              </a>
              
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 text-red-600">
                    Logout
                </button>
              </form>
            </div>
          </div>
        @endauth
      </div>

      <!-- Mobile Menu Button -->
      <button @click="open = !open"
              class="md:hidden p-2 rounded-md text-gray-300 hover:bg-white hover:bg-opacity-10">
        <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg x-show="open" class="h-6 w-6" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

    </div>
  </div>

  <!-- Mobile Menu -->
  <div x-show="open" x-transition class="md:hidden bg-custom-blue border-t border-white border-opacity-10" id="mobile-menu">
    <div class="px-2 pt-2 pb-3 space-y-1 font-sans">
      
      {{-- LOGIKA MOBILE: Sama seperti desktop, sembunyikan jika Psikolog --}}
      @if(!Auth::check() || Auth::user()->role !== 'psychologist')
          <a href="{{ route('report.step1.show') }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10">Make a Report</a>
      @endif

      <a href="{{ route('consultation') }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10">Consultation</a>
      <a href="{{ route('community') }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10">Community</a>
      
      <a href="{{ route('information') }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10">Information</a>
    </div>

    <div class="pt-4 pb-3 border-t border-white border-opacity-10 font-sans">
      @guest
        <div class="px-2 space-y-1">
          <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10">Register</a>
          <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10">Login</a>
        </div>
      @endguest

      @auth
        <div class="px-5">
          <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
          <div class="text-sm text-blue-200">{{ Auth::user()->email }}</div>
        </div>
        <div class="mt-3 px-2 space-y-1">
            <a href="{{ route('profile.show') }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10">My Profile</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="block w-full text-left px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10">
                Logout
              </button>
            </form>
        </div>
      @endauth
    </div>
  </div>
</nav>