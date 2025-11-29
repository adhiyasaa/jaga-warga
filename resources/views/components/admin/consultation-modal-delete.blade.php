@props(['consultation'])

<div id="deleteConsultationModal-{{ $consultation->id }}" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 opacity-0 scale-95 transition-all">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <h2 class="text-lg font-semibold mb-2 text-gray-800">Delete Session</h2>
        <p class="text-sm text-gray-600 mb-4">Are you sure want to delete this consultation history?</p>

        <div class="flex justify-end space-x-3">
            <button 
                onclick="closeModal('deleteConsultationModal-{{ $consultation->id }}')" 
                class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400">
                No
            </button>

            <form action="{{ route('admin.consultation.destroy', $consultation->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                    Yes, Delete
                </button>
            </form>
        </div>
    </div>
</div>