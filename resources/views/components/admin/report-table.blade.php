@props(['reports'])

<div class="border border-gray-300 rounded-xl bg-white shadow-sm">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl font-extrabold text-gray-800">Form Report</h3>
            <!-- <a href="#" class="text-blue-600 text-sm font-medium hover:underline">See All</a> -->
        </div>

        @if($reports->isEmpty())
        <p class="text-gray-500 text-center py-8 italic">No reports found.</p>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50">
                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">ID</th>
                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-1/6">Name</th>
                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-1/6">Created Date</th>
                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-1/6">Type</th>
                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-1/4">Location & Desc</th>
                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-1/12">Status</th>
                        <!-- <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right w-1/12">Action</th> -->
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($reports as $report)
                    <tr class="hover:bg-gray-50 transition-colors align-top">
                        <td class="py-4 px-4 text-sm text-gray-500">{{ $report->id }}</td>
                        <td class="py-4 px-4 text-sm font-medium text-gray-900">
                            @if($report->is_anonymous)
                            <span class="italic text-gray-400 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                                Anonim
                            </span>
                            @else
                            {{ $report->user->name ?? 'Guest' }}
                            @endif
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-500">
                            <div class="flex flex-col">
                                <span>{{ \Carbon\Carbon::parse($report->created_at)->format('d M Y') }}</span>
                                <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($report->created_at)->format('H:i') }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="bg-gray-100 text-gray-600 py-1 px-2 rounded text-xs font-medium whitespace-nowrap">
                                {{ Str::limit($report->incident_type, 15) }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex flex-col gap-2">
                                <span class="text-xs font-bold text-gray-700 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ Str::limit($report->incident_location, 30) }}
                                </span>

                                {{-- FIX UTAMA: Penulisan satu baris rapat --}}
                                <div class="text-xs text-gray-600 italic bg-gray-50 p-2.5 rounded border border-gray-200 whitespace-pre-line break-words max-h-20 overflow-y-auto leading-snug" title="{{ $report->description }}">{{ Str::limit(trim($report->description), 100) }}</div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="text-xs px-2 py-1 rounded-full font-semibold whitespace-nowrap border 
                                    @if($report->status == 'Selesai') bg-green-100 text-green-700 border-green-200
                                    @elseif($report->status == 'Ditinjau') bg-blue-100 text-blue-700 border-blue-200
                                    @elseif($report->status == 'Ditolak') bg-red-100 text-red-700 border-red-200
                                    @else bg-yellow-100 text-yellow-700 border-yellow-200
                                    @endif">
                                {{ $report->status ?? 'Pending' }}
                            </span>
                        </td>
                        <!-- <td class="py-4 px-4 text-right">
                                <button class="bg-custom-blue hover:bg-blue-800 text-white text-xs px-3 py-1.5 rounded shadow-sm transition-colors">
                                    Detail
                                </button>
                            </td> -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>