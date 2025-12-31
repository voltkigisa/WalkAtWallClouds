<?php $title = 'Artists Filter - WalkAtWallClouds'; ?>
<x-admin-layout :$title>
    <main class="bg-gray-900 min-h-screen text-white py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-10">
                <h1 class="text-4xl font-black uppercase italic tracking-tighter text-white mb-2">Filter Artists</h1>
                <p class="text-gray-500 text-sm font-bold uppercase tracking-widest">Kelola dan filter data artis</p>
            </div>
            
            <!-- Filter Form -->
            <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden mb-10">
                <div class="p-6 border-b border-gray-800">
                    <h2 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400 mb-1">Filter Artists</h2>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Temukan artist yang sesuai dengan kriteria</p>
                </div>
                
                <form method="GET" action="{{ route('filters.artists') }}" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Artist -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Nama Artist:</label>
                            <input type="text" name="name" value="{{ request('name') }}" placeholder="Cari nama artist..." class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Genre -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Genre:</label>
                            <select name="genre" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="">Semua Genre</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                                        {{ $genre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Bio -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Bio:</label>
                            <input type="text" name="bio" value="{{ request('bio') }}" placeholder="Cari dalam bio..." class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Events Minimum -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Jumlah Events Minimum:</label>
                            <input type="number" name="events_min" value="{{ request('events_min') }}" placeholder="0" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Events Maximum -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Jumlah Events Maximum:</label>
                            <input type="number" name="events_max" value="{{ request('events_max') }}" placeholder="100" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Urutkan Berdasarkan -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Urutkan Berdasarkan:</label>
                            <select name="sort_by" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama</option>
                                <option value="genre" {{ request('sort_by') == 'genre' ? 'selected' : '' }}>Genre</option>
                                <option value="events_count" {{ request('sort_by') == 'events_count' ? 'selected' : '' }}>Jumlah Events</option>
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
                        <a href="{{ route('filters.artists') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition flex items-center gap-2">
                            <i class="fa-solid fa-rotate-right"></i> Reset Filter
                        </a>
                    </div>
                </form>
            </div>

            <!-- Results Info -->
            <div class="mb-6">
                <p class="text-gray-400 text-sm font-bold">Menampilkan <span class="text-indigo-400 font-black">{{ $artists->count() }}</span> dari <span class="text-indigo-400 font-black">{{ $artists->total() }}</span> artists</p>
            </div>

            <!-- Artists Table -->
            <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-900/50 text-[10px] text-gray-500 font-black uppercase tracking-widest">
                                <th class="p-5">Artist Details</th>
                                <th class="p-5 text-center">Genre</th>
                                <th class="p-5 text-center">Bio</th>
                                <th class="p-5 text-center">Events</th>
                                <th class="p-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($artists as $artist)
                            <tr class="border-t border-gray-800 hover:bg-indigo-500/5 transition duration-300">
                                <td class="p-5">
                                    <div class="flex items-center gap-4">
                                        @if($artist->photo)
                                            <img src="{{ $artist->photo }}" alt="{{ $artist->name }}" class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center font-black">
                                                {{ strtoupper(substr($artist->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-black text-white uppercase italic">{{ $artist->name }}</p>
                                            <p class="text-xs text-gray-500">ID: {{ $artist->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-center text-xs font-mono">{{ $artist->genre }}</td>
                                <td class="p-5 text-center text-xs text-gray-400">{{ Str::limit($artist->bio, 50) }}</td>
                                <td class="p-5 text-center">
                                    <span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 text-[9px] font-black rounded-full border border-indigo-500/20 uppercase tracking-widest">{{ $artist->events_count }} Events</span>
                                </td>
                                <td class="p-5">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('artists.show', $artist->id) }}" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg text-xs font-black uppercase tracking-widest transition border border-gray-700">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('artists.edit', $artist->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-black uppercase tracking-widest transition">
                                            <i class="fa-solid fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="border-t border-gray-800">
                                <td colspan="5" class="p-12 text-center text-gray-500">
                                    <i class="fa-solid fa-inbox text-5xl mb-4 opacity-20"></i>
                                    <p class="text-sm font-bold uppercase">Tidak ada artist yang sesuai dengan filter Anda.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $artists->appends(request()->query())->links() }}
            </div>
        </div>
    </main>
</x-admin-layout>
