@props(['users'])

<div class="w-full p-32 bg-gray-50 sm:py-16" style="font-family: 'Agrandir'">
    
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-5xl text-gray-800">
            Popular Psychologist
        </h2>
    </div>

    <div class="flex overflow-x-auto space-x-6 pb-6">

        @if(isset($users) && $users->count() > 0)
            @foreach($users as $psychologist)
                <x-consultation-card :user="$psychologist" />
            @endforeach
        @else
            <div class="p-6 text-gray-500 italic w-full text-center border border-dashed rounded-lg">
                Belum ada data psikolog.
            </div>
        @endif

    </div>
    
    <div class="flex justify-end mt-2">
         <a href="{{ route('consultation') }}" class="text-blue-600 font-semibold whitespace-nowrap">
            Get help now!
        </a>
    </div>
</div>
