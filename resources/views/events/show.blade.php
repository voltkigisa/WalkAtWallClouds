<x-layout title="Detail Event - WalkAtWallClouds">
    <main class="bg-gray-900 min-h-screen text-white py-12 flex justify-center">
        <div class="max-w-4xl w-full px-6">
            <div class="flex justify-between items-center mb-10">
                <a href="{{ route('events.index') }}" class="text-gray-500 hover:text-white font-black uppercase text-[10px] tracking-[0.2em] transition">← Kembali ke Daftar</a>
                <div class="flex gap-4">
                    <a href="{{ route('events.edit', $event->id) }}" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg font-bold text-xs uppercase tracking-widest transition">Edit Event</a>
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus event ini?')" class="px-6 py-2 bg-red-600 hover:bg-red-700 rounded-lg font-bold text-xs uppercase tracking-widest transition">Hapus</button>
                    </form>
                </div>
            </div>

            <div class="bg-black/40 border border-white/10 rounded-[2.5rem] p-10 shadow-2xl backdrop-blur-md">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div class="md:col-span-1">
                        <div class="aspect-[3/4] rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
                            <img src="{{ $event->poster }}" alt="Poster" class="w-full h-full object-cover">
                        </div>
                        <div class="mt-6 p-4 bg-indigo-500/10 border border-indigo-500/20 rounded-2xl text-center">
                            <span class="text-[10px] font-black uppercase text-indigo-400 tracking-widest">Status</span>
                            <div class="text-xl font-black uppercase text-white italic tracking-tighter">{{ $event->status }}</div>
                        </div>
                    </div>
                    <div class="md:col-span-2 space-y-8">
                        <div>
                            <h1 class="text-5xl font-black uppercase italic tracking-tighter leading-none text-indigo-500">{{ $event->title }}</h1>
                            <div class="flex items-center gap-4 mt-4 text-gray-400 text-sm font-bold uppercase tracking-widest">
                                <span>{{ $event->location }}</span>
                                <span class="text-gray-700">|</span>
                                <span>{{ $event->event_date }}</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-[10px] font-black uppercase text-gray-500 tracking-[0.3em]">Description</h3>
                            <p class="text-gray-300 leading-relaxed">{{ $event->description }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-6 pt-6 border-t border-white/5">
                            <div>
                                <h3 class="text-[10px] font-black uppercase text-gray-500 tracking-[0.3em] mb-2">Start Time</h3>
                                <div class="text-2xl font-black italic">{{ $event->start_time }}</div>
                            </div>
                            <div>
                                <h3 class="text-[10px] font-black uppercase text-gray-500 tracking-[0.3em] mb-2">End Time</h3>
                                <div class="text-2xl font-black italic">{{ $event->end_time }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>