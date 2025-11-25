<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Consultation - Jaga Warga</title>
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
                    Aktivitas Konsultasi
                </h1>
            </div>

            {{-- Gunakan komponen consultation-table yang sudah ada --}}
            {{-- Pastikan variabel $consultations dikirim dari controller --}}
            <x-admin.consultation-table :consultations="$consultations ?? collect()" />
            
        </main>
    </div>

</body>
</html>