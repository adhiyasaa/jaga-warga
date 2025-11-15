@props(['information'])

<div id="editInformationModal-{{ $information->id }}" class="hidden fixed inset-0 bg-black/50 flex justify-center items-center z-50 opacity-0 scale-95 transition-all">
    <div class="bg-white rounded-xl w-[500px] p-6 shadow-lg">
        <h2 class="text-lg font-semibold mb-2">Edit Information</h2>
        <p class="text-sm text-gray-500 mb-4">Place for edit information</p>

        <form method="POST" action="{{ route('admin.information.update', $information->id) }}" enctype="multipart/form-data">
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
                <button type="button" onclick="closeModal('editInformationModal-{{ $information->id }}')" class="px-4 py-2 text-gray-500 border rounded-md">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Save</button>
            </div>
        </form>
    </div>
</div>