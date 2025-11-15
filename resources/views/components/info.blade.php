@props(['informations'])

<div class="w-full p-32 bg-gray-50 sm:py-16" style="font-family: 'Agrandir'">
    
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-5xl text-gray-800">
            Information and Support Women
        </h2>
    </div>

    <div class="flex overflow-x-auto space-x-6 pb-4">

        @foreach ($informations as $info)
        <a href="{{ $info->url }}" target="_blank" rel="noopener noreferrer">
            <div class="relative w-96 h-40 flex-shrink-0 rounded-3xl overflow-hidden shadow-lg transition">
                
                <img src="{{ asset('storage/' . $info->image_path) }}" 
                    alt="{{ $info->title }}" 
                    class="absolute inset-0 w-full h-full object-cover">
                
                <div class="absolute inset-0 bg-gradient-to-r from-rose-600/70 to-pink-500/50"></div>
                
                <div class="relative p-5 h-full flex flex-col justify-start">
                    <h3 class="text-white text-2xl font-bold">
                        {{ $info->title }}
                    </h3>
                    <p class="text-white text-sm mt-1">
                        {{ $info->event }}
                    </p>
                </div>
            </div>
        </a>
        @endforeach

    </div>
    
    <div class="flex justify-end mt-2">
         <a href="{{ route('information') }}" class="text-blue-600 font-semibold whitespace-nowrap">
            See More
        </a>
    </div>
</div>