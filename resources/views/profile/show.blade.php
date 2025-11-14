<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Jaga Warga</title>
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

<body class="bg-gray-100"> {{-- Ganti ke bg-gray-100 agar kartu putih terlihat --}}

    <x-navbar />

    <main>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <h2 class="text-2xl font-semibold text-gray-900">
                    My Profile
                </h2>
                
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ $user->name }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ $user->email }}
                            </p>
                            <p class="mt-1 text-sm font-medium text-custom-blue capitalize">
                                {{-- Menampilkan role --}}
                                Role: {{ $user->role }}
                            </p>
                        </header>
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">
                            {{ __('Profile Settings') }}
                        </h2>
                        
                        <div class="space-y-4">
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-custom-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-80 focus:bg-opacity-80 active:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Edit Profile Information
                            </a>
                            <p class="mt-1 text-sm text-gray-600">
                                Perbarui informasi nama dan email Anda.
                            </p>
                            
                            <hr class="my-4">

                            <a href="{{ route('profile.history') }}" class="inline-flex items-center px-4 py-2 bg-custom-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-80 focus:bg-opacity-80 active:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                View Report History
                            </a>
                            <p class="mt-1 text-sm text-gray-600">
                                Lihat semua laporan yang telah Anda kirimkan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">
                            {{ __('Security') }}
                        </h2>
                        
                        <div class="space-y-4">
                            <a href="{{ route('profile.edit') }}#update-password" class="text-sm text-custom-blue hover:underline">
                                Update Password
                            </a>
                            <p class="mt-1 text-sm text-gray-600">
                                Pastikan akun Anda aman dengan kata sandi yang kuat.
                            </p>
                            
                            <hr class="my-4">

                            <a href="{{ route('profile.edit') }}#delete-account" class="text-sm text-red-600 hover:underline">
                                Delete Account
                            </a>
                            <p class="mt-1 text-sm text-gray-600">
                                Hapus akun Anda secara permanen.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>