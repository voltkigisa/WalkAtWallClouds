<x-admin-layout title="Detail Artist - WalkAtWallClouds">
    <main class="fixed inset-0 bg-gray-900 flex items-center justify-center overflow-hidden ml-64 text-white">
        <div class="max-w-4xl w-full px-8">
            
            {{-- Navigation & Actions --}}
            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('artists.index') }}" class="text-gray-500 hover:text-indigo-400 font-black uppercase text-[10px] tracking-widest transition">
                    ← Back to List
                </a>
                <div class="flex gap-3">
                    <a href="{{ route('artists.edit', $artist->id) }}" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-xl text-[10px] font-black uppercase tracking-widest transition shadow-lg shadow-indigo-500/20">
                        Edit Artist
                    </a>
                    <form action="{{ route('artists.destroy', $artist->id) }}" method="POST" onsubmit="return confirm('Hapus artist ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-5 py-2 bg-red-600/20 hover:bg-red-600 border border-red-600/50 rounded-xl text-[10px] font-black uppercase tracking-widest transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            {{-- Card Detail --}}
            <div class="bg-black/40 border border-white/10 rounded-[3rem] p-10 backdrop-blur-md shadow-2xl relative overflow-hidden">
                <div class="flex flex-col md:flex-row gap-12 items-center relative z-10">
                    
                    {{-- Artist Photo --}}
                    <div class="w-56 h-56 bg-white/5 rounded-[2.5rem] border border-white/10 overflow-hidden shadow-2xl flex-shrink-0">
                        @if($artist->photo)
                            <img src="{{ asset('storage/' . $artist->photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-700 font-black text-xs">NO_PHOTO</div>
                        @endif
                    </div>

                    {{-- Artist Info Content --}}
                    <div class="flex-1">
                        <span class="text-indigo-500 font-black uppercase tracking-[0.3em] text-[10px]">Artist Profile</span>
                        <h1 class="text-6xl font-black uppercase italic tracking-tighter mt-2 mb-4 leading-none">
                            {{ $artist->name }}
                        </h1>
                        
                        {{-- Keterangan Genre & Country (Hanya Teks/Informasi) --}}
                        <div class="flex gap-8 mb-8 border-l-2 border-indigo-500/30 pl-6">
                            <div>
                                <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Genre</h3>
                                <p class="text-lg font-bold text-white uppercase tracking-tight italic">
                                    {{ $artist->genre ?? 'Not Specified' }}
                                </p>
                            </div>
                            <div>
                                <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Origin / Country</h3>
                                <p class="text-lg font-bold text-white uppercase tracking-tight">
                                    {{ $artist->country ?? 'Unknown' }}
                                </p>
                            </div>
                        </div>

                        {{-- Participating Events --}}
                        <div>
                            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Participating In:</h3>
                            <div class="flex flex-wrap gap-2 max-h-24 overflow-y-auto custom-scrollbar pr-2">
                                @forelse($artist->events as $event)
                                    <span class="px-4 py-1.5 bg-white/5 border border-white/10 rounded-full text-[10px] font-black uppercase tracking-widest text-indigo-300">
                                        {{ $event->title }}
                                    </span>
                                @empty
                                    <span class="text-gray-600 text-[10px] font-bold uppercase italic tracking-widest">No events assigned.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.05); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #4f46e5; border-radius: 10px; }
    </style>
</x-admin-layout>