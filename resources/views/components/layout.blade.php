@props(['title' => null])
<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'WalkAtWallClouds' }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @stack('styles')
</head>
<body x-data="{ showSearch: false, search: '' }" 
      @keydown.escape.window="showSearch = false"
      class="bg-gray-900 min-h-screen text-gray-100 flex flex-col">

    <div x-show="showSearch" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[60] bg-black/90 backdrop-blur-sm flex justify-center pt-20 px-4"
         style="display: none;">
        
        <div @click.away="showSearch = false" 
             class="w-full max-w-2xl bg-gray-900 rounded-2xl border border-white/10 shadow-2xl overflow-hidden h-fit">
            
            <div class="p-5 border-b border-white/10 flex items-center gap-4">
                <i class="fa-solid fa-magnifying-glass text-indigo-500 text-xl"></i>
                <input type="text" 
                       x-model="search"
                       placeholder="Cari Guest Star, Tiket, atau Event..." 
                       class="bg-transparent w-full border-none focus:ring-0 text-lg text-white placeholder-gray-500"
                       autofocus>
                <button @click="showSearch = false" class="text-[10px] font-bold text-gray-500 hover:text-white border border-white/10 px-2 py-1 rounded">ESC</button>
            </div>

            <div class="max-h-[350px] overflow-y-auto p-4">
                <div x-show="search.length > 0">
                    <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-3">Hasil untuk: <span x-text="search" class="text-white"></span></p>
                    
                    <div class="space-y-2">
                        <div class="p-3 rounded-xl hover:bg-white/5 border border-transparent hover:border-white/10 transition cursor-pointer group">
                            <h4 class="font-bold text-gray-200 group-hover:text-indigo-400 transition">Contoh Hasil Pencarian</h4>
                            <p class="text-xs text-gray-500">Ketikkan sesuatu untuk mulai mencari...</p>
                        </div>
                    </div>
                </div>

                <div x-show="search.length === 0" class="text-center py-10">
                    <i class="fa-solid fa-search text-gray-700 text-4xl mb-3"></i>
                    <p class="text-gray-500 text-sm">Cari apapun di WalkAtWallClouds...</p>
                </div>
            </div>
        </div>
    </div>

    <nav class="sticky top-0 z-50 bg-black/80 backdrop-blur-md after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="relative flex h-20 items-center justify-between">
                
                <div class="flex items-center">
                    <a href="/" class="text-xl font-extrabold tracking-wider uppercase text-indigo-400">
                        WalkAtWallClouds
                    </a>
                    <div class="hidden md:ml-12 md:block">
                        <div class="flex space-x-8">
                            <a href="#home" class="nav-link rounded-md px-3 py-2 text-sm font-medium text-white hover:bg-white/10 transition">Home</a>
                            <a href="#guest-star" class="nav-link rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:text-white transition">Guest Star</a>
                            <a href="#ticket" class="nav-link rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:text-white transition">Ticket</a>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-x-4">
                    <button @click="showSearch = true" type="button" class="text-gray-400 hover:text-white transition p-1">
                        <i class="fa-solid fa-magnifying-glass text-xl"></i>
                    </button>

                    <button type="button" class="relative rounded-full p-1 text-gray-400 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-indigo-500 text-[10px] font-bold text-white">0</span>
                    </button>

                    @guest
                        <a href="{{ route('login') }}" class="hidden sm:block rounded-md bg-indigo-600 px-5 py-2 text-sm font-bold text-white hover:bg-indigo-700 transition">
                            Login
                        </a>
                    @else
                        <div class="hidden sm:flex items-center gap-3">
                            <span class="text-gray-200 font-semibold">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition">Logout</button>
                            </form>
                        </div>
                    @endguest

                    <button id="menu-btn" class="md:hidden text-gray-400 hover:text-white focus:outline-none">
                        <svg id="menu-icon" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div> 
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="bg-black py-12 border-t border-white/5 text-center">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex justify-center items-center gap-6 md:gap-10 mb-8">
                <a href="https://instagram.com/WalkAtWallClouds.id" target="_blank" class="group flex flex-col items-center gap-2">
                    <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-900 group-hover:bg-gradient-to-tr group-hover:from-yellow-400 group-hover:via-red-500 group-hover:to-purple-600 transition-all duration-300">
                        <i class="fa-brands fa-instagram text-xl text-gray-400 group-hover:text-white"></i>
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 group-hover:text-white uppercase tracking-tighter">Instagram</span>
                </a>

                <a href="https://youtube.com/@WalkAtWallClouds.id" target="_blank" class="group flex flex-col items-center gap-2">
                    <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-900 group-hover:bg-red-600 transition-all duration-300">
                        <i class="fa-brands fa-youtube text-xl text-gray-400 group-hover:text-white"></i>
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 group-hover:text-white uppercase tracking-tighter">YouTube</span>
                </a>

                <a href="https://x.com/WalkAtWallClouds.id" target="_blank" class="group flex flex-col items-center gap-2">
                    <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-900 group-hover:bg-white transition-all duration-300">
                        <i class="fa-brands fa-x-twitter text-xl text-gray-400 group-hover:text-black"></i>
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 group-hover:text-white uppercase tracking-tighter">Twitter</span>
                </a>

                <a href="https://facebook.com/WalkAtWallClouds.id" target="_blank" class="group flex flex-col items-center gap-2">
                    <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-900 group-hover:bg-blue-600 transition-all duration-300">
                        <i class="fa-brands fa-facebook text-xl text-gray-400 group-hover:text-white"></i>
                    </div>
                    <span class="text-[10px] font-bold text-gray-500 group-hover:text-white uppercase tracking-tighter">Facebook</span>
                </a>
            </div>

            <div class="h-px w-20 bg-indigo-500 mx-auto mb-6"></div>
            <p class="text-gray-600 text-[10px] tracking-widest uppercase font-medium">
                &copy; 2025 WalkAtWallClouds. All rights reserved.
            </p>
        </div>
    </footer>

    @stack('scripts')
    <script src="{{ asset('js/navbar.js') }}"></script>
</body>
</html>