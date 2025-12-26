<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} | WalkAtWallClouds</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-900 text-white" x-data="{ search: '' }">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-black border-r border-white/10 hidden md:block">
            <div class="p-6">
                <a href="/" class="text-xl font-bold tracking-wider text-indigo-400">WALK ADMIN</a>
            </div>
            <nav class="mt-6 px-4">
                <a href="#" class="flex items-center gap-3 p-3 bg-indigo-600 rounded-xl text-white">
                    <i class="fa-solid fa-chart-line"></i> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 p-3 text-gray-400 hover:text-white transition mt-2">
                    <i class="fa-solid fa-ticket"></i> Tickets
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="h-20 bg-gray-900 border-b border-white/5 px-8 flex items-center justify-between sticky top-0 z-40">
                <div class="relative w-full max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-magnifying-glass text-gray-500"></i>
                    </span>
                    <input 
                        type="text" 
                        x-model="search"
                        placeholder="Live Search data admin..." 
                        class="w-full bg-gray-800 border border-white/10 rounded-xl py-2 pl-10 pr-4 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all placeholder-gray-500"
                    >
                </div>

                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-400">{{ auth()->user()->name ?? 'Admin Name' }}</span>
                    <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center font-bold">
                        A
                    </div>
                </div>
            </header>

            <main class="p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

   
</body>
</html>