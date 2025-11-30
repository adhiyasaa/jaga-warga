@props(['informations'])

<div class="flex justify-end mb-4">
    <button 
        class="bg-blue-600 text-white text-sm px-4 py-2 rounded-md hover:bg-blue-700"
        onclick="openModal('addInformationModal')">
        Add Information +
    </button>
</div>

<div class="bg-white rounded-lg border border-gray-300 p-2">
    <table class="w-full text-sm text-left">
        <thead class="text-gray-600 font-semibold border-b">
            <tr>
                <th class="py-3 px-4">ID</th>
                <th class="py-3 px-4">Title</th>
                <th class="py-3 px-4">Event</th>
                <th class="py-3 px-4">Description</th>
                <th class="py-3 px-4">URL</th>
                <th class="py-3 px-4">Image</th>
                <th class="py-3 px-4">Created Date</th>
                <th class="py-3 px-4">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach ($informations as $information)
                <tr>
                    <td class="py-3 px-4">{{ $information->id }}</td>
                    <td class="py-3 px-4">{{ $information->title }}</td>
                    <td class="py-3 px-4">{{ $information->event }}</td>
                    <td class="py-3 px-4">{{ Str::limit($information->description, 50) }}</td>
                    <td class="py-3 px-4">
                        <a href="{{ $information->url }}" target="_blank" class="text-blue-500 hover:underline">
                            Link
                        </a>
                    </td>
                    <td class="py-3 px-4">
                        {{-- PERBAIKAN: Mengganti via.placeholder.com dengan placehold.co --}}
                        <img src="{{ $information->image_path }}" 
                             alt="Image" 
                             onerror="this.onerror=null; this.src='https://placehold.co/150?text=No+Image'"
                             class="w-16 h-10 object-cover rounded-md border">
                    </td>
                    <td class="py-3 px-4">{{ $information->created_at->format('d/m/y') }}</td>
                    <td class="py-3 px-4 relative">
                        <button 
                            class="bg-blue-600 text-white text-xs px-3 py-2 rounded-md"
                            onclick="toggleDropdown(event, 'dropdown-{{ $information->id }}')">
                            Action ▾
                        </button>
                        <div id="dropdown-{{ $information->id }}" 
                             class="hidden absolute right-0 mt-2 w-36 bg-white border rounded-md shadow-lg z-10">
                            <button 
                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100"
                                onclick="openModal('viewInformationModal-{{ $information->id }}')">
                                View
                            </button>
                            <button 
                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100"
                                onclick="openModal('editInformationModal-{{ $information->id }}')">
                                Edit
                            </button>
                            <button 
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                                onclick="openModal('deleteInformationModal-{{ $information->id }}')">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function toggleDropdown(event, id) {
        event.stopPropagation();
        document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.classList.add('hidden'));
        document.getElementById(id).classList.toggle('hidden');
    }

    window.addEventListener('click', () => {
        document.querySelectorAll('[id^="dropdown-"]').forEach(el => el.classList.add('hidden'));
    });

    function openModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0', 'scale-95');
            modal.classList.add('opacity-100', 'scale-100');
        }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('opacity-100', 'scale-100');
        modal.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 150);
    }

    document.addEventListener('click', (e) => {
        document.querySelectorAll(
            '[id^="addInformationModal"],' +
            '[id^="editInformationModal-"],' +
            '[id^="viewInformationModal-"],' +
            '[id^="deleteInformationModal-"]'
        ).forEach(modal => {
            if (!modal.classList.contains('hidden') && e.target === modal) {
                closeModal(modal.id);
            }
        });
    });
</script>