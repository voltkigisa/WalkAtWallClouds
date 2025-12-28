<x-layout title="Daftar Event - WalkAtWallClouds">
    <main class="bg-gray-900 min-h-screen text-white py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h1 class="text-3xl font-black uppercase tracking-tighter italic">Manage <span class="text-indigo-500">Events</span></h1>
                    <div class="h-1 w-20 bg-indigo-500 mt-2"></div>
                </div>
                <a href="{{ route('events.create') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-xl font-bold transition flex items-center gap-2 uppercase tracking-widest text-xs">
                    + Tambah Event Baru
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 text-green-400 rounded-xl text-sm font-bold uppercase italic">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-black/40 border border-white/10 rounded-3xl overflow-hidden shadow-2xl backdrop-blur-md">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/5 text-indigo-400 uppercase text-[10px] font-black tracking-widest">
                            <th class="p-5">ID</th>
                            <th class="p-5">Title</th>
                            <th class="p-5">Location</th>
                            <th class="p-5">Date & Time</th>
                            <th class="p-5">Status</th>
                            <th class="p-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($events as $event)
                            <tr class="hover:bg-white/[0.02] transition">
                                <td class="p-5 text-gray-500 font-mono text-xs">{{ $event->id }}</td>
                                <td class="p-5 font-bold uppercase italic tracking-tighter text-indigo-500">{{ $event->title }}</td>
                                <td class="p-5 text-sm font-medium">{{ $event->location }}</td>
                                <td class="p-5">
                                    <div class="text-sm font-bold">{{ $event->event_date }}</div>
                                    <div class="text-[10px] text-gray-500 uppercase">{{ $event->start_time }}</div>
                                </td>
                                <td class="p-5">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border 
                                        {{ $event->status == 'active' ? 'bg-green-500/10 border-green-500 text-green-500' : 'bg-gray-500/10 border-gray-500 text-gray-400' }}">
                                        {{ $event->status }}
                                    </span>
                                </td>
                                <td class="p-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('events.show', $event->id) }}" class="p-2 bg-white/5 rounded-lg text-gray-400 hover:bg-indigo-600 hover:text-white transition">View</a>
                                        <a href="{{ route('events.edit', $event->id) }}" class="p-2 bg-white/5 rounded-lg text-indigo-400 hover:bg-indigo-600 hover:text-white transition">Edit</a>
                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin ingin menghapus event ini?')" class="p-2 bg-white/5 rounded-lg text-red-500 hover:bg-red-600 hover:text-white transition">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-20 text-center text-gray-600 uppercase font-black text-xs tracking-widest">Tidak ada data event</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-8">
                <a href="/admin/dashboard" class="text-gray-500 hover:text-white text-xs font-bold uppercase tracking-widest transition">← Kembali ke Dashboard</a>
            </div>
        </div>
    </main>
</x-layout>