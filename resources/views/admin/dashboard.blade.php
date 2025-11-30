<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Jaga Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        @font-face {
            font-family: 'Agrandir';
            src: url('https://muabtceunyjvfxfkclzs.supabase.co/storage/v1/object/public/fonts/Agrandir-Regular.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }
        body { font-family: 'Agrandir', sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-900">

    <div class="flex">
        <x-admin.sidebar />

        <main class="ml-64 w-full p-10 min-h-screen">
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-gray-900">
                    Welcome to Dashboard. Hi, {{ Auth::user()->name ?? 'Admin' }}
                </h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <x-admin.stat-card title="Activity" subtitle="This day" :value="$activityCount ?? '5090'" />
                <x-admin.stat-card title="Form Report" subtitle="This day" :value="$reportCount ?? '90'" />
                <x-admin.stat-card title="Consultation" subtitle="This day" :value="$consultationCount ?? '8'" />
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <x-admin.report-table :reports="collect($reports)->take(5)" /> 
                <x-admin.consultation-table :consultations="collect($consultations)->take(5)" />
            </div>

            @foreach (collect($consultations) as $consultation)
                <x-admin.consultation-modal-view :consultation="$consultation" />
                <x-admin.consultation-modal-delete :consultation="$consultation" />
            @endforeach
            @foreach (collect($reports) as $report)
                <x-admin.report-modal-view :report="$report" />
                <x-admin.report-modal-delete :report="$report" />
            @endforeach
        </main>
    </div>

</body>
</html>