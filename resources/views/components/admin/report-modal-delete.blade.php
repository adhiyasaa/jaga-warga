<div id="deleteReportModal-{{ $report->id }}" 
     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 opacity-0 scale-95 transition-all duration-200">
    
    {{-- Klik background untuk cancel --}}
    <div class="absolute inset-0" onclick="closeModal('deleteReportModal-{{ $report->id }}')"></div>

    <div class="bg-white rounded-xl shadow-2xl p-6 w-[400px] relative transform transition-all">
        
        <div class="flex flex-col items-center text-center mb-6">
            <div class="bg-red-50 p-3 rounded-full mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">Delete Report</h2>
            <p class="text-sm text-gray-500 leading-relaxed">
                Are you sure you want to delete report <span class="font-semibold text-gray-900">#{{ $report->id }}</span>? 
                <br>This action cannot be undone.
            </p>
        </div>

        <div class="flex justify-center space-x-3">
            <button 
                onclick="closeModal('deleteReportModal-{{ $report->id }}')" 
                class="px-5 py-2.5 rounded-lg text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors w-full">
                Cancel
            </button>

            <form action="{{ route('admin.report.destroy', $report->id) }}" method="POST" class="w-full">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="px-5 py-2.5 rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 shadow-md hover:shadow-lg transition-all w-full">
                    Yes, Delete
                </button>
            </form>
        </div>
    </div>
</div>