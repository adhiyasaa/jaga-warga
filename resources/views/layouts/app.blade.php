<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nama Aplikasi Kamu</title>
    
    {{-- Load Tailwind & Alpine.js (seperti di contoh sebelumnya) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    {{-- Konfigurasi warna custom-blue untuk navbar --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'custom-blue': '#222E85', 
                    }
                }
            }
        }
    </script>

</head>
<body class="bg-gray-800">

    {{-- 1. Komponen Navbar (dari sebelumnya) --}}
    {{-- Kita beri padding agar tidak menempel di tepi --}}
    <div class="p-4">
        <x-navbar />
    </div>

    {{-- 2. Komponen Hero (BARU) --}}
    {{-- Hero ini akan ditempatkan tepat di bawah navbar --}}
    <x-hero />

    <main>
        {{-- Konten halaman lain bisa ditaruh di sini --}}
        <div class="text-white p-8">
            Konten selanjutnya...
        </div>
    </main>

</body>
</html>