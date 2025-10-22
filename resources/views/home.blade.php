
</nav>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <title>Jaga Warga</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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

    {{-- 
      1. Navbar diletakkan di SINI, langsung di dalam <body>. 
         Ini memberinya "zona sendiri" dan secara alami akan 
         mendorong <main> ke bawah. 
         Karena memiliki class 'sticky', ia akan menempel saat di-scroll.
    --}}
    <x-navbar />

    {{-- 
      2. Konten utama dimulai SETELAH navbar.
         Ini memastikan konten hero TIDAK TERTUMPUK saat halaman dimuat.
    --}}
    <main>
        <x-hero />
        <x-what-to-do />
    </main>



</body>
</html>
