<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-custom-blue text-white shadow-md" style="font-family: 'Agrandir'">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg-px-8">
    <div class="flex justify-between items-center h-16">

      <a href="{{ route('home') }}" class="flex-shrink-0">
        <img class="h-8 w-auto" src="{{ asset('image/icon.png') }}" alt="Logo">
      </a>

      <div class="hidden md:flex items-center space-x-6">
        @foreach ([
          'home' => 'Home',
          'report.step1.show' => 'Make a Report',
          'consultation' => 'Consultation',
          'community' => 'Community',
          'information' => 'Information'
        ] as $route => $label)
          <a href="{{ route($route) }}" class="px-3 py-2 rounded-md text-md hover:bg-white hover:bg-opacity-10">
            {{ $label }}
          </a>
        @endforeach
      </div>

      <div class="hidden md:flex items-center space-x-3">
        @guest
          <a href="{{ route('register') }}" class="px-4 py-2 border border-white rounded-md text-sm hover:bg-white hover:text-custom-blue">
            Register
          </a>
          <a href="{{ route('login') }}" class="px-4 py-2 bg-white text-custom-blue rounded-md text-sm hover:bg-gray-100">
            Login
          </a>
        @endguest

        @auth
          <div x-data="{ menu: false }" @click.outside="menu = false" class="relative">
            <button @click="menu = !menu"
                    class="flex items-center px-4 py-2 rounded-md text-md hover:bg-white hover:text-custom-blue">
              <span>Hi, {{ Auth::user()->name }}</span>
              <svg class="ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
              </svg>
            </button>

            <div x-show="menu" x-cloak x-transition
                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 text-gray-700">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
              </form>
            </div>
          </div>
        @endauth
      </div>

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

  <div x-show="open" x-transition class="md:hidden" id="mobile-menu">

    <div class="px-2 pt-2 pb-3 space-y-1">
      @foreach ([
        'home' => 'Home',
        'report.step1.show' => 'Make a Report',
        'consultation' => 'Consultation',
        'community' => 'Community',
        'information' => 'Information'
      ] as $route => $label)
        <a href="{{ route($route) }}"
           class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10">
          {{ $label }}
        </a>
      @endforeach
    </div>

    <div class="pt-4 pb-3 border-t border-gray-700">
      @guest
        <div class="px-2 space-y-1">
          <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10">Register</a>
          <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base hover:bg-white hover:bg-opacity-10">Login</a>
        </div>
      @endguest

      @auth
        <div class="px-5">
          <div class="text-base">{{ Auth::user()->name }}</div>
          <div class="text-sm text-gray-300">{{ Auth::user()->email }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-3 px-2">
          @csrf
          <button class="block w-full px-3 py-2 rounded-md text-base text-left hover:bg-white hover:bg-opacity-10">
            Logout
          </button>
        </form>
      @endauth
    </div>
  </div>
</nav>
