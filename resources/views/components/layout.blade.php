@props(['title' => null])
<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'WalkAtWallClouds' }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    @vite(['resources/js/navbar.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @stack('styles')
</head>
<body class="bg-gray-900 min-h-screen text-gray-100 flex flex-col">

    {{-- Modal Search telah dihapus dari sini --}}

    <nav class="sticky top-0 z-50 bg-black/80 backdrop-blur-md border-b border-white/5">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="relative flex h-20 items-center justify-between">
                
                <div class="flex items-center">
                    <div class="flex items-center md:hidden mr-4">
                        <button id="menu-btn" type="button" class="text-gray-400 hover:text-white focus:outline-none transition">
                            <svg id="menu-icon" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>

                    <a href="/" class="text-xl font-black tracking-tighter uppercase italic text-indigo-500">
                        WalkAtWall <span class="text-white">Clouds</span>
                    </a>
                    
                    <div class="hidden md:ml-12 md:block">
                        <div class="flex space-x-8">
                            <a href="/" class="text-sm font-bold text-gray-400 hover:text-indigo-400 transition uppercase tracking-widest">Home</a>
                            <a href="/#guest-star" class="text-sm font-bold text-gray-400 hover:text-indigo-400 transition uppercase tracking-widest">Guest Star</a>
                            <a href="/#ticket" class="text-sm font-bold text-gray-400 hover:text-indigo-400 transition uppercase tracking-widest">Ticket</a>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-x-6">
                    {{-- Tombol Search dihapus agar tidak memicu error Alpine --}}

                    <div class="flex items-center gap-4">
                        <a href="{{ route('cart.index') }}" class="relative group p-2.5 bg-white/5 border border-white/10 rounded-xl hover:bg-indigo-600/20 hover:border-indigo-500/50 transition">
                            <i class="fa-solid fa-cart-shopping text-gray-400 group-hover:text-indigo-400 transition text-sm"></i>
                            @php
                                $cart = session()->get('cart', []);
                                $cartCount = array_sum(array_column($cart, 'quantity'));
                            @endphp
                            @if($cartCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-indigo-600 text-[9px] font-black w-5 h-5 flex items-center justify-center rounded-full border border-gray-900 shadow-lg group-hover:scale-110 transition">
                                {{ $cartCount }}
                            </span>
                            @else
                            <span class="absolute -top-1.5 -right-1.5 bg-gray-700 text-[9px] font-black w-5 h-5 flex items-center justify-center rounded-full border border-gray-900 shadow-lg">
                                0
                            </span>
                            @endif
                        </a>

                        @guest
                            <a href="{{ route('login') }}" class="text-sm font-black uppercase tracking-widest hover:text-indigo-500 transition">Login</a>
                        @else
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin') }}" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-xl transition shadow-lg shadow-indigo-500/20">
                                    <i class="fa-solid fa-gauge text-white text-sm"></i>
                                    <span class="text-xs font-black uppercase tracking-widest text-white hidden sm:inline">Dashboard</span>
                                </a>
                            @endif
                            
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="flex items-center gap-3 bg-white/5 border border-white/10 p-1.5 rounded-2xl hover:bg-white/10 transition outline-none">
                                    <div class="w-8 h-8 rounded-xl bg-indigo-600 flex items-center justify-center font-black text-xs text-white">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <span class="text-xs font-bold mr-1 hidden sm:inline">{{ auth()->user()->name }}</span>
                                    <i class="fa-solid fa-chevron-down text-[10px] text-gray-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                                </button>

                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-gray-900 border border-white/10 rounded-2xl shadow-xl z-[60] overflow-hidden"
                                     style="display: none;">
                                    
                                    <div class="px-4 py-3 border-b border-white/5">
                                        <p class="text-xs font-bold text-white">{{ auth()->user()->name }}</p>
                                        <p class="text-[10px] text-gray-500">{{ auth()->user()->email }}</p>
                                    </div>
                                    
                                    <a href="{{ route('users.show', auth()->id()) }}" class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold text-indigo-400 hover:bg-indigo-500/10 transition group text-left">
                                        <i class="fa-solid fa-user group-hover:scale-110 transition"></i>
                                        MY PROFILE
                                    </a>
                                    
                                    <a href="{{ route('my-tickets.index') }}" class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold text-green-400 hover:bg-green-500/10 transition group text-left">
                                        <i class="fa-solid fa-ticket group-hover:scale-110 transition"></i>
                                        MY TICKETS
                                    </a>
                                    
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold text-red-400 hover:bg-red-500/10 transition group text-left">
                                            <i class="fa-solid fa-right-from-bracket group-hover:translate-x-1 transition"></i>
                                            LOGOUT
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div> 
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-black/95 border-t border-white/5 px-4 py-6 space-y-4 shadow-2xl">
            <a href="#home" class="block text-sm font-bold text-gray-400 hover:text-indigo-400 uppercase tracking-widest transition">Home</a>
            <a href="#guest-star" class="block text-sm font-bold text-gray-400 hover:text-indigo-400 uppercase tracking-widest transition">Guest Star</a>
            <a href="#ticket" class="block text-sm font-bold text-gray-400 hover:text-indigo-400 uppercase tracking-widest transition">Ticket</a>
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
</body>
</html>