{{-- resources/views/components/what-to-do.blade.php --}}

{{--
  Komponen untuk bagian "What You Should Do After an Incident?".
  Dibuat dengan Tailwind CSS.
--}}
<section class="bg-gray-50 py-16 sm:py-24">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    {{-- Judul Section --}}
    <div class="text-center">
      <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-gray-900">
        What You Should Do After an Incident?
      </h2>
    </div>

    {{-- Grid untuk 4 Kartu --}}
    <div class="mt-12 max-w-lg mx-auto grid gap-8 lg:grid-cols-4 lg:max-w-none">

      {{-- Card 1: Stay Safe --}}
      <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
        <div class="flex-shrink-0 bg-red-200 h-52 flex items-center justify-center">
          {{-- Ganti 'src' dengan path gambar Anda yang sebenarnya --}}
          <img class="h-40 w-40 object-contain" src="https://placehold.co/160x160/ef4444/ffffff?text=Stay+Safe" alt="Stay Safe Illustration">
        </div>
        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
          <p class="text-lg font-medium text-gray-900 text-center">
            Stay Safe
          </p>
        </div>
      </div>

      {{-- Card 2: Preserve Evidence --}}
      <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
        <div class="flex-shrink-0 bg-yellow-200 h-52 flex items-center justify-center">
          {{-- Ganti 'src' dengan path gambar Anda yang sebenarnya --}}
          <img class="h-40 w-40 object-contain" src="https://placehold.co/160x160/f59e0b/ffffff?text=Evidence" alt="Preserve Evidence Illustration">
        </div>
        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
          <p class="text-lg font-medium text-gray-900 text-center">
            Preserve Evidence
          </p>
        </div>
      </div>
      
      {{-- Card 3: Write It Down --}}
      <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
        <div class="flex-shrink-0 bg-green-200 h-52 flex items-center justify-center">
          {{-- Ganti 'src' dengan path gambar Anda yang sebenarnya --}}
          <img class="h-40 w-40 object-contain" src="https://placehold.co/160x160/22c55e/ffffff?text=Write+It" alt="Write It Down Illustration">
        </div>
        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
          <p class="text-lg font-medium text-gray-900 text-center">
            Write It Down
          </p>
        </div>
      </div>

      {{-- Card 4: Report --}}
      <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
        <div class="flex-shrink-0 bg-blue-200 h-52 flex items-center justify-center">
          {{-- Ganti 'src' dengan path gambar Anda yang sebenarnya --}}
          <img class="h-40 w-40 object-contain" src="https://placehold.co/160x160/3b82f6/ffffff?text=Report" alt="Report to Jaga Warga Illustration">
        </div>
        <div class="flex-1 bg-white p-6 flex flex-col justify-between">
          <p class="text-lg font-medium text-gray-900 text-center">
            Report to <a href="#" class="text-custom-blue font-bold">Jaga Warga</a>
          </p>
        </div>
      </div>

    </div>
  </div>
</section>
