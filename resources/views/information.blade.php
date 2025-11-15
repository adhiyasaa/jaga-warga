<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information - Jaga Warga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { 'custom-blue': '#222E85' }
                }
            }
        }
    </script>
</head>
<body class="bg-white">
    <x-navbar />
    <main class="container mx-auto text-black py-12 px-4">
        <h1 class="text-3xl font-agrandir mb-1" style="font-family: 'Agrandir'">Information/Blogspot</h1>
        <p class="text-lg text-black-300 mb-10 max-w-3xl">
            A trusted space to learn, share, and stay informed about sexual harassment prevention and response. Here you'll find resources, articles, and guidance to help create a safer community.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach ($informations as $information) 
                <x-information-card :information="$information" />
            @endforeach
        </div>
    </main>
    <x-footer/>
</body>
</html>
