<section class="relative h-[940px] w-full bg-cover bg-center" style="background-image: url('{{ asset('image/hero.png') }}')">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="relative z-10 h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="font-family: 'Agrandir'">
        <div class="flex h-full flex-col justify-center items-center text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold uppercase tracking-wider text-gray-100">
                Need Help?
            </h1>
            <a href="#" class="relative mt-1 inline-block px-12 py-3 bg-red-700 text-white text-lg font-semibold rounded-lg shadow-lg transition-colors duration-300 hover:bg-red-800">
                <span class="absolute top-0 left-0 w-full h-full bg-red-700 blur-lg opacity-75 animate-pulse"></span>
                <span class="relative z-10">Make a Report</span>
            </a>
        </div>
        <div class="absolute bottom-8 left-4 sm:left-6 lg:left-8">
            <img src="{{ asset('image/logo.png') }}" alt="Jaga Warga Logo" class="h-10 md:h-12 w-auto">
        </div>
    </div>
</section>