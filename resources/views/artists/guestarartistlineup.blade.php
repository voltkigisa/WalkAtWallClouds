<?php $title = 'Artist - ' . $artist->name; ?>
<x-layout :$title>
    <script src="https://cdn.tailwindcss.com"></script>

    <main class="bg-black min-h-screen text-white">
        <section class="relative h-[60vh] flex items-end overflow-hidden">
            <div class="absolute inset-0">
                <img src="{{ asset('storage/'.$artist->photo) }}" alt="{{ $artist->name }}" 
                     class="w-full h-full object-cover scale-105 blur-sm opacity-40">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-6 pb-12 w-full">
                <span class="inline-block px-3 py-1 text-xs font-semibold tracking-wider text-indigo-400 uppercase bg-indigo-400/10 rounded-full mb-4">
                    {{ $artist->genre }}
                </span>
                <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tighter mb-4">
                    {{ $artist->name }}
                </h1>
                
                <div class="flex flex-wrap gap-4 text-sm font-bold uppercase tracking-widest">
                    <div class="border border-white/20 px-4 py-2 rounded-md bg-white/5">
                        <span class="text-gray-400 mr-2">Status:</span> Confirmed
                    </div>
                    <div class="border border-white/20 px-4 py-2 rounded-md bg-white/5 text-indigo-400">
                        Lineup Artist
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <div class="lg:col-span-2 space-y-8">
                    <div>
                        <h2 class="text-2xl font-black uppercase border-b border-indigo-500/50 pb-2 mb-6 inline-block">
                            About Artist
                        </h2>
                        <div class="text-gray-300 leading-relaxed text-lg space-y-4">
                            <p>
                                {{ $artist->description ?? "{$artist->name} siap memberikan penampilan yang tak terlupakan di WalkAtWallClouds. Dikenal dengan aliran {$artist->genre}, sang artis telah memikat ribuan telinga dengan harmoni yang unik." }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-zinc-900 border border-white/5 p-8 rounded-3xl flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl">
                        <div>
                            <h3 class="text-xl font-bold">Siap menyaksikan {{ $artist->name }}?</h3>
                            <p class="text-gray-400 text-sm">Amankan tiketmu sekarang sebelum kehabisan!</p>
                        </div>
                        <a href="{{ route('purchase.index') }}" class="px-10 py-4 bg-white text-black font-black uppercase tracking-widest rounded-full hover:bg-indigo-500 hover:text-white transition duration-300">
                            Buy Tickets Now
                        </a>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-zinc-900 border border-white/5 rounded-2xl overflow-hidden shadow-xl">
                        <img src="{{ asset('storage/'.$artist->photo) }}" class="w-full aspect-square object-cover" alt="{{ $artist->name }}">
                        <div class="p-6">
                            <h4 class="text-xs text-indigo-400 font-bold uppercase tracking-widest mb-1">Official Lineup</h4>
                            <p class="text-lg font-bold">{{ $artist->name }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="p-4 bg-white/5 border border-white/10 rounded-xl">
                            <p class="text-[10px] text-gray-500 font-bold uppercase">Genre</p>
                            <p class="font-bold text-white">{{ $artist->genre }}</p>
                        </div>
                        <div class="p-4 bg-white/5 border border-white/10 rounded-xl">
                            <p class="text-[10px] text-gray-500 font-bold uppercase">Event Stage</p>
                            <p class="font-bold text-white uppercase">Cloud Stage</p>
                        </div>
                    </div>
                    
                    <a href="{{ url()->previous() }}" class="flex items-center justify-center gap-2 text-gray-500 hover:text-white transition py-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span class="text-xs font-bold uppercase tracking-widest">Back to Home</span>
                    </a>
                </div>

            </div>
        </section>
    </main>
</x-layout>