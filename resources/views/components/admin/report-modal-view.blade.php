<div id="viewReportModal-{{ $report->id }}" 
     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 opacity-0 scale-95 transition-all duration-200">
    
    <div class="absolute inset-0" onclick="closeModal('viewReportModal-{{ $report->id }}')"></div>

    <div class="bg-white w-full max-w-3xl max-h-[90vh] rounded-xl shadow-2xl relative m-4 flex flex-col overflow-hidden transform transition-all">
        
        <div class="overflow-y-auto p-8">
            
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">View Details</h2>
                    <p class="text-sm text-gray-500">Report ID: #{{ $report->id }}</p>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 mb-6">
                <h3 class="font-bold text-lg text-blue-900 mb-4 border-b pb-2">Biodata</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Full Name</label>
                        <p class="text-sm font-medium text-gray-900 bg-white px-3 py-2 rounded border border-gray-200">
                            {{ $report->user->name ?? $report->first_name . ' ' . $report->last_name }}
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Email</label>
                        <p class="text-sm font-medium text-gray-900 bg-white px-3 py-2 rounded border border-gray-200">
                            {{ $report->user->email ?? $report->email }}
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Phone</label>
                        <p class="text-sm font-medium text-gray-900 bg-white px-3 py-2 rounded border border-gray-200">
                            {{ $report->phone_number ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Date of Birth</label>
                        <p class="text-sm font-medium text-gray-900 bg-white px-3 py-2 rounded border border-gray-200">
                            {{ $report->date_of_birth ? \Carbon\Carbon::parse($report->date_of_birth)->format('d M Y') : '-' }}
                        </p>
                    </div>
                    <div class="col-span-2">
                         <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Address</label>
                        <p class="text-sm font-medium text-gray-900 bg-white px-3 py-2 rounded border border-gray-200">
                            {{ $report->home_address ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                <h3 class="font-bold text-lg text-red-900 mb-4 border-b pb-2">Accident Details</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Type</label>
                            <p class="text-sm font-medium text-gray-900 bg-white px-3 py-2 rounded border border-gray-200">
                                {{ $report->incident_type }}
                            </p>
                        </div>
                        <div class="col-span-1">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Date</label>
                            <p class="text-sm font-medium text-gray-900 bg-white px-3 py-2 rounded border border-gray-200">
                                {{ $report->incident_date ? \Carbon\Carbon::parse($report->incident_date)->format('d/m/Y') : '-' }}
                            </p>
                        </div>
                        <div class="col-span-1">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Time</label>
                            <p class="text-sm font-medium text-gray-900 bg-white px-3 py-2 rounded border border-gray-200">
                                {{ $report->incident_time }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Location</label>
                        <p class="text-sm font-medium text-gray-900 bg-white px-3 py-2 rounded border border-gray-200">
                            {{ $report->incident_location }}
                        </p>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Description</label>
                        <div class="text-sm text-gray-900 bg-white px-3 py-2 rounded border border-gray-200 min-h-[80px]">
                            {{ $report->description }}
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1 block">Evidence</label>
                        @if($report->evidence_file_path)
                            <div class="mt-2">
                                <a href="{{ Storage::disk('supabase')->url($report->evidence_file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 text-sm font-medium transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    View Evidence File
                                </a>
                            </div>
                        @else
                            <p class="text-sm text-gray-400 italic">No evidence uploaded.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4 flex justify-end pt-4">
                <button type="button" onclick="closeModal('viewReportModal-{{ $report->id }}')" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-lg">
                    Close Details
                </button>
            </div>
            
        </div>
    </div>
</div>