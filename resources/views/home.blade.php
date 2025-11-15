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
    <x-navbar/>
    <main>
        <x-hero />
        <x-what-to-do />
        <x-info :informations="$informations" />
        <x-consul />
        <x-why-jaga-warga />
        <x-emergency />
    </main>
    <x-footer/>
</body>
</html>
