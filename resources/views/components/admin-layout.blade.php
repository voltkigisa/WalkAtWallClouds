<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} | WalkAtWallClouds</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans" x-data="{ search: '' }">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-black border-r border-gray-800 hidden md:block fixed h-full z-50">
            <div class="p-6">
                <h1 class="text-xl font-black text-indigo-500 tracking-tighter uppercase italic">
                    WalkAtWall <span class="text-white">Clouds</span>
                </h1>
            </div>
            <nav class="mt-4 px-4 space-y-1">
                <p class="text-[10px] font-bold text-gray-500 uppercase px-4 mb-2 tracking-widest">Main Menu</p>
                <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'bg-indigo-600 shadow-indigo-500/20' : 'text-gray-400 hover:bg-gray-800' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition">
                    <i class="fa-solid fa-chart-pie w-5"></i> Dashboard
                </a>
                <a href="/admin/events" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-xl text-sm font-semibold transition">
                    <i class="fa-solid fa-calendar-days w-5"></i> Manage Events
                </a>
                <div class="pt-10">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-500/10 rounded-xl text-sm font-bold transition">
                            <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <div class="flex-1 md:ml-64 flex flex-col min-h-screen">
            <header class="h-20 bg-gray-900/50 backdrop-blur-md border-b border-white/5 px-8 flex items-center justify-between sticky top-0 z-40">
                <div class="relative w-full max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-magnifying-glass text-gray-500"></i>
                    </span>
                    <input type="text" x-model="search" placeholder="Live Search data admin..." 
                        class="w-full bg-gray-800 border border-white/10 rounded-xl py-2 pl-10 pr-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder-gray-500">
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-white uppercase">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-widest">Administrator</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center font-bold shadow-lg shadow-indigo-500/30">
                        {{ substr(Auth::user()->name, 0, 1) }}
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