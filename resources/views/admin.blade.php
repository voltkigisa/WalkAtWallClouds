<?php $title = 'Admin Dashboard'; ?>
<x-admin-layout :$title>
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="flex min-h-screen bg-gray-900 text-white font-sans">
        
        <aside class="w-64 bg-black border-r border-gray-800 hidden md:block fixed h-full z-50">
            <div class="p-6">
                <h1 class="text-xl font-black text-indigo-500 tracking-tighter uppercase italic">
                    WalkAtWall <span class="text-white">Clouds</span>
                </h1>
            </div>
            
            <nav class="mt-4 px-4 space-y-1">
                <p class="text-[10px] font-bold text-gray-500 uppercase px-4 mb-2 tracking-widest">Main Menu</p>
                <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 bg-indigo-600 rounded-xl text-sm font-bold transition shadow-lg shadow-indigo-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('artists.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-xl text-sm font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/></svg>
                    Manage Artists
                </a>
                <a href="{{ route('ticket-types.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-xl text-sm font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    Ticket Types
                </a>
                <a href="{{ route('order-items.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-xl text-sm font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Order Items
                </a>

                <div class="pt-10">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-500/10 rounded-xl text-sm font-bold transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <div class="flex-1 md:ml-64 flex flex-col min-h-screen">
            
            <header class="h-20 bg-black/50 backdrop-blur-md border-b border-gray-800 px-8 flex items-center justify-between sticky top-0 z-40">
                <div>
                    <h2 class="text-xl font-black uppercase tracking-widest italic">Admin <span class="text-indigo-500">Dashboard</span></h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-white uppercase">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-widest">Administrator</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center font-black shadow-lg shadow-indigo-500/40">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <main class="p-8">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                    <div class="bg-black p-6 rounded-3xl border border-gray-800 shadow-xl relative overflow-hidden group">
                        <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500/10 rounded-full group-hover:scale-150 transition duration-500"></div>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Total Sales</p>
                        <h3 class="text-3xl font-black italic">Rp 1.2M</h3>
                    </div>
                    <div class="bg-black p-6 rounded-3xl border border-gray-800 shadow-xl relative overflow-hidden group">
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Tickets Sold</p>
                        <h3 class="text-3xl font-black italic">4,520</h3>
                    </div>
                    <div class="bg-black p-6 rounded-3xl border border-gray-800 shadow-xl relative overflow-hidden group">
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Events</p>
                        <h3 class="text-3xl font-black italic">08</h3>
                    </div>
                    <div class="bg-black p-6 rounded-3xl border border-gray-800 shadow-xl relative overflow-hidden group">
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Active Artists</p>
                        <h3 class="text-3xl font-black italic">15</h3>
                    </div>
                </div>

                <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden">
                    <div class="p-6 border-b border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div>
                            <h3 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400">Manage Events</h3>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Update or add new festival events</p>
                        </div>
                        <a href="{{ route('events.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-indigo-600/20">
                            + Add Event
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-900/50 text-[10px] text-gray-500 font-black uppercase tracking-widest">
                                    <th class="p-5">Event Details</th>
                                    <th class="p-5 text-center">Date</th>
                                    <th class="p-5 text-center">Status</th>
                                    <th class="p-5 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($events as $event)
                                <tr class="border-t border-gray-800 hover:bg-indigo-500/5 transition duration-300">
                                    <td class="p-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-lg bg-gray-800 flex-shrink-0"></div>
                                            <div>
                                                <p class="font-black text-white uppercase italic">{{ $event->title }}</p>
                                                <p class="text-[10px] text-gray-500 font-bold uppercase">{{ $event->location }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-5 text-center text-xs font-mono">{{ $event->event_date }}</td>
                                    <td class="p-5 text-center">
                                        <span class="px-3 py-1 bg-green-500/10 text-green-500 text-[9px] font-black rounded-full border border-green-500/20 uppercase tracking-widest">{{ $event->status }}</span>
                                    </td>
                                    <td class="p-5">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('events.edit', $event->id) }}" class="p-2 text-blue-400 hover:bg-blue-400/10 rounded-lg transition border border-blue-400/20">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </a>
                                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin ingin menghapus event ini?')" class="p-2 text-red-500 hover:bg-red-500/10 rounded-lg transition border border-red-500/20">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="border-t border-gray-800">
                                    <td colspan="4" class="p-5 text-center text-gray-500">Belum ada event</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    </x-admin-layout>