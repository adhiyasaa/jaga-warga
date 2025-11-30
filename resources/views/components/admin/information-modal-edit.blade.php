@props(['information'])

<div id="editInformationModal-{{ $information->id }}" 
     class="hidden fixed inset-0 bg-black/50 flex justify-center items-center z-50 opacity-0 scale-95 transition-all"
     x-data="{ isLoading: false }">
     
    <div class="bg-white rounded-xl w-[500px] p-6 shadow-lg">
        <h2 class="text-lg font-semibold mb-2">Edit Information</h2>
        <p class="text-sm text-gray-500 mb-4">Place for edit information</p>

        <form method="POST" 
              action="{{ route('admin.information.update', $information->id) }}" 
              enctype="multipart/form-data"
              @submit="isLoading = true">
            @csrf
            @method('PUT')
            
            <div class="space-y-3">
                <input type="text" name="title" value="{{ $information->title }}" class="w-full border rounded-md px-3 py-2" required>
                <input type="text" name="event" value="{{ $information->event }}" class="w-full border rounded-md px-3 py-2" required>
                <textarea name="description" rows="3" class="w-full border rounded-md px-3 py-2">{{ $information->description }}</textarea>
                <input type="url" name="url" value="{{ $information->url }}" class="w-full border rounded-md px-3 py-2">
                
                <div>
                    <label class="text-sm text-gray-600">Upload New Image (Optional)</label>
                    <input type="file" name="image" class="w-full border rounded-md px-3 py-2 text-sm">
                    <p class="text-xs text-gray-500 mt-1">Leave blank to keep current image.</p>
                </div>
            </div>
            
            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" 
                        onclick="closeModal('editInformationModal-{{ $information->id }}')" 
                        class="px-4 py-2 text-gray-500 border rounded-md disabled:opacity-50"
                        :disabled="isLoading">
                    Cancel
                </button>
                
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-md flex items-center justify-center min-w-[80px] disabled:bg-blue-400"
                        :disabled="isLoading">
                    
                    <span x-show="!isLoading">Save</span>
                    
                    <span x-show="isLoading" class="flex items-center gap-2" style="display: none;">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Saving...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>