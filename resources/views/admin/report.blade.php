<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Laporan Warga') }}
        </h2>
    </x-slot>

    @php
        // FIX: Definisikan Base URL Supabase di PHP agar bisa diakses Alpine.
        // Ini akan menghasilkan URL seperti: https://xyz.supabase.co/storage/v1/object/public/reports/
        // Kita menggunakan Storage::disk('supabase')->url('reports/') untuk memaksa prefix reports/.
        // Namun, karena Storage::disk('supabase')->url() sudah menggunakan path lengkap dari DB,
        // kita hanya perlu base URL-nya saja. Mari kita gunakan helper yang paling aman:
        $supabaseBaseUrl = Storage::disk('supabase')->url(''); // Hasilnya: https://xyz.supabase.co/storage/v1/object/public/bucket_name/
    @endphp

    <div class="py-12" x-data="{ showModal: false, selectedReport: null, supabaseBaseUrl: '{{ $supabaseBaseUrl }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Flash Message Sukses --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Laporan Masuk</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Insiden</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($reports as $report)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $report->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $report->is_anonymous === 'yes' ? 'Anonim' : $report->first_name . ' ' . $report->last_name }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $report->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $report->incident_type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ Str::limit($report->incident_location, 20) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $report->status === 'Terkirim' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $report->status === 'Sedang Diproses' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $report->status === 'Selesai' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $report->status === 'Ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $report->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button @click="showModal = true; selectedReport = {{ $report->toJson() }}" 
                                                     class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                                Lihat Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                            Belum ada laporan yang masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Links --}}
                    <div class="mt-4">
                        @if ($reports instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {{ $reports->links() }}
                        @endif
                    </div>

                </div>
            </div>
        </div>

        {{-- MODAL DETAIL LAPORAN (Alpine.js) --}}
        <div x-show="showModal" 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            {{-- Backdrop --}}
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                {{-- Modal Panel --}}
                <div x-show="showModal" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Detail Laporan
                                </h3>
                                
                                {{-- Konten Detail --}}
                                <div class="mt-4 space-y-4 text-sm text-gray-600">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="font-bold text-gray-800">Pelapor:</p>
                                            <p x-text="selectedReport?.is_anonymous === 'yes' ? 'Anonim' : (selectedReport?.first_name + ' ' + selectedReport?.last_name)"></p>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">Kontak:</p>
                                            <p x-text="selectedReport?.email"></p>
                                            <p x-text="selectedReport?.phone_number"></p>
                                        </div>
                                    </div>

                                    <hr>

                                    <div>
                                        <p class="font-bold text-gray-800">Jenis Insiden:</p>
                                        <p x-text="selectedReport?.incident_type"></p>
                                    </div>

                                    <div>
                                        <p class="font-bold text-gray-800">Waktu & Lokasi:</p>
                                        <p x-text="selectedReport?.incident_date + ' pukul ' + selectedReport?.incident_time"></p>
                                        <p x-text="selectedReport?.incident_location"></p>
                                    </div>

                                    <div>
                                        <p class="font-bold text-gray-800">Deskripsi:</p>
                                        <p class="bg-gray-50 p-3 rounded border border-gray-200 mt-1" x-html="selectedReport?.description.replace(/\n/g, '<br>')"></p>
                                    </div>

                                    {{-- Bukti Lampiran --}}
                                    <div x-show="selectedReport?.evidence_file_path">
                                        <p class="font-bold text-gray-800 mb-2">Bukti Lampiran:</p>
                                        
                                        {{-- FIX URL: Menggunakan Base URL Supabase + path DB yang sudah lengkap (reports/namafile.png) --}}
                                        <template x-data="{ fileUrl: supabaseBaseUrl + selectedReport?.evidence_file_path }">
                                            <a :href="fileUrl" 
                                                target="_blank"
                                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                                Lihat Bukti (Foto/Video/PDF)
                                            </a>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showModal = false">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>