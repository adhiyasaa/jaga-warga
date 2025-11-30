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

<body class="bg-gray-100">

    <x-navbar />

    <main>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <h2 class="text-2xl font-semibold text-gray-900">
                    My Profile
                </h2>
                
                {{-- SECTION 1: HEADER PROFIL (FOTO & INFO UTAMA) --}}
                <div class="p-6 bg-white shadow sm:rounded-lg flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    
                    {{-- Foto Profil --}}
                    <div class="shrink-0">
                        @if($user->avatar_url)
                            <img class="h-32 w-32 rounded-full object-cover border-4 border-gray-100 shadow-sm" 
                                 src="{{ $user->avatar_url }}" 
                                 alt="{{ $user->name }}">
                        @else
                            <img class="h-32 w-32 rounded-full object-cover border-4 border-gray-100 shadow-sm" 
                                 src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff&size=256" 
                                 alt="{{ $user->name }}">
                        @endif
                    </div>

                    {{-- Info User --}}
                    <div class="flex-1 text-center sm:text-left">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        
                        {{-- Badge / Label --}}
                        <div class="mt-3 flex flex-wrap gap-2 justify-center sm:justify-start">
                            {{-- Badge Role --}}
                            <span class="px-3 py-1 bg-blue-100 text-custom-blue rounded-full text-sm font-medium">
                                Role: {{ $user->role }}
                            </span>

                            {{-- Badge Khusus Psikolog --}}
                            @if($user->role === 'Psychologist')
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                                    Exp: {{ $user->experience ?? '-' }}
                                </span>
                                
                                {{-- Indikator Status --}}
                                <span class="px-3 py-1 {{ $user->is_available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-full text-sm font-medium">
                                    {{ $user->is_available ? 'Available' : 'Not Available' }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: PROFILE SETTINGS --}}
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
                                Perbarui informasi nama, foto profil, dan email Anda.
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

                {{-- SECTION 3: SECURITY --}}
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