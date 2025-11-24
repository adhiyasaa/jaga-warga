@props(['users'])

<div class="w-full p-8 sm:p-16 bg-gray-50">
    
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl sm:text-5xl text-gray-800 font-bold">
            Popular Psychologist
        </h2>
    </div>

    {{-- Container Horizontal Scroll --}}
    <div class="flex overflow-x-auto space-x-6 pb-8 snap-x scrollbar-hide">

        {{-- Logika: Cek apakah variabel $users ada dan tidak kosong --}}
        @if(isset($users) && $users->count() > 0)
            @foreach($users as $psychologist)
                <div class="snap-center shrink-0 w-72">
                    {{-- Panggil Component Card --}}
                    <x-consultation-card :user="$psychologist" />
                </div>
            @endforeach
        @else
            {{-- Fallback jika data kosong --}}
            <div class="p-6 text-gray-500 italic w-full text-center border border-dashed rounded-lg">
                Belum ada data psikolog.
            </div>
        @endif

    </div>
    
    <div class="flex justify-end mt-4">
         <a href="{{ route('consultation') }}" class="text-custom-blue text-xl font-semibold whitespace-nowrap hover:underline flex items-center gap-2 transition-all hover:gap-3">
            Get help now! <span>&rarr;</span>
        </a>
    </div>
</div>