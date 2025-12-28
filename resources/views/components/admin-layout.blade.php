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
                <a href="{{ route('admin') }}" class="flex items-center gap-3 px-4 py-3 bg-indigo-600 rounded-xl text-sm font-bold transition shadow-lg shadow-indigo-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('events.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-xl text-sm font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Manage Events
                </a>
                <a href="{{ route('artists.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-xl text-sm font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/></svg>
                    Manage Artists
                </a>
                <a href="{{ route('ticket-types.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-xl text-sm font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    Ticket Types
                </a>
                <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-xl text-sm font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Order Items
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

            {{-- ADMIN FILTER PANEL --}}
            <section class="px-8 pt-6">
                <div class="bg-black rounded-2xl border border-gray-800 shadow-lg p-6">
                    <form method="GET" action="{{ route('admin') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                            <!-- Type -->
                            <div>
                                <label class="block text-[11px] font-medium text-gray-400 mb-1">Data Type</label>
                                <select name="type" class="w-full bg-gray-900/60 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none">
                                    <option value="events" {{ request('type', 'events') == 'events' ? 'selected' : '' }}>Events</option>
                                    <option value="artists" {{ request('type') == 'artists' ? 'selected' : '' }}>Artists</option>
                                    <option value="orders" {{ request('type') == 'orders' ? 'selected' : '' }}>Orders</option>
                                    <option value="tickets" {{ request('type') == 'tickets' ? 'selected' : '' }}>Tickets</option>
                                </select>
                            </div>
                            <!-- Search -->
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-medium text-gray-400 mb-1">Search</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center">
                                        <i class="fa-solid fa-magnifying-glass text-gray-500"></i>
                                    </span>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="w-full bg-gray-900/60 border border-gray-700 rounded-md pl-9 pr-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none">
                                </div>
                            </div>
                            <!-- Status -->
                            <div>
                                <label class="block text-[11px] font-medium text-gray-400 mb-1">Status</label>
                                <select name="status" class="w-full bg-gray-900/60 border border-gray-700 rounded-md px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none">
                                    <option value="">All Status</option>
                                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                            <!-- Date From -->
                            <div>
                                <label class="block text-[11px] font-medium text-gray-400 mb-1">Date From</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center">
                                        <i class="fa-solid fa-calendar text-gray-500"></i>
                                    </span>
                                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full bg-gray-900/60 border border-gray-700 rounded-md pl-9 pr-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none">
                                </div>
                            </div>
                            <!-- Date To -->
                            <div>
                                <label class="block text-[11px] font-medium text-gray-400 mb-1">Date To</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center">
                                        <i class="fa-solid fa-calendar text-gray-500"></i>
                                    </span>
                                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full bg-gray-900/60 border border-gray-700 rounded-md pl-9 pr-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none">
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-3 justify-end">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md text-sm font-semibold transition flex items-center gap-2">
                                <i class="fa-solid fa-filter"></i>
                                Apply Filter
                            </button>
                            <a href="{{ route('admin') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-md text-sm font-semibold transition flex items-center gap-2">
                                <i class="fa-solid fa-rotate-left"></i>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </section>

            <main class="p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>