<x-admin-layout title="Tambah Event Baru - WalkAtWallClouds">
    <main class="fixed inset-0 bg-gray-900 flex items-center justify-center overflow-hidden ml-64 text-white">
        <div class="max-w-xl w-full px-8">
            
            {{-- Header --}}
            <div class="text-center mb-6 mt-12">
                <h1 class="text-2xl font-black uppercase tracking-tighter italic">Tambah <span class="text-indigo-500">Artist</span></h1>
                <p class="text-gray-500 text-[10px] mt-1 uppercase tracking-[0.2em] font-bold">New Music Celebration</p>
                <div class="h-1 w-12 bg-indigo-500 mx-auto mt-2"></div>
            </div>

            {{-- Error Handling --}}
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-500/10 border border-red-500/50 text-red-400 rounded-xl text-[10px] uppercase font-bold italic">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Create --}}
            <form action="{{ route('events.store') }}" method="POST" class="space-y-3 bg-black/40 p-6 rounded-[2.5rem] border border-white/10 shadow-2xl backdrop-blur-md">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    {{-- Event Title --}}
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Event Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Clouds Festival" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition font-medium">
                    </div>

                    {{-- Genre (BARU) --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Genre</label>
                        <input type="text" name="genre" value="{{ old('genre') }}" placeholder="Rock, Pop, Techno" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition font-medium">
                    </div>

                    {{-- Country (BARU) --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Country</label>
                        <input type="text" name="country" value="{{ old('country') }}" placeholder="Indonesia" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition font-medium">
                    </div>

                    {{-- Location --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Location / Venue</label>
                        <input type="text" name="location" value="{{ old('location') }}" placeholder="Nama Lokasi" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition font-medium">
                    </div>

                    {{-- Event Date --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Event Date</label>
                        <input type="date" name="event_date" value="{{ old('event_date') }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-gray-400 focus:border-indigo-500 outline-none transition font-medium">
                    </div>

                    {{-- Start Time --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Start Time</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-gray-400 focus:border-indigo-500 outline-none transition">
                    </div>

                    {{-- End Time --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">End Time</label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-gray-400 focus:border-indigo-500 outline-none transition">
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Status</label>
                    <select name="status" required class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-gray-400 focus:border-indigo-500 outline-none appearance-none transition">
                        <option value="draft">Draft</option>
                        <option value="active">Active</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 flex gap-3">
                    <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition shadow-lg shadow-indigo-500/20 uppercase tracking-widest text-[10px]">
                        Simpan Event
                    </button>
                    <a href="{{ route('events.index') }}" class="flex-1 py-3 bg-white/5 hover:bg-white/10 text-white text-center font-black rounded-xl transition uppercase tracking-widest text-[10px] border border-white/10">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>