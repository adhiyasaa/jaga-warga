<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan (Langkah 1) - Jaga Warga</title>
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

                        <form method="POST" action="{{ route('report.step1.store') }}">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block font-medium text-sm text-gray-700">First Name</label>
                                    <input id="first_name" class="block mt-1 w-full border border-gray-300 rounded-sm shadow-sm px-1 placeholder:text-sm" type="text" name="first_name" placeholder="Enter your first name" value="{{ $reportData['first_name'] ?? old('first_name') }}" required autofocus />
                                </div>
                                <div>
                                    <label for="last_name" class="block font-medium text-sm text-gray-700">Last Name</label>
                                    <input id="last_name" class="block mt-1 w-full border border-gray-300 rounded-sm shadow-sm px-1 placeholder:text-sm" type="text" name="last_name" placeholder="Enter your last name" value="{{ $reportData['last_name'] ?? old('last_name') }}" required />
                                </div>
                                <div>
                                    <label for="place_of_birth" class="block font-medium text-sm text-gray-700">Place of Birth</label>
                                    <input id="place_of_birth" class="block mt-1 w-full border border-gray-300 rounded-sm shadow-sm px-1 placeholder:text-sm" type="text" name="place_of_birth" placeholder="Enter your place of birth" value="{{ $reportData['place_of_birth'] ?? old('place_of_birth') }}" required />
                                </div>
                                <div>
                                    <label for="date_of_birth" class="block font-medium text-sm text-gray-700">Date of Birth</label>
                                    <input id="date_of_birth" class="block mt-1 w-full border border-gray-300 rounded-sm shadow-sm px-1 placeholder:text-sm" type="date" name="date_of_birth" placeholder="Enter your date of birth" value="{{ $reportData['date_of_birth'] ?? old('date_of_birth') }}" required />
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="home_address" class="block font-medium text-sm text-gray-700">Home Address</label>
                                <input id="home_address" name="home_address" rows="3" class="block mt-1 w-full border border-gray-300 rounded-sm shadow-sm px-1 placeholder:text-sm" placeholder="Enter your address" required>{{ $reportData['home_address'] ?? old('home_address') }}</input>
                            </div>

                            <div>
                                <label for="email" class="block mt-4 font-medium text-sm text-gray-700">Email</label>
                                <input id="email" class="block mt-1 w-full border border-gray-300 rounded-sm shadow-sm px-1 placeholder:text-sm" type="email" name="email" placeholder="Enter your email" value="{{ $reportData['email'] ?? old('email') }}" required />
                            </div>
                            <div>
                                <label for="phone_number" class="block mt-4 font-medium text-sm text-gray-700">Phone Number</label>
                                <input id="phone_number" class="block mt-1 w-full border border-gray-300 rounded-sm shadow-sm px-1 placeholder:text-sm" type="tel" name="phone_number" placeholder="Enter your phone number" value="{{ $reportData['phone_number'] ?? old('phone_number') }}" required />
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <button type="submit" class="ms-4 inline-flex items-center px-6 py-2 bg-custom-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Next
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer/>

</body>

</html>