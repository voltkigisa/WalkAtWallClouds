<x-layout title="Tambah Event Baru - WalkAtWallClouds">
    <main class="bg-gray-900 min-h-screen text-white py-12 flex items-center justify-center">
        <div class="max-w-2xl w-full px-6">
            {{-- Header --}}
            <div class="text-center mb-10">
                <span class="text-indigo-500 font-black uppercase tracking-[0.2em] text-[10px]">Admin Mode</span>
                <h1 class="text-3xl font-black uppercase tracking-tighter mt-1 italic">
                    Create <span class="text-indigo-500">New Event</span>
                </h1>
            </div>

            {{-- Error Handling --}}
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 text-red-400 rounded-xl text-xs font-bold uppercase italic">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Create --}}
            <form action="{{ route('events.store') }}" method="POST" class="space-y-6 bg-black/40 p-8 rounded-3xl border border-white/10 shadow-2xl backdrop-blur-md">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-2 tracking-widest">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-sm focus:border-indigo-500 outline-none transition font-bold" placeholder="Event Name">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-2 tracking-widest">Description</label>
                        <textarea name="description" rows="3" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-sm focus:border-indigo-500 outline-none transition font-bold" placeholder="Tell us about the event...">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-2 tracking-widest">Location</label>
                            <input type="text" name="location" value="{{ old('location') }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-sm focus:border-indigo-500 outline-none transition font-bold" placeholder="Venue Name">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-2 tracking-widest">Event Date</label>
                            <input type="date" name="event_date" value="{{ old('event_date') }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-sm focus:border-indigo-500 outline-none transition font-bold text-gray-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-2 tracking-widest">Start Time</label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-sm focus:border-indigo-500 outline-none transition font-bold text-gray-400">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-2 tracking-widest">End Time</label>
                            <input type="time" name="end_time" value="{{ old('end_time') }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-sm focus:border-indigo-500 outline-none transition font-bold text-gray-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-2 tracking-widest">Poster URL</label>
                        <input type="text" name="poster" value="{{ old('poster') }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-sm focus:border-indigo-500 outline-none transition font-bold" placeholder="https://image-link.com/poster.jpg">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-2 tracking-widest">Status</label>
                        <select name="status" required class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-sm focus:border-indigo-500 outline-none transition font-bold text-gray-400 appearance-none">
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                </div>

                <div class="pt-6 flex gap-4">
                    <button type="submit" class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition shadow-lg shadow-indigo-500/20 uppercase tracking-widest text-xs">
                        Simpan Event
                    </button>
                    <a href="{{ route('events.index') }}" class="flex-1 py-4 bg-white/5 hover:bg-white/10 text-white text-center font-black rounded-xl transition uppercase tracking-widest text-xs border border-white/10">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-layout>