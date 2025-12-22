@props(['title' => null])
<!doctype html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'WalkAtWallClouds' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    

    @stack('styles')

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
                    <button type="button" class="relative rounded-full p-1 text-gray-400 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-indigo-500 text-[10px] font-bold text-white">0</span>
                    </button>

                    <a href="{{ route('login') }}" class="hidden sm:block rounded-md bg-indigo-600 px-5 py-2 text-sm font-bold text-white hover:bg-indigo-700 transition">
                        Login
                    </a>

                    <button id="menu-btn" class="md:hidden text-gray-400 hover:text-white focus:outline-none">
                        <svg id="menu-icon" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div> 
            </div>
        </div>
    </nav>
</head>
<body class="bg-gray-900 min-h-screen text-gray-100 flex flex-col">

    <main class="flex-grow">
        {{ $slot }}
    </main>
    @stack('scripts')

    <footer class="bg-black py-10 border-t border-white/5 text-center">
        <p class="text-gray-500 text-sm">&copy; 2025 WalkAtWallClouds. All rights reserved.</p>
    </footer>

     <script src="{{ asset('js/navbar.js') }}"></script>
</body>
</html>