<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi - Jaga Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: { colors: { 'custom-blue': '#222E85' } }
            }
        }
    </script>
</head>

<body class="bg-gray-50 font-sans antialiased">

    <x-navbar />

    <main>
        <div class="py-12 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Hero Section -->
                <div class="bg-custom-blue rounded-2xl p-6 sm:p-10 mb-10 text-white shadow-lg flex flex-col md:flex-row justify-between items-center relative overflow-hidden">
                    <div class="relative z-10 max-w-2xl">
                        <h3 class="text-2xl sm:text-3xl font-bold mb-3">
                            {{ Auth::user()->role === 'psychologist' ? 'Halo, Dokter!' : 'Butuh Teman Cerita?' }}
                        </h3>
                        <p class="text-blue-100 text-sm sm:text-base leading-relaxed">
                            {{ Auth::user()->role === 'psychologist' 
                                ? 'Pantau riwayat konsultasi pasien Anda di sini.' 
                                : 'Jaga Warga menyediakan layanan konsultasi aman dan rahasia. Pilih psikolog profesional di bawah ini.' 
                            }}
                        </p>
                    </div>
                    <div class="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-blue-500 to-transparent opacity-20 pointer-events-none"></div>
                    <div class="hidden md:block text-8xl opacity-20 transform rotate-12 translate-x-4">💬</div>
                </div>

                <!-- List Header -->
                <div class="mb-8 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800 border-l-4 border-custom-blue pl-3">
                        {{ $pageTitle ?? 'Daftar Konsultasi' }}
                    </h2>
                </div>

                <!-- Grid List -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8 justify-items-center">
                    @forelse($users as $user)
                        <x-consultation-card :user="$user" />
                    @empty
                        <div class="col-span-full text-center py-16 w-full bg-white rounded-2xl border border-dashed border-gray-300">
                            <div class="inline-block p-4 rounded-full bg-gray-50 mb-3">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $emptyMessage ?? 'Tidak ada data.' }}</h3>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </main>

    <x-footer/>

</body>
</html>