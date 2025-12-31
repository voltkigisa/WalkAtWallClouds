<x-admin-layout>
    <x-slot:title>Admin Dashboard</x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
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
        <div class="bg-gradient-to-br from-indigo-600/20 to-purple-600/20 p-6 rounded-3xl border border-indigo-500/30 shadow-xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500/20 rounded-full group-hover:scale-150 transition duration-500"></div>
            <p class="text-indigo-300 text-[10px] font-black uppercase tracking-widest mb-1">Ticket Types</p>
            <h3 class="text-3xl font-black italic text-white">{{ $totalTicketTypes ?? 0 }}</h3>
        </div>
        <div class="bg-gradient-to-br from-green-600/20 to-emerald-600/20 p-6 rounded-3xl border border-green-500/30 shadow-xl relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-green-500/20 rounded-full group-hover:scale-150 transition duration-500"></div>
            <p class="text-green-300 text-[10px] font-black uppercase tracking-widest mb-1">Total Users</p>
            <h3 class="text-3xl font-black italic text-white">{{ $totalUsers ?? 0 }}</h3>
        </div>
    </div>

    <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden mb-10">
    <div class="p-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h3 class="text-lg font-black uppercase tracking-tighter text-red-500">Laporan Ringkasan</h3>
            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Cetak semua data ringkasan dashboard ke dalam format PDF</p>
        </div>
        <div>
            <a href="{{ route('downloadpdf') }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-red-600/20 flex items-center gap-2">
                <i class="fa-solid fa-file-pdf"></i> Download PDF
            </a>
        </div>
    </div>
</div>

<div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden">
    </div>

    <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden">
        <div class="p-6 border-b border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400">Manage Events</h3>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Update or add new festival events</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('events.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition">
                    View More
                </a>
                <a href="{{ route('events.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-indigo-600/20">
                    + Add Event
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="p-6 border-b border-gray-800">
            <form method="GET" action="{{ route('admin') }}">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Filter Status -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Filter Status:</label>
                        <select name="status" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <!-- Filter Tanggal Event -->
                    <div>
                        <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Filter Tanggal Event:</label>
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
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-indigo-600/20 flex items-center gap-2">
                        <i class="fa-solid fa-filter"></i> Terapkan Filter
                    </button>
                    <a href="{{ route('admin') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition flex items-center gap-2">
                        <i class="fa-solid fa-rotate-right"></i> Reset Filter
                    </a>
                </div>
            </form>
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
            <div class="flex gap-2">
                <a href="{{ route('artists.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition">
                    View More
                </a>
                <a href="{{ route('artists.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-indigo-600/20">
                    + Add Artist
                </a>
            </div>
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

    <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden mt-10">
        <div class="p-6 border-b border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400">Manage Ticket Types</h3>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Update or add new ticket categories</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('ticket-types.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition">
                    View More
                </a>
                <a href="{{ route('ticket-types.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-indigo-600/20">
                    + Add Ticket Type
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-[10px] text-gray-500 font-black uppercase tracking-widest">
                        <th class="p-5">Ticket Details</th>
                        <th class="p-5 text-center">Event</th>
                        <th class="p-5 text-center">Price</th>
                        <th class="p-5 text-center">Quota</th>
                        <th class="p-5 text-center">Sold</th>
                        <th class="p-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($ticketTypes as $ticketType)
                    <tr class="border-t border-gray-800 hover:bg-indigo-500/5 transition duration-300">
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-gray-800 flex-shrink-0 flex items-center justify-center">
                                    <i class="fa-solid fa-ticket text-indigo-400"></i>
                                </div>
                                <div>
                                    <p class="font-black text-white uppercase italic">{{ $ticketType->name }}</p>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase">{{ $ticketType->quota - $ticketType->sold }} Available</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-5 text-center text-xs">{{ $ticketType->event->title ?? '-' }}</td>
                        <td class="p-5 text-center text-xs font-bold text-indigo-300">Rp {{ number_format($ticketType->price, 0, ',', '.') }}</td>
                        <td class="p-5 text-center text-xs font-mono">{{ $ticketType->quota }}</td>
                        <td class="p-5 text-center">
                            <span class="px-3 py-1 bg-red-500/10 text-red-400 text-[9px] font-black rounded-full border border-red-500/20 uppercase tracking-widest">{{ $ticketType->sold }} Sold</span>
                        </td>
                        <td class="p-5">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('ticket-types.show', $ticketType->id) }}" class="p-2 text-gray-400 hover:bg-gray-400/10 rounded-lg transition border border-gray-400/20">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('ticket-types.edit', $ticketType->id) }}" class="p-2 text-blue-400 hover:bg-blue-400/10 rounded-lg transition border border-blue-400/20">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('ticket-types.destroy', $ticketType->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus ticket type ini?')">
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
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            <i class="fa-solid fa-inbox text-4xl mb-3 opacity-20"></i>
                            <p class="text-xs font-bold uppercase">Belum ada ticket type</p>
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
                <h3 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400">Manage Users</h3>
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">View and manage all users</p>
            </div>
            <div class="flex gap-2">

                <a href="{{ route('users.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition">
                    View More
                </a>
                <a href="{{ route('users.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-indigo-600/20">
                    + Add User
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900/50 text-[10px] text-gray-500 font-black uppercase tracking-widest">
                        <th class="p-5">User Details</th>
                        <th class="p-5 text-center">Email</th>
                        <th class="p-5 text-center">Role</th>
                        <th class="p-5 text-center">Orders</th>
                        <th class="p-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($users as $user)
                    <tr class="border-t border-gray-800 hover:bg-indigo-500/5 transition duration-300">
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-indigo-600 flex-shrink-0 flex items-center justify-center font-black text-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-black text-white uppercase italic">{{ $user->name }}</p>
                                    @if($user->name === 'Admin Walk At Wall Clouds')
                                        <span class="text-[8px] font-black px-2 py-0.5 bg-yellow-500/20 text-yellow-400 rounded border border-yellow-500/30 uppercase">Protected</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-5 text-center text-xs text-gray-400">{{ $user->email }}</td>
                        <td class="p-5 text-center">
                            @if($user->role === 'admin')
                                <span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 text-[9px] font-black rounded-full border border-indigo-500/20 uppercase tracking-widest">Admin</span>
                            @else
                                <span class="px-3 py-1 bg-gray-500/10 text-gray-400 text-[9px] font-black rounded-full border border-gray-500/20 uppercase tracking-widest">User</span>
                            @endif
                        </td>
                        <td class="p-5 text-center text-xs font-mono">{{ $user->orders_count }}</td>
                        <td class="p-5">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('users.show', $user->id) }}" class="p-2 text-gray-400 hover:bg-gray-400/10 rounded-lg transition border border-gray-400/20">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                @if($user->name !== 'Admin Walk At Wall Clouds' && $user->role === 'admin')
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:bg-red-500/10 rounded-lg transition border border-red-500/20">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="border-t border-gray-800">
                        <td colspan="5" class="p-8 text-center text-gray-500">
                            <i class="fa-solid fa-inbox text-4xl mb-3 opacity-20"></i>
                            <p class="text-xs font-bold uppercase">Belum ada user</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>