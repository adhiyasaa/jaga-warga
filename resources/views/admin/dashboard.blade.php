<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Jaga Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-900">

    <div class="flex">
        {{-- Sidebar --}}
        <x-admin.sidebar />

        {{-- Main Content --}}
        <main class="ml-60 w-full p-10">
            <h1 class="text-2xl font-bold text-gray-800 mb-8">
                Welcome to Dashboard. Hi, {{ Auth::user()->name ?? 'Admin' }}!
            </h1>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-3 gap-6 mb-10">
                <x-admin.stat-card title="Activity This Day" :value="$activityCount" />
                <x-admin.stat-card title="Form Report This Day" :value="$reportCount" />
                <x-admin.stat-card title="Consultation Activity" :value="$consultationCount" />
            </div>

            {{-- Tables --}}
            <div class="grid grid-cols-2 gap-8">
                <div :reports="$reports"> </div>
                <div :consultations="$consultations"> </div>
            </div>
        </main>
    </div>

</body>
</html>
