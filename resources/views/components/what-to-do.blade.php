@php
    $cards = [
        [
            'title' => 'Stay Safe',
            'color' => 'bg-red-200',
            'image' => '/image/stay-safe.png',
        ],
        [
            'title' => 'Preserve Evidence',
            'color' => 'bg-yellow-200',
            'image' => '/image/perserve-evidence.png',
        ],
        [
            'title' => 'Write It Down',
            'color' => 'bg-green-200',
            'image' => '/image/write-it-down.png',
        ],
        [
            'title' => 'Report to <a href="#" class="text-custom-blue font-bold">Jaga Warga</a>',
            'color' => 'bg-blue-200',
            'image' => '/image/report.png',
        ],
    ];
@endphp

<section class="bg-gray-50 py-16 sm:py-24" style="font-family: 'Agrandir'">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center">
      <h2 class="text-3xl md:text-5xl tracking-tight text-gray-900">
        What You Should Do After an Incident?
      </h2>
    </div>

    <div class="mt-12 max-w-lg mx-auto grid gap-8 lg:grid-cols-4 lg:max-w-none">
        @foreach ($cards as $card)
            <div class="flex flex-col rounded-xl shadow-lg overflow-hidden min-h-[380px]">
                <div class="flex-shrink-0 {{ $card['color'] }} min-h-[300px] flex items-center justify-center">
                    <img class="h-60 w-60 object-contain" src="{{ $card['image'] }}" alt="">
                </div>

                <div class="flex-1 bg-white p-6 flex flex-col justify-between">
                    <p class="text-lg font-medium text-gray-900 text-center">
                        {!! $card['title'] !!}
                    </p>
                </div>
            </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
