<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Terkirim - Jaga Warga</title>

    {{-- Memuat Tailwind CSS dari CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Konfigurasi warna custom-blue untuk navbar --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom-blue': '#222E85'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-800">

    {{-- 1. Memuat Navbar --}}
    <x-navbar />

    {{-- 2. Konten Halaman Sukses --}}
    <main>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">

                        <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>

                        <h2 class="mt-4 text-2xl font-semibold">Thanks for Report!</h2>
                        <p class="mt-2 text-gray-600">
                            We will reach out to you soon to provide further support. </p>

                        <div class="mt-6">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-custom-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Go back to homepage </a>
                        </div>
                    </div>
                </div>

                <div class="mt-12">
                    <h2 class="text-3xl font-bold text-white text-center">Emergency Call</h2>
                    <p class="text-lg text-gray-300 text-center mt-2">If you're in an emergency, call the number below</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">

                        <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                            <img src="{{ asset('image/callcenter-icon.png') }}" alt="Firefighter Icon" class="h-24 w-24 mx-auto">
                            <h3 class="text-2xl font-semibold text-gray-900 mt-4">Call Center</h3>
                            <p class="text-gray-600 mt-2">For any problem</p>
                            <p class="text-3xl font-bold text-custom-blue mt-4">112</p>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                            <img src="{{ asset('image/medic-icon.png') }}" alt="Ambulance Icon" class="h-24 w-24 mx-auto">
                            <h3 class="text-2xl font-semibold text-gray-900 mt-4">Ambulance</h3>
                            <p class="text-gray-600 mt-2">For medical emergencies</p>
                            <p class="text-3xl font-bold text-custom-blue mt-4">119</p>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                            <img src="{{ asset('image/police-icon.png') }}" alt="Police Icon" class="h-24 w-24 mx-auto">
                            <h3 class="text-2xl font-semibold text-gray-900 mt-4">Police</h3>
                            <p class="text-gray-600 mt-2">For criminal incidents</l>
                            <p class="text-3xl font-bold text-custom-blue mt-4">110</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>
    <x-footer/>

</body>

</html>