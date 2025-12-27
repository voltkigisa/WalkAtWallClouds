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
<body x-data="searchHandler()" 
      @keydown.escape.window="showSearch = false"
      @keydown.window.ctrl.k.prevent="showSearch = true"
      class="bg-gray-900 min-h-screen text-gray-100 flex flex-col">

    {{-- MODAL SEARCH --}}
    <div x-show="showSearch" 
         x-trap.noscroll="showSearch"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 backdrop-blur-0"
         x-transition:enter-end="opacity-100 backdrop-blur-sm"
         x-transition:leave="transition ease-in duration-200"
         class="fixed inset-0 z-[60] bg-black/80 flex justify-center pt-20 px-4"
         style="display: none;">
        
        <div @click.away="showSearch = false" 
             class="w-full max-w-2xl bg-gray-900 rounded-3xl border border-white/10 shadow-[0_0_50px_-12px_rgba(79,70,229,0.5)] overflow-hidden h-fit">
            
            <div class="p-6 border-b border-white/5 flex items-center gap-4 bg-black/20">
                <template x-if="!isLoading">
                    <i class="fa-solid fa-magnifying-glass text-indigo-500 text-xl"></i>
                </template>
                <template x-if="isLoading">
                    <i class="fa-solid fa-circle-notch fa-spin text-indigo-500 text-xl"></i>
                </template>

                <input type="text" 
                       x-model.debounce.500ms="search"
                       @input="fetchResults"
                       placeholder="Cari Guest Star, Tiket, atau Event..." 
                       class="bg-transparent w-full border-none focus:ring-0 text-lg text-white placeholder-gray-600 outline-none"
                       autofocus>
                
                <div class="flex items-center gap-2">
                    <span class="text-[10px] text-gray-600 font-bold border border-white/10 px-2 py-1 rounded-md uppercase">Ctrl + K</span>
                    <button @click="showSearch = false" class="text-gray-500 hover:text-white transition">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
            </div>

            <div class="max-h-[400px] overflow-y-auto p-4 bg-gray-900/50">
                <div x-show="search.length === 0" class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/5">
                        <i class="fa-solid fa-keyboard text-gray-600 text-2xl"></i>
                    </div>
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Mulai mengetik untuk mencari...</p>
                </div>

                <div x-show="isLoading" class="space-y-3 p-2">
                    <div class="h-16 bg-white/5 animate-pulse rounded-2xl w-full"></div>
                    <div class="h-16 bg-white/5 animate-pulse rounded-2xl w-full"></div>
                </div>

                <div x-show="!isLoading && results.length > 0">
                    <p class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-4 px-2">
                        Search Results (<span x-text="results.length"></span>)
                    </p>
                    <div class="space-y-2">
                        <template x-for="item in results" :key="item.id">
                            <a :href="item.url" class="flex items-center gap-4 p-3 rounded-2xl hover:bg-indigo-600/10 border border-transparent hover:border-indigo-500/30 transition group">
                                <div class="w-12 h-12 bg-gray-800 rounded-xl flex-shrink-0 flex items-center justify-center border border-white/5 overflow-hidden">
                                    <template x-if="item.image">
                                        <img :src="item.image" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!item.image">
                                        <i class="fa-solid fa-star text-indigo-500"></i>
                                    </template>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-black text-white group-hover:text-indigo-400 transition italic uppercase" x-text="item.title"></h4>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-tight" x-text="item.category"></p>
                                </div>
                                <i class="fa-solid fa-chevron-right text-gray-700 group-hover:text-indigo-500 pr-2 transition"></i>
                            </a>
                        </template>
                    </div>
                </div>

                <div x-show="!isLoading && search.length > 0 && results.length === 0" class="text-center py-12">
                    <div class="w-16 h-16 bg-red-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-red-500/20">
                        <i class="fa-solid fa-face-frown text-red-500 text-2xl"></i>
                    </div>
                    <p class="text-gray-400 font-bold text-xs">Tidak menemukan hasil untuk "<span x-text="search" class="text-white"></span>"</p>
                </div>
            </div>
        </div>
    </div>

    {{-- NAVBAR --}}
    <nav class="sticky top-0 z-50 bg-black/80 backdrop-blur-md border-b border-white/5">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="relative flex h-20 items-center justify-between">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-black tracking-tighter uppercase italic text-indigo-500">
                        WalkAtWall <span class="text-white">Clouds</span>
                    </a>
                    <div class="hidden md:ml-12 md:block">
                        <div class="flex space-x-8">
                            <a href="#home" class="text-sm font-bold text-gray-400 hover:text-indigo-400 transition uppercase tracking-widest">Home</a>
                            <a href="#guest-star" class="text-sm font-bold text-gray-400 hover:text-indigo-400 transition uppercase tracking-widest">Guest Star</a>
                            <a href="#ticket" class="text-sm font-bold text-gray-400 hover:text-indigo-400 transition uppercase tracking-widest">Ticket</a>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-x-6">
                    <button @click="showSearch = true" class="group flex items-center gap-3 bg-white/5 border border-white/10 px-4 py-2 rounded-xl hover:bg-white/10 transition">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 group-hover:text-indigo-500 transition"></i>
                        <span class="text-xs font-bold text-gray-500 hidden sm:block">Search...</span>
                        <span class="hidden lg:block bg-gray-800 px-1.5 py-0.5 rounded text-[10px] text-gray-400 border border-white/5">Ctrl K</span>
                    </button>

                    <div class="flex items-center gap-4">
                        @guest
                            <a href="{{ route('login') }}" class="text-sm font-black uppercase tracking-widest hover:text-indigo-500 transition">Login</a>
                        @else
                            <div class="flex items-center gap-3 bg-white/5 border border-white/10 p-1.5 rounded-2xl">
                                <div class="w-8 h-8 rounded-xl bg-indigo-600 flex items-center justify-center font-black text-xs">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="text-xs font-bold mr-2">{{ auth()->user()->name }}</span>
                            </div>
                        @endguest
                    </div>
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
</body>
</html>