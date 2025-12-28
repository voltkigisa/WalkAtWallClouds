<x-layout title="Edit Artist - WalkAtWallClouds">
    <script src="https://cdn.tailwindcss.com"></script>

    <main class="bg-gray-900 min-h-screen text-white py-12 flex items-center justify-center">
        <div class="max-w-2xl w-full px-6">
            {{-- Header --}}
            <div class="text-center mb-10">
                <span class="text-indigo-500 font-bold uppercase tracking-[0.2em] text-[10px]">Admin Mode</span>
                <h1 class="text-3xl font-black uppercase tracking-tighter mt-1 italic">
                    Edit <span class="text-indigo-500">Artist</span>
                </h1>
                <p class="text-gray-500 text-sm italic font-bold uppercase tracking-widest mt-2">{{ $artist->name }}</p>
            </div>

            {{-- Error Handling --}}
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 text-red-400 rounded-2xl text-xs">
                    <ul class="list-disc ml-5 font-bold uppercase tracking-tight">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Edit --}}
            <form action="{{ route('artists.update', $artist->id) }}" method="POST" enctype="multipart/form-data" 
                class="space-y-6 bg-black/40 p-8 rounded-[2rem] border border-white/10 shadow-2xl relative overflow-hidden backdrop-blur-md">
                @csrf
                @method('PUT')

                <div class="space-y-5 relative z-10">
                    {{-- Name --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-2 tracking-[0.2em]">Artist Name</label>
                        <input type="text" name="name" value="{{ old('name', $artist->name) }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition font-bold">
                    </div>

                    {{-- Photo Upload --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-2 tracking-[0.2em]">Profile Photo</label>
                        <div class="flex items-center gap-4 p-4 bg-white/5 border border-white/10 rounded-xl">
                            @if($artist->photo)
                                <img src="{{ asset('storage/' . $artist->photo) }}" class="w-12 h-12 rounded-lg object-cover border border-white/20">
                            @endif
                            <input type="file" name="photo" 
                                class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition">
                        </div>
                    </div>

                    {{-- Connected Events (Multi-Select) --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-2 tracking-[0.2em]">Assign to Events</label>
                        <div class="grid grid-cols-1 gap-2 max-h-40 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($events as $event)
                                <label class="flex items-center gap-3 p-3 bg-white/5 border border-white/5 rounded-xl cursor-pointer hover:bg-white/10 transition">
                                    <input type="checkbox" name="events[]" value="{{ $event->id }}" 
                                        {{ in_array($event->id, old('events', $artist->events->pluck('id')->toArray())) ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-white/10 text-indigo-600 focus:ring-indigo-500 bg-gray-900">
                                    <span class="text-xs font-bold uppercase tracking-tight">{{ $event->title }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-6 flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl transition shadow-lg shadow-indigo-500/30 uppercase tracking-[0.2em] text-[10px]">
                        Save Changes
                    </button>
                    <a href="{{ route('artists.index') }}" class="flex-1 py-4 bg-white/5 hover:bg-white/10 text-white text-center font-black rounded-2xl transition uppercase tracking-[0.2em] text-[10px] border border-white/10">
                        Cancel
                    </a>
                </div>
            </form>
            
            <div class="mt-8 text-center">
                <form action="{{ route('artists.destroy', $artist->id) }}" method="POST" onsubmit="return confirm('Hapus artist ini secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500/50 hover:text-red-500 text-[10px] font-black uppercase tracking-[0.2em] transition">
                        Hapus Artist Ini
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
</x-layout>