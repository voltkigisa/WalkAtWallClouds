<?php $title = 'Register'; ?>
<x-layout :$title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />

    <header>
        <nav class="relative bg-black after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="relative flex h-20 items-center justify-between">
                    
                    <div class="flex items-center">
                        <div class="flex shrink-0 items-center">
                            <a href="/" class="text-xl font-extrabold tracking-wider uppercase text-indigo-400 drop-shadow-sm">
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
                        <a href="{{ route('login') }}" class="rounded-md bg-white/10 px-4 py-2 text-sm font-medium text-white hover:bg-white/20 transition">
                            Login
                        </a>
                        <button type="button" class="relative rounded-full p-1 text-gray-400 hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-indigo-500 text-[10px] font-bold text-white">0</span>
                        </button>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="bg-gray-900 min-h-screen flex flex-col justify-center py-12 px-6">
        <div class="text-white max-w-md mx-auto w-full bg-black p-8 rounded-lg shadow-xl border border-gray-800">
            <h2 class="text-3xl font-bold mb-2 text-center text-white">Create Account</h2> 
            <p class="text-gray-400 text-center mb-8 text-sm">Join WalkAtWallClouds today</p>

            @if ($errors->any())
                <div id="alert-2" class="flex items-center p-4 mb-6 text-red-400 rounded-lg bg-red-900/20 border border-red-800" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ms-3 text-sm font-medium">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-red-400 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-800/30 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-2" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label for="name" class="block mb-2 text-sm font-semibold text-white">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 placeholder-gray-500" 
                        placeholder="Your Name" required>
                </div>

                <div>
                    <label for="email" class="block mb-2 text-sm font-semibold text-white">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 placeholder-gray-500" 
                        placeholder="name@company.com" required>
                </div>

                <div>
                    <label for="password" class="block mb-2 text-sm font-semibold text-white">Password</label>
                    <input type="password" name="password" id="password" 
                        class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 placeholder-gray-500" 
                        placeholder="••••••••" required>
                </div>

                <div>
                    <label for="password_confirmation" class="block mb-2 text-sm font-semibold text-white">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                        class="bg-gray-900 border border-gray-700 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 placeholder-gray-500" 
                        placeholder="••••••••" required>
                </div>

                <button type="submit" 
                    class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-800 font-bold rounded-lg text-sm px-5 py-3 text-center transition duration-200">
                    Create Account
                </button>

                <p class="text-sm font-light text-gray-400 text-center">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-medium text-indigo-400 hover:underline">Login here</a>
                </p>
            </form>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</x-layout>