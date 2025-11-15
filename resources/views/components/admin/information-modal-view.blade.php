@props(['information'])

<div id="viewInformationModal-{{ $information->id }}" class="hidden fixed inset-0 bg-black/50 flex justify-center items-center z-50 opacity-0 scale-95 transition-all">
    <div class="bg-white rounded-xl w-[500px] p-6 shadow-lg">
        <h2 class="text-lg font-semibold mb-2">Details Information</h2>
        <p class="text-sm text-gray-500 mb-4">Place for see details information</p>

        <div class="space-y-3">
            <input type="text" value="{{ $information->title }}" disabled class="w-full border rounded-md px-3 py-2 bg-gray-100">
            <input type="text" value="{{ $information->event }}" disabled class="w-full border rounded-md px-3 py-2 bg-gray-100">
            <textarea disabled rows="3" class="w-full border rounded-md px-3 py-2 bg-gray-100">{{ $information->description }}</textarea>
            <input type="url" value="{{ $information->url }}" disabled class="w-full border rounded-md px-3 py-2 bg-gray-100">

            <div>
                <label class="text-sm text-gray-600">Uploaded Image</label>
                <img src="{{ asset('storage/' . $information->image_path) }}" 
                     alt="Image" 
                     class="w-full h-32 object-cover rounded-md mt-1 border">
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <button type="button" onclick="closeModal('viewInformationModal-{{ $information->id }}')" class="bg-blue-600 text-white px-4 py-2 rounded-md">Done</button>
        </div>
    </div>
</div>