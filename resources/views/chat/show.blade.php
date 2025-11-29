<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ruang Konsultasi - Jaga Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (window.axios) {
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
                window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { 'custom-blue': '#222E85' } } }
        }
    </script>
    @vite(['resources/js/app.js'])
    <style>
        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
        .custom-scroll::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">
    @php
        $status = isset($consultation) ? $consultation->status : 'pending';
        $isPsychologist = auth()->user()->role === 'Psychologist';
        $isInputDisabled = in_array($status, ['solved', 'cancelled']);
    @endphp

    <div class="h-dvh flex flex-col w-full relative">
        <div class="flex-none z-50 bg-white shadow-sm">
            <x-navbar />
        </div>

        <main class="flex-1 flex flex-col min-h-0 relative bg-gray-50">
            <div class="w-full max-w-7xl mx-auto h-full flex flex-col px-0 sm:px-4 lg:px-6 py-2 sm:py-3">
                
                <div class="flex-none mb-2 px-4 sm:px-0 flex items-center justify-between">
                    <h2 class="font-semibold text-lg text-gray-800 leading-tight hidden sm:block">{{ __('Ruang Konsultasi') }}</h2>
                    <a href="{{ route('consultation') }}" class="text-sm text-custom-blue hover:text-blue-900 flex items-center gap-1 font-medium py-1 px-2 rounded hover:bg-blue-50 transition">
                        &larr; <span class="hidden sm:inline">Kembali ke Daftar</span><span class="sm:hidden">Kembali</span>
                    </a>
                </div>

                <div class="flex-1 bg-white shadow-xl sm:rounded-2xl overflow-hidden border border-gray-200 flex flex-col relative min-h-0"
                     x-data="chatApp({{ auth()->id() }}, {{ $receiver->id }}, {{ Js::from($messages) }})">

                    <div class="flex-none px-4 py-3 border-b border-gray-100 bg-white flex justify-between items-center shadow-sm z-20">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-full bg-custom-blue flex items-center justify-center text-white text-lg font-bold ring-2 ring-white shadow-sm">
                                    {{ substr($receiver->name, 0, 1) }}
                                </div>
                                @if(!$isInputDisabled)
                                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full shadow-sm"></span>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-800 leading-tight">{{ $receiver->name }}</h3>
                                <p class="text-xs text-gray-500">
                                    @if($isInputDisabled)
                                        Sesi Berakhir
                                    @else
                                        Online
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($isPsychologist && !$isInputDisabled)
                            <form action="{{ route('chat.solve', $receiver->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengakhiri sesi percakapan ini? User tidak akan bisa membalas lagi.');">
                                @csrf
                                <button type="submit" class="text-xs bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-100 font-semibold transition-colors flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    End Session
                                </button>
                            </form>
                        @endif
                    </div>

                    <div id="chat-container" class="flex-1 overflow-y-auto p-4 space-y-4 bg-[#F0F2F5] w-full custom-scroll" x-ref="chatContainer">
                        
                        <div class="flex justify-center my-4 opacity-80">
                            @if($isInputDisabled)
                                <span class="text-xs text-gray-500 bg-gray-100 border border-gray-200 px-3 py-1 rounded-full shadow-sm">
                                    Sesi percakapan telah berakhir.
                                </span>
                            @else
                                <span class="text-xs text-gray-500 bg-white border border-gray-200 px-3 py-1 rounded-full shadow-sm flex items-center gap-1">
                                    🔒 Percakapan aman & terenkripsi.
                                </span>
                            @endif
                        </div>

                        <template x-for="msg in messages" :key="msg.id">
                            <div class="flex w-full" :class="msg.sender_id === currentUserId ? 'justify-end' : 'justify-start'">
                                <div class="flex max-w-[85%] sm:max-w-[70%] gap-2"
                                     :class="msg.sender_id === currentUserId ? 'flex-row-reverse' : 'flex-row'">
                                    
                                    <div class="relative px-3 py-2 rounded-2xl shadow-sm text-sm leading-relaxed break-words"
                                         :class="msg.sender_id === currentUserId 
                                            ? 'bg-custom-blue text-white rounded-tr-none' 
                                            : 'bg-white text-gray-800 rounded-tl-none border border-gray-100'">
                                        <p x-text="msg.message" class="whitespace-pre-wrap"></p>
                                        <div class="text-[10px] mt-1 text-right opacity-80"
                                             :class="msg.sender_id === currentUserId ? 'text-blue-100' : 'text-gray-400'">
                                            <span x-text="formatTime(msg.created_at)"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div x-show="isSending" class="flex justify-end">
                            <div class="bg-blue-50 text-custom-blue text-[10px] px-3 py-1 rounded-full animate-pulse">Mengirim...</div>
                        </div>
                    </div>

                    @if(!$isInputDisabled)
                        <div class="flex-none p-3 bg-white border-t border-gray-200 z-20">
                            <form @submit.prevent="sendMessage" class="flex items-end gap-2 bg-gray-50 p-2 rounded-3xl border border-gray-300 focus-within:border-custom-blue focus-within:ring-1 focus-within:ring-custom-blue transition-all shadow-sm">
                                <textarea 
                                    x-model="newMessage" 
                                    @keydown.enter.prevent="if(!$event.shiftKey) sendMessage()"
                                    class="flex-1 bg-transparent border-none focus:ring-0 resize-none h-10 max-h-32 py-2 px-3 text-gray-700 placeholder-gray-400 text-sm focus:outline-none" 
                                    placeholder="Ketik pesan..."
                                    rows="1"></textarea>
                                <button type="submit" 
                                        class="p-2 rounded-full bg-custom-blue text-white hover:bg-blue-900 disabled:opacity-50 transition-all shadow-md flex-none w-10 h-10 flex items-center justify-center"
                                        :disabled="isSending || !newMessage.trim()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rotate-90 translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex-none p-4 bg-gray-50 border-t border-gray-200 z-20 text-center">
                            <p class="text-sm text-gray-500 font-medium flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Sesi ini telah berakhir.
                            </p>
                            @if(!auth()->user()->role === 'Psychologist')
                                <a href="{{ route('consultation') }}" class="text-xs text-custom-blue hover:underline mt-1 inline-block">Mulai konsultasi baru</a>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </main>
    </div>

    <div class="bg-gray-800 relative z-40">
        <x-footer/>
    </div>

    <script>
        function chatApp(currentUserId, receiverId, initialMessages) {
            return {
                currentUserId: currentUserId,
                receiverId: receiverId,
                messages: initialMessages,
                newMessage: '',
                isSending: false,

                init() {
                    this.$nextTick(() => this.scrollToBottom(true));
                    setTimeout(() => this.scrollToBottom(true), 100);

                    const checkEcho = setInterval(() => {
                        if (typeof window.Echo !== 'undefined') {
                            clearInterval(checkEcho);
                            
                            console.log('Echo siap! Mencoba subscribe ke: chat.' + this.currentUserId);

                            window.Echo.private('chat.' + this.currentUserId)
                                .listen('.MessageSent', (e) => {
                                    console.log('Pesan masuk:', e);
                                    if (e.sender_id == this.receiverId) {
                                        this.messages.push({
                                            id: e.id,
                                            message: e.message,
                                            sender_id: e.sender_id,
                                            created_at: e.created_at
                                        });
                                        this.$nextTick(() => this.scrollToBottom(false));
                                    }
                                })
                                .error((error) => {
                                    console.error('Error subscription:', error);
                                });
                        }
                    }, 500); 
                },

                sendMessage() {
                    if (!this.newMessage.trim()) return;
                    this.isSending = true;
                    const messageToSend = this.newMessage; 
                    this.newMessage = ''; 

                    if (typeof window.axios === 'undefined') {
                        alert('Error: Library Axios tidak termuat. Silakan refresh halaman.');
                        this.isSending = false;
                        return;
                    }

                    window.axios.post('/consultation/chat/' + this.receiverId, { message: messageToSend })
                    .then(response => {
                        const data = response.data.message;
                        this.messages.push({
                            id: data.id,
                            message: data.message,
                            sender_id: this.currentUserId,
                            created_at: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
                        });
                        this.$nextTick(() => this.scrollToBottom(false));
                    })
                    .catch(error => {
                        this.newMessage = messageToSend;
                        console.error("Gagal mengirim pesan:", error);
                        alert('Gagal mengirim pesan. Cek koneksi internet.');
                    })
                    .finally(() => {
                        this.isSending = false;
                    });
                },

                scrollToBottom(instant = false) {
                    const container = this.$refs.chatContainer;
                    if (container) {
                        container.scrollTo({
                            top: container.scrollHeight,
                            behavior: instant ? 'auto' : 'smooth'
                        });
                    }
                },

                formatTime(dateString) {
                    if(!dateString) return '';
                    if (dateString.includes(':') && dateString.length <= 8) return dateString;
                    const date = new Date(dateString);
                    return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                }
            }
        }
    </script>
</body>
</html>