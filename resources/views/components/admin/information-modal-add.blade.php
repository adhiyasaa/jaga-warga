<div id="addInformationModal" class="hidden fixed inset-0 bg-black/50 flex justify-center items-center z-50 opacity-0 scale-95 transition-all">
    <div class="bg-white rounded-xl w-[500px] p-6 shadow-lg">
        <h2 class="text-lg font-semibold mb-2">Add Information</h2>
        <p class="text-sm text-gray-500 mb-4">Place for add information</p>

        <form method="POST" action="{{ route('admin.information.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-3">
                <input type="text" name="title" placeholder="Title" class="w-full border rounded-md px-3 py-2" required>
                <input type="text" name="event" placeholder="Event" class="w-full border rounded-md px-3 py-2" required>
                <textarea name="description" placeholder="Description" rows="3" class="w-full border rounded-md px-3 py-2"></textarea>
                <input type="url" name="url" placeholder="URL (e.g., https://example.com)" class="w-full border rounded-md px-3 py-2">
                
                <div>
                    <label class="text-sm text-gray-600">Upload Image</label>
                    <input type="file" name="image" class="w-full border rounded-md px-3 py-2 text-sm">
                </div>
            </div>
            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" onclick="closeModal('addInformationModal')" class="px-4 py-2 text-gray-500 border rounded-md">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Add</button>
            </div>
        </form>
    </div>
</div>