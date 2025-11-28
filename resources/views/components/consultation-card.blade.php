<div class="bg-white rounded-3xl shadow-lg w-72 flex-shrink-0 text-center overflow-hidden">

<<<<<<< HEAD
    <img 
        src="image/dogter.png" 
        alt="Psychologist"
        class="w-full h-64 object-cover object-top"
    >

    <div class="p-5">
        <h3 class="font-bold text-gray-800">
            John Doe, S.Psi., Psikolog
        </h3>
        
        <div class="flex justify-center space-x-3 text-sm text-gray-500 my-1">
            <span>90%</span>
            <span>•</span>
            <span>10 Years</span>
        </div>

        <button class="w-full bg-red-800 text-white py-2 rounded-lg mt-3 font-semibold hover:bg-red-900">
            Chat Now
        </button>
=======
@php
    $statusText = '';
    $statusColor = 'hidden'; // Default sembunyi

    $viewer = Auth::user();
    $viewerRole = $viewer ? $viewer->role : 'User';

    if ($user && $user->role === 'Psychologist') {

        $isAvailable = $user->is_available ?? true; 

        if ($isAvailable) {
            $statusText = 'AVAILABLE';
            $statusColor = 'bg-green-500';
        } else {
            $statusText = 'NOT AVAILABLE';
            $statusColor = 'bg-gray-500';
        }
    } 
    elseif ($viewerRole === 'Psychologist' && $user && $user->role !== 'Psychologist') {
        $consultationStatus = $user->consultation_status ?? 'none'; 

        switch ($consultationStatus) {
            case 'pending': // On Request
                $statusText = 'ON REQUEST';
                $statusColor = 'bg-yellow-500';
                break;
            case 'cancelled':
                $statusText = 'CANCELLED';
                $statusColor = 'bg-red-500';
                break;
            case 'active': // On Chat
                $statusText = 'ON CHAT';
                $statusColor = 'bg-green-600';
                break;
            case 'solved':
                $statusText = 'SOLVED';
                $statusColor = 'bg-blue-500';
                break;
            default:
                // Opsional: Jika tidak ada status aktif
                $statusText = ''; 
                $statusColor = 'hidden';
                break;
        }
    }
@endphp

<div class="bg-white rounded-2xl shadow-md w-full max-w-sm flex-shrink-0 text-center overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">

    <div class="h-64 w-full overflow-hidden bg-gray-100 relative group">
        @if($user)
            <img 
                src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff&size=512&font-size=0.33" 
                alt="{{ $user->name }}"
                class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
            >
        @else
             <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                No Image
             </div>
        @endif
        
        {{-- TAMPILAN BADGE STATUS --}}
        <div class="{{ $statusColor }} absolute top-4 right-4 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-sm uppercase tracking-wider">
            {{ $statusText }}
        </div>
    </div>

    <div class="p-5">
        <h3 class="font-bold text-gray-800 text-lg truncate" title="{{ $user->name ?? 'Unknown User' }}">
            {{ $user->name ?? 'Unknown User' }}
        </h3>
        
        <p class="text-custom-blue text-sm font-medium mb-2">
            @if($user && $user->role === 'Psychologist')
                Psikolog Klinis
            @else
                Warga / Pasien
            @endif
        </p>

        @if($user && $user->role === 'Psychologist')
            <div class="flex justify-center items-center text-xs text-gray-500 my-3 bg-gray-50 py-2 rounded-lg border border-gray-100">
                <span class="flex items-center gap-1 font-medium">
                    <svg class="w-4 h-4 text-custom-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    {{ $user->experience ?? '1 Tahun' }} Pengalaman
                </span>
            </div>
        @else
            <div class="my-3 py-2 h-8"></div> 
        @endif

        @if($user)
            {{-- Tombol juga bisa disesuaikan, misal disable jika status Cancelled/Solved --}}
            <a href="{{ route('consultation.rule', $user->id) }}" 
            class="block w-full bg-custom-blue text-white py-2.5 rounded-xl mt-2 font-semibold hover:bg-blue-900 transition-colors shadow-md flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                {{ (Auth::check() && Auth::user()->role === 'Psychologist') ? 'Balas Chat' : 'Chat Sekarang' }}
            </a>
        @else
             <button disabled class="block w-full bg-gray-300 text-white py-2.5 rounded-xl mt-2 font-semibold cursor-not-allowed flex items-center justify-center gap-2">
                User Unavailable
            </button>
        @endif
>>>>>>> 38ffdc1 (Repair: consultation environtment)
    </div>

</div>