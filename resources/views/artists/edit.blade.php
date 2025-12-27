<x-admin-layout title="Edit Artist - WalkAtWallClouds">
    <main class="fixed inset-0 bg-gray-900 flex items-center justify-center overflow-hidden ml-64 text-white">
        <div class="max-w-xl w-full px-8">
            
            {{-- Header --}}
            <div class="text-center mb-6 mt-12">
                <span class="text-indigo-500 font-bold uppercase tracking-[0.2em] text-[10px]">Admin Mode</span>
                <h1 class="text-2xl font-black uppercase tracking-tighter mt-1 italic">
                    Edit <span class="text-indigo-500">Artist</span>
                </h1>
                <p class="text-gray-500 text-[10px] italic font-bold uppercase tracking-widest mt-1 truncate">{{ $artist->name }}</p>
            </div>

            {{-- Form Edit --}}
            <form action="{{ route('artists.update', $artist->id) }}" method="POST" enctype="multipart/form-data" 
                class="space-y-4 bg-black/40 p-6 rounded-[2.5rem] border border-white/10 shadow-2xl backdrop-blur-md">
                @csrf
                @method('PUT')

                <div class="space-y-3">
                    {{-- Artist Name --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Artist Name</label>
                        <input type="text" name="name" value="{{ old('name', $artist->name) }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition font-bold">
                    </div>

                    {{-- Genre & Country (Dibuat Grid agar hemat tempat) --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Genre</label>
                            <input type="text" name="genre" value="{{ old('genre', $artist->genre) }}" placeholder="e.g. Rock, Indie" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Country</label>
                            <input type="text" name="country" value="{{ old('country', $artist->country) }}" placeholder="e.g. Indonesia" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition font-bold">
                        </div>
                    </div>

                    {{-- Photo Upload --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Profile Photo</label>
                        <div class="flex items-center gap-4 p-3 bg-white/5 border border-white/10 rounded-xl">
                            @if($artist->photo)
                                <img src="{{ asset('storage/' . $artist->photo) }}" class="w-10 h-10 rounded-lg object-cover border border-white/20">
                            @endif
                            <input type="file" name="photo" 
                                class="block w-full text-[10px] text-gray-400 file:mr-3 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-[9px] file:font-black file:uppercase file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition cursor-pointer">
                        </div>
                    </div>

                    {{-- Assign to Events (Max Height dikurangi agar tidak memicu scroll layar) --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Assign to Events</label>
                        <div class="grid grid-cols-1 gap-2 max-h-32 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($events as $event)
                                <label class="flex items-center gap-3 p-2 bg-white/5 border border-white/5 rounded-lg cursor-pointer hover:bg-white/10 transition">
                                    <input type="checkbox" name="events[]" value="{{ $event->id }}" 
                                        {{ in_array($event->id, old('events', $artist->events->pluck('id')->toArray())) ? 'checked' : '' }}
                                        class="w-3 h-3 rounded border-white/10 text-indigo-600 focus:ring-indigo-500 bg-gray-900">
                                    <span class="text-[10px] font-bold uppercase tracking-tight">{{ $event->title }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 flex gap-3">
                    <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition shadow-lg shadow-indigo-500/30 uppercase tracking-widest text-[10px]">
                        Save Changes
                    </button>
                    <a href="{{ route('artists.index') }}" class="flex-1 py-3 bg-white/5 hover:bg-white/10 text-white text-center font-black rounded-xl transition uppercase tracking-widest text-[10px] border border-white/10">
                        Cancel
                    </a>
                </div>
            </form>
            
            {{-- Delete Button (Dibuat lebih simpel agar tidak memakan space bawah) --}}
            <div class="mt-4 text-center">
                <form action="{{ route('artists.destroy', $artist->id) }}" method="POST" onsubmit="return confirm('Hapus artist ini secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500/40 hover:text-red-500 text-[9px] font-black uppercase tracking-widest transition">
                        [ Delete Artist ]
                    </button>
                </form>
            </div>
        </div>
    </main>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.05); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #4f46e5; border-radius: 10px; }
    </style>
</x-admin-layout>