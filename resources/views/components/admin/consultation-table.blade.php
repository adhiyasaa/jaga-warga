@props(['consultations'])

<div class="bg-white rounded-lg border border-gray-300 p-2">
    <table class="w-full text-sm text-left">
        <thead class="text-gray-600 font-semibold border-b">
            <tr>
                <th class="py-3 px-4">ID</th>
                <th class="py-3 px-4">Patient</th>
                <th class="py-3 px-4">Psychologist</th>
                <th class="py-3 px-4">Created Date</th>
                <th class="py-3 px-4">Status</th>
                <th class="py-3 px-4">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach ($consultations as $consultation)
                <tr>
                    <td class="py-3 px-4">#{{ $consultation->id }}</td>
                    <td class="py-3 px-4">
                        <div class="font-medium text-gray-900">{{ $consultation->user->name ?? 'Unknown' }}</div>
                        <div class="text-xs text-gray-500">{{ $consultation->user->email ?? '-' }}</div>
                    </td>
                    <td class="py-3 px-4">
                        <div class="font-medium text-gray-900">{{ $consultation->psychologist->name ?? 'Unknown' }}</div>
                    </td>
                    <td class="py-3 px-4">
                        <div>{{ $consultation->created_at->format('d/m/y') }}</div>
                        <div class="text-xs text-gray-500">{{ $consultation->created_at->format('H:i') }}</div>
                    </td>
                    <td class="py-3 px-4">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'active' => 'bg-green-100 text-green-700',
                                'solved' => 'bg-blue-100 text-blue-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                            $statusLabels = [
                                'pending' => 'On Request',
                                'active' => 'On Chat',
                                'solved' => 'Solved',
                                'cancelled' => 'Cancelled',
                            ];
                            $status = $consultation->status;
                        @endphp
                        <span class="px-3 py-1 rounded-md text-xs font-medium {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $statusLabels[$status] ?? ucfirst($status) }}
                        </span>
                    </td>
                    <td class="py-3 px-4 relative">
                        <button 
                            class="bg-blue-600 text-white text-xs px-3 py-2 rounded-md"
                            onclick="toggleDropdown(event, 'dropdown-{{ $consultation->id }}')">
                            Action ▾
                        </button>
                        <div id="dropdown-{{ $consultation->id }}" 
                             class="hidden absolute right-0 mt-2 w-36 bg-white border rounded-md shadow-lg z-10">
                            <button 
                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100"
                                onclick="openModal('viewConsultationModal-{{ $consultation->id }}')">
                                View
                            </button>
                            <button 
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                                onclick="openModal('deleteConsultationModal-{{ $consultation->id }}')">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    {{-- Pagination jika ada --}}
    @if(method_exists($consultations, 'links'))
        <div class="mt-4 px-4">
            {{ $consultations->links() }}
        </div>
    @endif
</div>

<script>
    function toggleDropdown(event, id) {
        event.stopPropagation();
        document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
            if (el.id !== id) el.classList.add('hidden');
        });
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
            '[id^="viewConsultationModal-"],' +
            '[id^="deleteConsultationModal-"]'
        ).forEach(modal => {
            if (!modal.classList.contains('hidden') && e.target === modal) {
                closeModal(modal.id);
            }
        });
    });
</script>