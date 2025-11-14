@php
// use Illuminate... (Ini tidak lagi dibutuhkan)
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report History - Jaga Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

<body class="bg-gray-100">

    <x-navbar />

    <main>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">
                        Report History
                    </h2>
                    <a href="{{ route('profile.show') }}" class="text-sm text-custom-blue hover:underline">
                        &larr; Back to Profile
                    </a>
                </div>

                <div class="space-y-6">
                    @if($reports->isEmpty())
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            Anda belum membuat laporan apapun.
                        </div>
                    </div>
                    @else
                    @foreach($reports as $report)
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 space-y-4">

                            <div class="flex flex-col sm:flex-row justify-between sm:items-center border-b pb-3">
                                <div class="mb-2 sm:mb-0">
                                    <h3 class="text-lg font-semibold text-custom-blue">
                                        {{ $report->incident_type }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        Dilaporkan pada: {{ $report->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                                <div>
                                    @php
                                    // Logika untuk badge status
                                    $status = strtolower($report->status);
                                    $statusClass = 'bg-gray-100 text-gray-800'; // Default (Pending/Terkirim)
                                    if ($status == 'ditinjau') {
                                    $statusClass = 'bg-blue-100 text-blue-800';
                                    } elseif ($status == 'selesai') {
                                    $statusClass = 'bg-green-100 text-green-800';
                                    } elseif ($status == 'ditolak') {
                                    $statusClass = 'bg-red-100 text-red-800';
                                    }
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        Status: {{ $report->status ?? 'Terkirim' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Tambahkan 'md:items-start' untuk meratakan semua ke atas --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 md:items-start">

                                {{-- Kolom Kiri --}}
                                <div class="space-y-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Tanggal Insiden</h4>
                                        <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($report->incident_date)->format('d F Y') }} pukul {{ $report->incident_time }}</f>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Lokasi Insiden</h4>
                                        <p class="text-sm text-gray-900">{{ $report->incident_location }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">File Bukti</h4>
                                        @if($report->evidence_file_path)
                                        <a href="{{ env('AWS_URL') . '/' . $report->evidence_file_path }}"
                                            target="_blank"
                                            class="text-sm text-custom-blue hover:underline">
                                            Lihat File Bukti (Klik untuk membuka)
                                        </a>
                                        @else
                                        <p class="text-sm text-gray-500 italic">Tidak ada file bukti yang diunggah.</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Kolom Kanan (Deskripsi) --}}
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Deskripsi Laporan</h4>
                                    <p class="text-sm text-gray-900 mt-1 bg-gray-50 p-3 rounded-md border whitespace-normal">
                                        {!! nl2br(e($report->description)) !!}
                                    </p>

                                </div>
                            </div>
                            {{-- AKHIR BAGIAN YANG DIPERBARUI --}}

                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>

            </div>
        </div>
    </main>

</body>

</html>