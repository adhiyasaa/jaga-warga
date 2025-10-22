<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-custom-blue text-white shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg-px-8">
    <div class="flex items-center justify-between h-16">
      
      <div class="flex-shrink-0">
        <a href="{{ route('home') }}">
          <img class="h-8 w-auto" src="{{ asset('image/icon.png') }}" alt="Logo">
        </a>
      </div>

      {{-- Link sekarang menggunakan helper route() untuk navigasi --}}
      <div class="hidden md:flex md:items-center md:space-x-6">
        <a href="{{ route('report') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Make a Report</a>
        <a href="{{ route('consultation') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Consultation</a>
        <a href="{{ route('community') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Community</a>
        <a href="{{ route('information') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white hover:bg-opacity-10">Information</a>
      </div>

      <div class="hidden md:flex md:items-center md:space-x-3">
        {{-- Menggunakan route 'register' dan 'login' dari Breeze --}}
        <a href="{{ route('register') }}" class="px-4 py-2 border border-white rounded-md text-sm font-medium transition-colors hover:bg-white hover:text-custom-blue">
          Register
        </a>
        <a href="{{ route('login') }}" class="px-4 py-2 bg-white text-custom-blue rounded-md text-sm font-medium transition-colors hover:bg-gray-100">
          Login
        </a>
      </div>

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

  <div x-show="open" class="md:hidden" id="mobile-menu"
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="transform opacity-0 scale-95"
       x-transition:enter-end="transform opacity-100 scale-100"
       x-transition:leave="transition ease-in duration-75"
       x-transition:leave-start="transform opacity-100 scale-100"
       x-transition:leave-end="transform opacity-0 scale-95">
       
    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
      <a href="{{ route('report') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Make a Report</a>
      <a href="{{ route('consultation') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Consultation</a>
      <a href="{{ route('community') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Community</a>
      <a href="{{ route('information') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-white hover:bg-opacity-10">Information</a>
    </div>
    
    <div class="pt-3 pb-3 px-2 border-t border-gray-700 space-y-2">
       <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 border border-white rounded-md text-base font-medium transition-colors hover:bg-white hover:text-custom-blue">
          Register
        </a>
        <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 bg-white text-custom-blue rounded-md text-base font-medium transition-colors hover:bg-gray-100">
          Login
        </a>
    </div>
  </div>
</nav>
