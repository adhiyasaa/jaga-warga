@props(['consultation'])

<div id="viewConsultationModal-{{ $consultation->id }}" class="hidden fixed inset-0 bg-black/50 flex justify-center items-center z-50 opacity-0 scale-95 transition-all">
    <div class="bg-white rounded-xl w-[500px] p-6 shadow-lg">
        <h2 class="text-lg font-semibold mb-2">Details Consultation</h2>
        <p class="text-sm text-gray-500 mb-4">Session details information</p>

        <div class="space-y-3">
            <div>
                <label class="text-xs text-gray-500">Session ID</label>
                <input type="text" value="#{{ $consultation->id }}" disabled class="w-full border rounded-md px-3 py-2 bg-gray-100 text-sm">
            </div>
            
            <div>
                <label class="text-xs text-gray-500">Patient Name</label>
                <input type="text" value="{{ $consultation->user->name ?? 'Unknown' }}" disabled class="w-full border rounded-md px-3 py-2 bg-gray-100">
            </div>

            <div>
                <label class="text-xs text-gray-500">Psychologist Name</label>
                <input type="text" value="{{ $consultation->psychologist->name ?? 'Unknown' }}" disabled class="w-full border rounded-md px-3 py-2 bg-gray-100">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs text-gray-500">Status</label>
                    <input type="text" value="{{ ucfirst($consultation->status) }}" disabled class="w-full border rounded-md px-3 py-2 bg-gray-100 uppercase font-bold text-xs">
                </div>
                <div>
                    <label class="text-xs text-gray-500">Date</label>
                    <input type="text" value="{{ $consultation->created_at->format('d M Y, H:i') }}" disabled class="w-full border rounded-md px-3 py-2 bg-gray-100 text-sm">
                </div>
            </div>
            
            <div>
                <label class="text-xs text-gray-500">Last Interaction</label>
                <input type="text" value="{{ $consultation->updated_at->diffForHumans() }}" disabled class="w-full border rounded-md px-3 py-2 bg-gray-100 text-sm">
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <button type="button" onclick="closeModal('viewConsultationModal-{{ $consultation->id }}')" class="bg-blue-600 text-white px-4 py-2 rounded-md">Done</button>
        </div>
    </div>
</div>