<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jaga Warga</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
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
        <!-- Hero Section -->
        <x-hero />
        
        <!-- What To Do Section -->
        <x-what-to-do />
        
        <!-- Information Section -->
        <x-info :informations="$informations" />
        
        <!-- Popular Psychologist (Consul Component) -->
        <!-- PERBAIKAN DISINI: Kirim variabel $users ke dalam komponen -->
        <x-consul :users="$users" />
        
        <!-- Why Jaga Warga Section -->
        <x-why-jaga-warga />
        
        <!-- Emergency Section -->
        <x-emergency />
    </main>

    <x-footer/>
</body>
</html>