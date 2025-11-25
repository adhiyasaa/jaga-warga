<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Report - Jaga Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-900">

    <div class="flex">
        {{-- Sidebar --}}
        <x-admin.sidebar />

        {{-- Main Content --}}
        <main class="ml-60 w-full p-10">
            <div class="mb-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">
                    Semua Laporan Masuk
                </h1>
                {{-- Anda bisa menambahkan filter atau tombol export di sini --}}
            </div>

            {{-- Panggil Komponen Tabel Laporan --}}
            {{-- Pastikan variabel $reports dikirim dari controller --}}
            <x-admin.report-table :reports="$reports" />
            
        </main>
    </div>

</body>
</html>