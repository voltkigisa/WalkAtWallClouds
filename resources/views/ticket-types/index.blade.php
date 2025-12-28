<x-admin-layout title="Daftar Ticket Type - WalkAtWallClouds">
    <main class="fixed inset-0 bg-gray-900 flex items-center justify-center overflow-hidden ml-64 text-white">
        <div class="max-w-6xl w-full px-8">
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h1 class="text-3xl font-black uppercase tracking-tighter italic">Manage <span class="text-indigo-500">Tickets</span></h1>
                    <p class="text-gray-500 text-[10px] uppercase tracking-[0.2em] font-bold">Inventory & Pricing Control</p>
                </div>
                <a href="{{ route('ticket-types.create') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-xl text-[10px] font-black uppercase tracking-widest transition shadow-lg shadow-indigo-500/20">
                    + New Ticket Type
                </a>
            </div>

            <div class="bg-black/40 border border-white/10 rounded-[2.5rem] overflow-hidden backdrop-blur-md shadow-2xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/5 border-b border-white/10 text-[10px] font-black uppercase tracking-widest text-indigo-400">
                            <th class="p-5">Event</th>
                            <th class="p-5">Ticket Name</th>
                            <th class="p-5">Price</th>
                            <th class="p-5 text-center">Quota</th>
                            <th class="p-5 text-center">Sold</th>
                            <th class="p-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($ticketTypes as $ticketType)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="p-5 font-bold text-sm">{{ $ticketType->event->title ?? '-' }}</td>
                            <td class="p-5 text-sm uppercase tracking-tighter font-black italic">{{ $ticketType->name }}</td>
                            <td class="p-5 text-sm font-medium text-indigo-300">Rp {{ number_format($ticketType->price, 0, ',', '.') }}</td>
                            <td class="p-5 text-center text-sm font-bold">{{ $ticketType->quota }}</td>
                            <td class="p-5 text-center text-sm font-bold text-red-400">{{ $ticketType->sold }}</td>
                            <td class="p-5 text-right space-x-2">
                                <a href="{{ route('ticket-types.show', $ticketType->id) }}" class="text-[10px] font-black uppercase text-gray-400 hover:text-white transition">View</a>
                                <a href="{{ route('ticket-types.edit', $ticketType->id) }}" class="text-[10px] font-black uppercase text-indigo-400 hover:text-indigo-300 transition">Edit</a>
                                <form action="{{ route('ticket-types.destroy', $ticketType->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus?')" class="text-[10px] font-black uppercase text-red-500/50 hover:text-red-500 transition">Del</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-500 uppercase font-bold text-xs italic tracking-widest">No ticket data found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</x-admin-layout>