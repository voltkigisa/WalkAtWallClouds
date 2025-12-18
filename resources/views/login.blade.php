<?php $title = 'Login'; ?>
<x-layout :$title>
    <script src="https://cdn.tailwindcss.com"></script>
    <header>
        <nav class="relative bg-black after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="relative flex h-20 items-center justify-between">
                    
                    <div class="flex items-center">
                        <div class="flex shrink-0 items-center">
                            <a href="#" class="text-xl font-extrabold tracking-wider uppercase text-indigo-400 drop-shadow-sm">
                                WalkAtWallClouds
                            </a>
                        </div>
                        
                        <div class="hidden sm:ml-12 sm:block">
                            <div class="flex space-x-8">
                                <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white transition">Home</a>
                                <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white transition">Ticket</a>
                                <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white transition">Guest Star</a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-x-8">
                        <a href="#" class="rounded-md bg-white/10 px-4 py-2 text-sm font-medium text-white hover:bg-white/20 transition">
                            Login
                        </a>

                        <button type="button" class="relative rounded-full p-1 text-gray-400 hover:text-white focus:outline-none transition">
                            <span class="sr-only">View cart</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-indigo-500 text-[10px] font-bold text-white">
                                0
                            </span>
                        </button>

                        <button type="button" class="relative rounded-full p-1 text-gray-400 hover:text-white focus:outline-none transition">
                            <span class="sr-only">View notifications</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6">
                                <path d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <body class="bg-gray-900 min-h-screen">
        <div class="text-white max-w-md mx-auto mt-20 bg-black p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6 text-center text-white">Login</h2> 

            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-500/20 border border-red-500 text-red-100 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="Account" class="block text-white font-semibold mb-2">Account</label> 
                    <input type="text" id="Account" name="email" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black"
                        placeholder="Enter your email or account">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-white font-semibold mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500 text-black"
                        placeholder="Enter your password">
                </div>

                <button type="submit" id="loginBtn"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Login
                </button>
            </form>

            <p class="text-center mt-4 text-gray-30