<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Tambahkan enctype="multipart/form-data" agar bisa upload file --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- FOTO PROFIL --}}
        <div>
            <label class="block font-medium text-sm text-gray-700" for="avatar">
                Photo Profile
            </label>
            <div class="mt-2 flex items-center gap-4">
                {{-- Preview Gambar Saat Ini --}}
                <div class="shrink-0">
                    @if($user->avatar_url)
                        <img class="h-16 w-16 object-cover rounded-full border border-gray-300" src="{{ $user->avatar_url }}" alt="Avatar" />
                    @else
                        <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs">
                            No Img
                        </div>
                    @endif
                </div>
                
                {{-- Input File --}}
                <input type="file" name="avatar" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        {{-- NAMA --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- EMAIL --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- KHUSUS PSIKOLOG --}}
        @if($user->role === 'Psychologist')
            <div class="pt-4 mt-4 border-t border-gray-200">
                <h3 class="text-md font-bold text-custom-blue mb-4">Psychologist Settings</h3>
                
                {{-- Experience --}}
                <div class="mb-4">
                    <x-input-label for="experience" :value="__('Work Experience (Contoh: 3 Tahun)')" />
                    <x-text-input id="experience" name="experience" type="text" class="mt-1 block w-full" :value="old('experience', $user->experience)" />
                    <x-input-error class="mt-2" :messages="$errors->get('experience')" />
                </div>

                {{-- Status Available --}}
                <div class="flex items-start mt-4">
                    <div class="flex items-center h-5">
                        <input id="is_available" name="is_available" type="checkbox" value="1" {{ $user->is_available ? 'checked' : '' }} class="w-4 h-4 text-custom-blue border-gray-300 rounded focus:ring-custom-blue">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_available" class="font-medium text-gray-700">Set Status as Available (Online)</label>
                        <p class="text-gray-500">Jika dimatikan, status Anda akan terlihat "Not Available" oleh pasien.</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>