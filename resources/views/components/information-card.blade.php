@props(['information'])

<a href="{{ $information->url }}" target="_blank" rel="noopener noreferrer" 
   class="block bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
    
    <div class="relative rounded-2xl overflow-hidden bg-white">
        <img class="w-full h-48 object-cover" 
            src="{{ asset('storage/' . $information->image_path) }}" 
            alt="{{ $information->title }}">
        
        <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-black/50 to-transparent"></div>
    </div>

    <div class="p-6 text-gray-800">
        <h3 class="font-bold text-2xl text-gray-900">
            {{ $information->title }}
        </h3>
        <h4 class="text-gray-600 mb-2">{{ $information->event }}</h4>
        <p class="text-gray-800 text-base mb-4">
            {{ $information->description }}
        </p>

        <div class="text-right">
            <span class="font-semibold text-blue-600 hover:text-blue-800">
                See More
            </span>
        </div>
    </div>
</a>