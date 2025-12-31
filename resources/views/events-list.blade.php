<?php $title = 'Events - WalkAtWallClouds'; ?>
<x-layout :$title>
    <main class="container mx-auto px-4 py-10">
        <div class="mb-10">
            <h1 class="text-4xl font-black uppercase italic tracking-tighter text-white mb-2">Daftar Event WalkAtWallClouds</h1>
            <p class="text-gray-500 text-sm font-bold uppercase tracking-widest">Temukan event musik terbaik dan beli tiketnya sekarang!</p>
        </div>
        
        <!-- Filter Form untuk User -->
        <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden mb-10">
            <div class="p-6 border-b border-gray-800">
                <h2 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400 mb-1">Filter Event</h2>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Temukan event yang sesuai dengan preferensi Anda</p>
            </div>
            
            <form method="GET" action="{{ route('events.list') }}" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Lokasi -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Lokasi:</label>
                        <select name="location" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                            <option value="">Semua Lokasi</option>
                            @foreach($locations as $location)
                                <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                    {{ $location }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Tanggal -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Filter Tanggal:</label>
                        <select name="date_filter" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                            <option value="">Semua Tanggal</option>
                            <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="upcoming" {{ request('date_filter') == 'upcoming' ? 'selected' : '' }}>Event Mendatang</option>
                            <option value="past" {{ request('date_filter') == 'past' ? 'selected' : '' }}>Event Lewat</option>
                        </select>
                    </div>

                    <!-- Tanggal Dari -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Tanggal Dari:</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                    </div>

                    <!-- Tanggal Sampai -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Tanggal Sampai:</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
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

                    <!-- Urutkan Berdasarkan -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Urutkan Berdasarkan:</label>
                        <select name="sort_by" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                            <option value="event_date" {{ request('sort_by') == 'event_date' ? 'selected' : '' }}>Tanggal Event</option>
                            <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Nama Event</option>
                            <option value="location" {{ request('sort_by') == 'location' ? 'selected' : '' }}>Lokasi</option>
                        </select>
                    </div>

                    <!-- Urutan -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Urutan:</label>
                        <select name="sort_order" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>A-Z / Terlama</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Z-A / Terbaru</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-indigo-600/20 flex items-center gap-2">
                        <i class="fa-solid fa-filter"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('events.list') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition flex items-center gap-2">
                        <i class="fa-solid fa-rotate-right"></i> Reset Filter
                    </a>
                </div>
            </form>
        </div>

        <!-- Results Info -->
        <div class="mb-6">
            <p class="text-gray-400 text-sm font-bold">Menampilkan <span class="text-indigo-400 font-black">{{ $events->count() }}</span> dari <span class="text-indigo-400 font-black">{{ $events->total() }}</span> event</p>
        </div>

        <!-- Event List Table -->
        <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-900/50 text-[10px] text-gray-500 font-black uppercase tracking-widest">
                            <th class="p-5">Poster</th>
                            <th class="p-5">Event Details</th>
                            <th class="p-5 text-center">Tanggal</th>
                            <th class="p-5 text-center">Lokasi</th>
                            <th class="p-5 text-center">Waktu</th>
                            <th class="p-5 text-center">Harga Tiket</th>
                            <th class="p-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($events as $event)
                        <tr class="border-t border-gray-800 hover:bg-indigo-500/5 transition duration-300">
                            <td class="p-5">
                                @if($event->poster)
                                    <img src="{{ $event->poster }}" alt="{{ $event->title }}" class="w-20 h-24 rounded-lg object-cover shadow-lg">
                                @else
                                    <div class="w-20 h-24 rounded-lg bg-gray-800 flex items-center justify-center">
                                        <i class="fa-solid fa-image text-gray-600 text-2xl"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="p-5">
                                <div>
                                    <p class="font-black text-white uppercase italic mb-1">{{ $event->title }}</p>
                                    <p class="text-xs text-gray-500">{{ Str::limit($event->description, 100) }}</p>
                                </div>
                            </td>
                            <td class="p-5 text-center text-xs font-mono text-gray-400">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                            <td class="p-5 text-center text-xs text-gray-400">{{ $event->location }}</td>
                            <td class="p-5 text-center text-xs font-mono text-gray-400">{{ $event->start_time }} - {{ $event->end_time }}</td>
                            <td class="p-5 text-center">
                                @php
                                    $minPrice = $event->ticketTypes->min('price');
                                    $maxPrice = $event->ticketTypes->max('price');
                                @endphp
                                @if($minPrice)
                                    <div class="text-xs font-bold text-indigo-300">
                                        Rp {{ number_format($minPrice, 0, ',', '.') }}
                                        @if($minPrice != $maxPrice)
                                            <br><span class="text-gray-500">- Rp {{ number_format($maxPrice, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-gray-500">Belum Ada Tiket</span>
                                @endif
                            </td>
                            <td class="p-5">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('events.show', $event->id) }}" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg text-xs font-black uppercase tracking-widest transition border border-gray-700">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </a>
                                    @if($event->ticketTypes->count() > 0)
                                        <a href="{{ route('purchase.index') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-black uppercase tracking-widest transition shadow-lg shadow-indigo-600/20">
                                            <i class="fa-solid fa-ticket"></i> Beli
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="border-t border-gray-800">
                            <td colspan="7" class="p-12 text-center text-gray-500">
                                <i class="fa-solid fa-inbox text-5xl mb-4 opacity-20"></i>
                                <p class="text-sm font-bold uppercase">Tidak ada event yang sesuai dengan filter Anda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $events->appends(request()->query())->links() }}
        </div>
    </main>
</x-layout>
