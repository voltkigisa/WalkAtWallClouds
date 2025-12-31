<?php $title = 'Ticket Types Filter - WalkAtWallClouds'; ?>
<x-admin-layout :$title>
    <main class="bg-gray-900 min-h-screen text-white py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-10">
                <h1 class="text-4xl font-black uppercase italic tracking-tighter text-white mb-2">Filter Ticket Types</h1>
                <p class="text-gray-500 text-sm font-bold uppercase tracking-widest">Kelola dan filter data tipe tiket</p>
            </div>
            
            <!-- Filter Form -->
            <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden mb-10">
                <div class="p-6 border-b border-gray-800">
                    <h2 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400 mb-1">Filter Ticket Types</h2>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Temukan tipe tiket yang sesuai dengan kriteria</p>
                </div>
                
                <form method="GET" action="{{ route('filters.ticket-types') }}" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Ticket Type -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Nama Ticket Type:</label>
                            <input type="text" name="name" value="{{ request('name') }}" placeholder="Cari nama ticket type..." class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Event -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Event:</label>
                            <select name="event_id" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="">Semua Event</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                        {{ $event->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Harga Minimum -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Harga Minimum:</label>
                            <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Rp 0" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Harga Maximum -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Harga Maximum:</label>
                            <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Rp 1000000" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Quota Minimum -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Quota Minimum:</label>
                            <input type="number" name="quota_min" value="{{ request('quota_min') }}" placeholder="0" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Quota Maximum -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Quota Maximum:</label>
                            <input type="number" name="quota_max" value="{{ request('quota_max') }}" placeholder="1000" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Availability -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Ketersediaan:</label>
                            <select name="availability" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="">Semua</option>
                                <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="sold_out" {{ request('availability') == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                            </select>
                        </div>

                        <!-- Urutkan Berdasarkan -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Urutkan Berdasarkan:</label>
                            <select name="sort_by" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama</option>
                                <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Harga</option>
                                <option value="quota" {{ request('sort_by') == 'quota' ? 'selected' : '' }}>Quota</option>
                                <option value="sold" {{ request('sort_by') == 'sold' ? 'selected' : '' }}>Sold</option>
                            </select>
                        </div>

                        <!-- Urutan -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Urutan:</label>
                            <select name="sort_order" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>A-Z / Terendah</option>
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Z-A / Tertinggi</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 mt-6">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-indigo-600/20 flex items-center gap-2">
                            <i class="fa-solid fa-filter"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('filters.ticket-types') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition flex items-center gap-2">
                            <i class="fa-solid fa-rotate-right"></i> Reset Filter
                        </a>
                    </div>
                </form>
            </div>

            <!-- Results Info -->
            <div class="mb-6">
                <p class="text-gray-400 text-sm font-bold">Menampilkan <span class="text-indigo-400 font-black">{{ $ticketTypes->count() }}</span> dari <span class="text-indigo-400 font-black">{{ $ticketTypes->total() }}</span> ticket types</p>
            </div>

            <!-- Ticket Types Table -->
            <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-900/50 text-[10px] text-gray-500 font-black uppercase tracking-widest">
                                <th class="p-5">Ticket Details</th>
                                <th class="p-5 text-center">Event</th>
                                <th class="p-5 text-center">Price</th>
                                <th class="p-5 text-center">Quota</th>
                                <th class="p-5 text-center">Sold</th>
                                <th class="p-5 text-center">Available</th>
                                <th class="p-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($ticketTypes as $ticketType)
                            <tr class="border-t border-gray-800 hover:bg-indigo-500/5 transition duration-300">
                                <td class="p-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg bg-indigo-600/20 flex items-center justify-center">
                                            <i class="fa-solid fa-ticket text-indigo-400"></i>
                                        </div>
                                        <div>
                                            <p class="font-black text-white uppercase italic">{{ $ticketType->name }}</p>
                                            <p class="text-xs text-gray-500">{{ Str::limit($ticketType->description, 50) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-center text-xs">{{ $ticketType->event->title ?? '-' }}</td>
                                <td class="p-5 text-center text-xs font-bold text-indigo-300">Rp {{ number_format($ticketType->price, 0, ',', '.') }}</td>
                                <td class="p-5 text-center text-xs font-mono">{{ $ticketType->quota }}</td>
                                <td class="p-5 text-center">
                                    <span class="px-3 py-1 bg-red-500/10 text-red-400 text-[9px] font-black rounded-full border border-red-500/20 uppercase tracking-widest">{{ $ticketType->sold }}</span>
                                </td>
                                <td class="p-5 text-center">
                                    @if($ticketType->sold < $ticketType->quota)
                                        <span class="px-3 py-1 bg-green-500/10 text-green-400 text-[9px] font-black rounded-full border border-green-500/20 uppercase tracking-widest">{{ $ticketType->quota - $ticketType->sold }}</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-500/10 text-gray-400 text-[9px] font-black rounded-full border border-gray-500/20 uppercase tracking-widest">SOLD OUT</span>
                                    @endif
                                </td>
                                <td class="p-5">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('ticket-types.show', $ticketType->id) }}" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg text-xs font-black uppercase tracking-widest transition border border-gray-700">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('ticket-types.edit', $ticketType->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-black uppercase tracking-widest transition">
                                            <i class="fa-solid fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="border-t border-gray-800">
                                <td colspan="7" class="p-12 text-center text-gray-500">
                                    <i class="fa-solid fa-inbox text-5xl mb-4 opacity-20"></i>
                                    <p class="text-sm font-bold uppercase">Tidak ada ticket type yang sesuai dengan filter Anda.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $ticketTypes->appends(request()->query())->links() }}
            </div>
        </div>
    </main>
</x-admin-layout>
