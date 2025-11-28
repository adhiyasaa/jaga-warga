@props(['reports'])

{{-- Header / Filter Area (Jika diperlukan di masa depan) --}}
<div class="flex justify-between items-center mb-6">
    {{-- Kosong atau bisa diisi search bar --}}
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 text-gray-600 font-semibold border-b">
            <tr>
                <th class="py-4 px-6">ID</th>
                <th class="py-4 px-6">Name</th>
                <th class="py-4 px-6">Created Date</th>
                <th class="py-4 px-6">Type of Incident</th>
                <th class="py-4 px-6">Location</th>
                <th class="py-4 px-6">Status</th>
                <th class="py-4 px-6">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach ($reports as $report)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-4 px-6 font-medium text-gray-900">{{ $report->id }}</td>
                    <td class="py-4 px-6">{{ $report->user->name ?? $report->first_name }}</td>
                    <td class="py-4 px-6">{{ $report->created_at->format('d/m/y') }}</td>
                    <td class="py-4 px-6">{{ $report->incident_type }}</td>
                    <td class="py-4 px-6">{{ $report->incident_location }}</td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                            {{ $report->status === 'Solved' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $report->status }}
                        </span>
                    </td>
                    <td class="py-4 px-6 relative">
                        {{-- Tombol Utama Action --}}
                        <button 
                            class="bg-blue-600 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors flex items-center gap-1"
                            onclick="toggleDropdown(event, 'dropdown-{{ $report->id }}')">
                            Action ▾
                        </button>
                        
                        {{-- Dropdown Menu --}}
                        <div id="dropdown-{{ $report->id }}" 
                             class="hidden absolute right-0 mt-2 w-32 bg-white border border-gray-100 rounded-lg shadow-xl z-20 overflow-hidden">
                            
                            {{-- Trigger View --}}
                            <button class="block w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-50 font-medium"
                                onclick="openModal('viewReportModal-{{ $report->id }}')">
                                View
                            </button>
                            
                            {{-- Trigger Solve (Opsional, logika bisa via form atau modal edit) --}}
                            <form action="{{ route('admin.report.solve', $report->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-gray-50 font-medium">
                                    Solve
                                </button>
                            </form>

                            {{-- Trigger Delete --}}
                            <button class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50 font-medium"
                                onclick="openModal('deleteReportModal-{{ $report->id }}')">
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
            '[id^="viewReportModal-"],' +
            '[id^="deleteReportModal-"]'
        ).forEach(modal => {
            if (!modal.classList.contains('hidden') && e.target === modal) {
                closeModal(modal.id);
            }
        });
    });
</script>