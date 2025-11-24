<footer class="bg-[#1524A7] text-gray-200 w-full px-6 md:px-16 lg:px-32 py-10">
    <div class="container mx-auto max-w-7xl grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- Kolom 1: Info & Kontak --}}
        <div class="space-y-4">
            <a href="{{ route('home') }}">
                <!-- Menggunakan asset() agar path gambar tidak error di halaman chat -->
                <img src="{{ asset('image/logo.png') }}" alt="Jaga Warga Logo" class="w-40">
            </a>

            <p class="text-sm leading-relaxed text-blue-100">
                Gd. Widyasatwaloka, Pusat Riset Biosistematika & Evolusi- OR Hayati dan Lingkungan, BRIN <br>
                Jl. Raya Bogor Km.46, Cibinong. 16911
            </p>
            <div class="space-y-1">
                <p class="text-sm">Telp: (021) 8765000163</p>
                <p class="text-sm">Email: jagainwarga@jagawarga.com</p>
            </div>

            {{-- Social Media Icons --}}
            <div class="flex space-x-3 pt-2">
                <a href="#" class="w-9 h-9 border border-blue-400/50 rounded-lg flex items-center justify-center hover:bg-white hover:text-[#1524A7] transition-all duration-300">
                    <img src="{{ asset('image/sm2.png') }}" alt="Facebook" class="w-5 h-5">
                </a>
                <a href="#" class="w-9 h-9 border border-blue-400/50 rounded-lg flex items-center justify-center hover:bg-white hover:text-[#1524A7] transition-all duration-300">
                    <img src="{{ asset('image/sm1.png') }}" alt="Instagram" class="w-6 h-6">
                </a>
                <a href="#" class="w-9 h-9 border border-blue-400/50 rounded-lg flex items-center justify-center hover:bg-white hover:text-[#1524A7] transition-all duration-300">
                    <img src="{{ asset('image/sm3.png') }}" alt="YouTube" class="w-6 h-6">
                </a>
                <a href="#" class="w-9 h-9 border border-blue-400/50 rounded-lg flex items-center justify-center hover:bg-white hover:text-[#1524A7] transition-all duration-300">
                    <img src="{{ asset('image/sm4.png') }}" alt="X" class="w-5 h-5">
                </a>
            </div>
        </div>

        {{-- Kolom 2: Spacer (Kosong di Desktop) --}}
        <div class="hidden md:block"></div>

        {{-- Kolom 3: Navigasi --}}
        <div class="space-y-3 text-left md:text-right">
            <h3 class="text-3xl font-bold text-white">Home</h3>
            <nav>
                <ul class="space-y-2 text-blue-100">
                    {{-- Link Fitur Utama --}}
                    <li><a href="{{ route('report.step1.show') }}" class="hover:text-white hover:underline transition">Make a Report!</a></li>
                    <li><a href="{{ route('consultation') }}" class="hover:text-white hover:underline transition">Consultation</a></li>
                    <li><a href="{{ route('community') }}" class="hover:text-white hover:underline transition">Community</a></li>
                    <li><a href="{{ route('information') }}" class="hover:text-white hover:underline transition">Information</a></li>
                    
                    {{-- Link Login/Register (Hanya muncul jika belum login) --}}
                    @guest
                        <li class="pt-2">
                            <a href="{{ route('login') }}" class="hover:text-white hover:underline font-semibold">Sign In</a> 
                            <span class="mx-1">/</span> 
                            <a href="{{ route('register') }}" class="hover:text-white hover:underline font-semibold">Sign Up</a>
                        </li>
                    @endguest
                </ul>
            </nav>
        </div>

    </div>
    
    {{-- Copyright (Opsional, pemanis di bawah) --}}
    <div class="mt-10 pt-6 border-t border-blue-800/50 text-center text-xs text-blue-300">
        &copy; {{ date('Y') }} Jaga Warga. All rights reserved.
    </div>
</footer>