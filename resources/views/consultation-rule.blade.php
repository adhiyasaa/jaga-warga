<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aturan Konsultasi - Jaga Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { 'custom-blue': '#222E85' } } }
        }
    </script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <x-navbar />
    <div class="min-h-screen w-full flex flex-col items-center justify-center px-6">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl p-8 border border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">📝 Aturan Sebelum Konsultasi</h1>
            <p class="text-gray-600 text-sm mb-6 text-center">Harap membaca dan menyetujui aturan berikut sebelum memulai konsultasi.</p>
            <div class="space-y-4 mb-6">
                <div class="flex items-start gap-3">
                    <span class="text-custom-blue font-bold">1.</span>
                    <p class="text-gray-700 text-sm">Konsultasi ini bersifat rahasia dan informasi yang Anda berikan tidak akan dibagikan tanpa izin.</p>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-custom-blue font-bold">2.</span>
                    <p class="text-gray-700 text-sm">Harap tetap sopan dan tidak menggunakan bahasa kasar atau menyerang.</p>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-custom-blue font-bold">3.</span>
                    <p class="text-gray-700 text-sm">Konsultasi bukan pengganti bantuan profesional darurat. Jika Anda mengalami kondisi gawat, harap hubungi layanan darurat setempat.</p>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-custom-blue font-bold">4.</span>
                    <p class="text-gray-700 text-sm">Pastikan informasi yang Anda berikan jujur, jelas, dan relevan agar psikolog dapat membantu secara optimal.</p>
                </div>
                <div class="flex items-start gap-3">
                    <span class="text-custom-blue font-bold">5.</span>
                    <p class="text-gray-700 text-sm">Psikolog akan merespon sesuai jam kerja. Harap menunggu dengan sabar apabila respons tidak langsung.</p>
                </div>
            </div>
            <div class="flex items-center gap-3 mb-6">
                <input id="agree" type="checkbox" class="w-5 h-5 text-custom-blue border-gray-300 rounded cursor-pointer">
                <label for="agree" class="text-gray-700 text-sm cursor-pointer">
                    Saya sudah membaca dan menyetujui aturan di atas.
                </label>
            </div>
            <button id="continueBtn"
                disabled
                class="w-full bg-gray-300 text-gray-600 font-semibold py-3 rounded-xl mt-2 cursor-not-allowed transition-all">
                Mulai Konsultasi
            </button>
        </div>
        <a href="{{ route('consultation') }}" class="text-sm text-custom-blue hover:text-blue-900 flex items-center gap-1 font-medium py-1 px-2 mt-4 rounded hover:bg-blue-50 transition">
            &larr; <span class="hidden sm:inline">Kembali ke Daftar</span><span class="sm:hidden">Kembali</span>
        </a>
    </div>
    <x-footer/>
    <script>
        const checkbox = document.getElementById('agree');
        const button = document.getElementById('continueBtn');

        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                button.disabled = false;
                button.classList.remove('bg-gray-300', 'cursor-not-allowed', 'text-gray-600');
                button.classList.add('bg-custom-blue', 'text-white', 'hover:bg-blue-900', 'cursor-pointer');
            } else {
                button.disabled = true;
                button.classList.add('bg-gray-300', 'cursor-not-allowed', 'text-gray-600');
                button.classList.remove('bg-custom-blue', 'text-white', 'hover:bg-blue-900', 'cursor-pointer');
            }
        });

        button.addEventListener('click', () => {
            window.location.href = "{{ route('chat.show', $userId ?? 0) }}";
        });
    </script>
</body>
</html>
