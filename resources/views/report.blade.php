<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan - Jaga Warga</title>

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

    <x-navbar />

    <main>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <h2 class="text-2xl font-semibold">Make A Report</h2>
                        <p class="text-xl font-normal mb-6 w-1/2">This report is about sexual harassment. We will connect you to the department that handles sexual harassment cases.</p>

                        @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            <strong>Oops! Ada yang salah:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <h2 class="text-xl font-semibold mb-3">Fill this form.</h2>
                        <form method="POST" action="{{ route('report.store') }}">
                            @csrf
                            <div>
                                <label for="first-name" class="block font-medium text-sm text-gray-700">First Name</label>
                                <input id="title" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="firstName" value="{{ old('firstName') }}" required autofocus />
                            </div>
                            <div>
                                <label for="title" class="block font-medium text-sm text-gray-700">Judul Laporan</label>
                                <input id="title" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="title" value="{{ old('title') }}" required autofocus />
                            </div>

                            <div class="mt-4">
                                <label for="incident_date" class="block font-medium text-sm text-gray-700">Tanggal Kejadian</label>
                                <input id="incident_date" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="date" name="incident_date" value="{{ old('incident_date') }}" required />
                            </div>

                            <div class="mt-4">
                                <label for="location" class="block font-medium text-sm text-gray-700">Lokasi Kejadian</label>
                                <input id="location" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="location" value="{{ old('location') }}" required />
                            </div>

                            <div class="mt-4">
                                <label for="category" class="block font-medium text-sm text-gray-700">Kategori Laporan</label>
                                <select name="category" id="category" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih Kategori</option>
                                    <option value="Pencurian" {{ old('category') == 'Pencurian' ? 'selected' : '' }}>Pencurian</option>
                                    <option value="Vandalisme" {{ old('category') == 'Vandalisme' ? 'selected' : '' }}>Vandalisme</option>
                                    <option value="Keributan" {{ old('category') == 'Keributan' ? 'selected' : '' }}>Keributan</option>
                                    <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div class="mt-4">
                                <label for="description" class="block font-medium text-sm text-gray-700">Deskripsi Kejadian</label>
                                <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-custom-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Kirim Laporan
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer/>

</body>

</html>