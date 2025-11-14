<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan (Langkah 2) - Jaga Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom-blue': '#222E85'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-800">

    <x-navbar />

    <main>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <h2 class="text-2xl font-semibold">Make A Report</h2>
                        <p class="text-xl font-normal mb-6 w-1/2">This report is about sexual harassment. We will connect you to the department that handles sexual harassment cases.</p>
                        @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            <strong>Oops! Ada yang salah:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('report.step2.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="incident_type" class="block font-medium text-sm text-gray-700">Type of Incident</label>
                                    <input id="incident_type" class="block mt-1 w-full border border-gray-300 rounded-sm shadow-sm px-1 placeholder:text-sm" type="text" name="incident_type" placeholder="Input type of incident" value="{{ $reportData['incident_type'] ?? old('incident_type') }}" required autofocus />
                                </div>
                                <div>
                                    <label for="incident_date" class="block font-medium text-sm text-gray-700">Date of Incident</label>
                                    <input id="incident_date" class="block mt-1 w-full border border-gray-300 rounded-sm shadow-sm px-1 placeholder:text-sm" type="date" name="incident_date" placeholder="Input incident date" value="{{ $reportData['incident_date'] ?? old('incident_date') }}" required />
                                </div>
                                <div>
                                    <label for="incident_time" class="block font-medium text-sm text-gray-700">Time of Incident</label>
                                    <input id="incident_time" class="block mt-1 w-full border border-gray-300 rounded-sm shadow-sm px-1 placeholder:text-sm" type="time" name="incident_time" placeholder="Input incident time" value="{{ $reportData['incident_time'] ?? old('incident_time') }}" required />
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="incident_location" class="block font-medium text-sm text-gray-700">Location of Incident</label>
                                <input id="incident_location" class="block mt-1 w-full border border-gray-300 rounded-sm shadow-sm px-1 placeholder:text-sm" type="text" name="incident_location" value="{{ $reportData['incident_location'] ?? old('incident_location') }}" required />
                            </div>

                            <div class="mt-4">
                                <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                                <textarea id="description" name="description" rows="5" class="block mt-1 w-full border border-gray-300 rounded-sm shadow-sm px-1 placeholder:text-sm" placeholder="Input description" required>{{ $reportData['description'] ?? old('description') }}</textarea>
                            </div>

                            <div class="mt-4">
                                {{-- PERBAIKAN BUG: Ubah label 'for' --}}
                                <label for="evidence_file" class="block text-sm font-medium text-gray-700 mb-1">
                                    Upload Evidence (Optional)
                                </label>
                                <div id="drop-area" class="flex flex-col items-center justify-center w-full h-28 border-2 border-blue-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-50 transition-colors duration-200">
                                    {{-- PERBAIKAN BUG: Tambah 'name' dan ubah 'id' --}}
                                    <input id="evidence_file" name="evidence_file" type="file" class="hidden" accept="image/*,video/*,application/pdf" />
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    {{-- Tambah id="drop-text" agar mudah diubah JS --}}
                                    <p id="drop-text" class="mt-2 text-sm text-gray-500">
                                        Drop here to attach or <span class="text-blue-600 hover:underline">upload</span>
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        Max size 5MB
                                    </p>
                                </div>
                                @error('evidence_file')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-6">
                                <label class="block font-medium text-sm text-gray-700">Do you want to remain anonymous?</label>
                                <div class="mt-2 flex flex-col md:flex-row md:space-x-6">
                                    @php
                                    $anonValue = $reportData['is_anonymous'] ?? old('is_anonymous', 'no'); // Default 'no'
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="radio" class="text-custom-blue" name="is_anonymous" value="yes" {{ $anonValue == 'yes' ? 'checked' : '' }}>
                                        <span class="ms-2 text-sm text-gray-700">Yes, I want to remain anonymous</span>
                                    </label>
                                    <label class="flex items-center mt-2 md:mt-0">
                                        <input type="radio" class="text-custom-blue" name="is_anonymous" value="no" {{ $anonValue == 'no' ? 'checked' : '' }}>
                                        <span class="ms-2 text-sm text-gray-700">No, I want my data to be included</span>
                                    </label>
                                </div>
                                @error('is_anonymous')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between mt-6">
                                {{-- PERBAIKAN BUG: Arahkan 'Back' ke Step 1 --}}
                                <a href="{{ route('report.step1.show') }}" class="px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">
                                    Back
                                </a>
                                <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-custom-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90">
                                    Submit
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- PERBAIKAN BUG: Perbarui Javascript File Upload --}}
    <script>
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('evidence_file'); // Sesuaikan ID
        const dropText = document.getElementById('drop-text');

        // Klik area drop-zone memicu input file
        dropArea.addEventListener('click', () => {
            fileInput.click();
        });

        // Tampilkan feedback visual saat file dipilih (via klik)
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                dropText.textContent = `Selected ${fileInput.files.length} file(s)!`;
            } else {
                dropText.innerHTML = `Drop here to attach or <span class="text-blue-600 hover:underline">upload</span>`;
            }
        });

        // Event Drag & Drop
        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('bg-gray-100'); 
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('bg-gray-100');
        });

        dropArea.addEventListener('drop', (e) => {
            e.preventDefault(); 
            dropArea.classList.remove('bg-gray-100');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files; // Masukkan file ke input
                dropText.textContent = `Dropped ${files.length} file(s)!`; // Beri feedback
            }
        });
    </script>

</body>
</html>