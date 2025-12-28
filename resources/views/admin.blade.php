<x-admin-layout>
    <x-slot:title>Admin Dashboard</x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-black p-6 rounded-3xl border border-gray-800 shadow-xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500/10 rounded-full group-hover:scale-150 transition duration-500"></div>
            <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Total Orders</p>
            <h3 class="text-3xl font-black italic">{{ $totalOrders ?? 0 }}</h3>
        </div>
        <div class="bg-black p-6 rounded-3xl border border-gray-800 shadow-xl relative overflow-hidden group">
            <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Tickets Sold</p>
            <h3 class="text-3xl font-black italic">{{ $totalTickets ?? 0 }}</h3>
        </div>
        <div class="bg-black p-6 rounded-3xl border border-gray-800 shadow-xl relative overflow-hidden group">
            <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Events</p>
            <h3 class="text-3xl font-black italic">{{ $totalEvents ?? 0 }}</h3>
        </div>
        <div class="bg-black p-6 rounded-3xl border border-gray-800 shadow-xl relative overflow-hidden group">
            <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Active Artists</p>
            <h3 class="text-3xl font-black italic">{{ $totalArtists ?? 0 }}</h3>
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
                                <div class="w-10 h-10 rounded-lg bg-gray-800 flex-shrink-0 flex items-center justify-center">
                                    <i class="fa-solid fa-calendar text-indigo-400"></i>
                                </div>
                                <div>
                                    <p class="font-black text-white uppercase italic">{{ $event->title }}</p>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase">{{ $event->location }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-5 text-center text-xs font-mono">{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}</td>
                        <td class="p-5 text-center">
                            @if($event->status === 'published')
                                <span class="px-3 py-1 bg-green-500/10 text-green-500 text-[9px] font-black rounded-full border border-green-500/20 uppercase tracking-widest">Published</span>
                            @elseif($event->status === 'cancelled')
                                <span class="px-3 py-1 bg-red-500/10 text-red-500 text-[9px] font-black rounded-full border border-red-500/20 uppercase tracking-widest">Cancelled</span>
                            @else
                                <span class="px-3 py-1 bg-gray-500/10 text-gray-500 text-[9px] font-black rounded-full border border-gray-500/20 uppercase tracking-widest">{{ $event->status }}</span>
                            @endif
                        </td>
                        <td class="p-5">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('events.edit', $event->id) }}" class="p-2 text-blue-400 hover:bg-blue-400/10 rounded-lg transition border border-blue-400/20">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-500/10 rounded-lg transition border border-red-500/20">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="border-t border-gray-800">
                        <td colspan="4" class="p-8 text-center text-gray-500">
                            <i class="fa-solid fa-inbox text-4xl mb-3 opacity-20"></i>
                            <p class="text-xs font-bold uppercase">Belum ada event</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden mt-10">
        <div class="p-6 border-b border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400">Manage Artists</h3>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Update or add new artists</p>
            </div>
            <a href="{{ route('artists.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-indigo-600/20">
                + Add Artist
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-[10px] text-gray-500 font-black uppercase tracking-widest">
                        <th class="p-5">Artist Details</th>
                        <th class="p-5 text-center">Genre</th>
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
                                <img src="{{ asset('storage/' . $artist->photo) }}" alt="{{ $artist->name }}" class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                                @else
                                <div class="w-10 h-10 rounded-lg bg-gray-800 flex-shrink-0 flex items-center justify-center">
                                    <i class="fa-solid fa-user text-indigo-400"></i>
                                </div>
                                @endif
                                <div>
                                    <p class="font-black text-white uppercase italic">{{ $artist->name }}</p>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase">{{ Str::limit($artist->bio, 50) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-5 text-center text-xs font-mono">{{ $artist->genre }}</td>
                        <td class="p-5 text-center">
                            <span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 text-[9px] font-black rounded-full border border-indigo-500/20 uppercase tracking-widest">{{ $artist->events_count }} Events</span>
                        </td>
                        <td class="p-5">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('artists.edit', $artist->id) }}" class="p-2 text-blue-400 hover:bg-blue-400/10 rounded-lg transition border border-blue-400/20">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('artists.destroy', $artist->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus artist ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-500/10 rounded-lg transition border border-red-500/20">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="border-t border-gray-800">
                        <td colspan="4" class="p-8 text-center text-gray-500">
                            <i class="fa-solid fa-inbox text-4xl mb-3 opacity-20"></i>
                            <p class="text-xs font-bold uppercase">Belum ada artist</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>