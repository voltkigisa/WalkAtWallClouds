<x-layout title="Manage Artists">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-black italic uppercase tracking-tighter text-white">
                    Manage <span class="text-indigo-500">Artists</span>
                </h2>
                <p class="text-xs text-gray-500 uppercase font-bold tracking-widest">Daftar semua pengisi acara</p>
            </div>
            <a href="{{ route('artists.create') }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl font-black text-xs uppercase tracking-widest transition shadow-lg shadow-indigo-500/20 flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Add Artist
            </a>
        </div>

        <div class="bg-black/20 border border-white/5 rounded-3xl overflow-hidden backdrop-blur-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-white/5 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">
                        <th class="p-5">Artist Info</th>
                        <th class="p-5">Connected Events</th>
                        <th class="p-5">Status</th>
                        <th class="p-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($artists as $artist)
                        <tr class="hover:bg-white/[0.02] transition group">
                            <td class="p-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-gray-800 border border-white/10 overflow-hidden flex-shrink-0">
                                        @if($artist->photo)
                                            <img src="{{ asset('storage/' . $artist->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-indigo-500/10 text-indigo-500">
                                                <i class="fa-solid fa-user-astronaut text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-black text-white uppercase italic group-hover:text-indigo-400 transition">{{ $artist->name }}</h4>
                                        <p class="text-[10px] text-gray-500 font-bold uppercase">{{ $artist->category ?? 'Guest Star' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5">
                                <div class="flex flex-wrap gap-2">
                                    @forelse($artist->events as $event)
                                        <span class="text-[9px] font-black uppercase tracking-tighter bg-indigo-500/10 text-indigo-400 px-2 py-1 rounded-md border border-indigo-500/20">
                                            {{ $event->title }}
                                        </span>
                                    @empty
                                        <span class="text-[10px] text-gray-600 italic uppercase">No events linked</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="p-5">
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-500 text-[10px] font-black uppercase">
                                    <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            </td>
                            <td class="p-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('artists.show', $artist) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-white/10 transition">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('artists.edit', $artist) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 border border-white/10 text-indigo-400 hover:text-white hover:bg-indigo-500 transition">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('artists.destroy', $artist) }}" method="POST" onsubmit="return confirm('Hapus artist ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 border border-white/10 text-red-500 hover:text-white hover:bg-red-500 transition">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-20 text-center">
                                <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/5">
                                    <i class="fa-solid fa-user-slash text-gray-600 text-2xl"></i>
                                </div>
                                <p class="text-gray-500 font-bold uppercase tracking-widest text-xs">Belum ada data artist</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>