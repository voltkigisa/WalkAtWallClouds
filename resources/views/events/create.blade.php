<x-admin-layout title="Tambah Event Baru - WalkAtWallClouds">
    <main class="fixed inset-0 bg-gray-900 flex items-center justify-center overflow-hidden ml-64">
        <div class="max-w-lg w-full px-8">
            
            {{-- Header --}}
            <div class="text-center mb-6 mt-12">
                <span class="text-indigo-500 font-black uppercase tracking-[0.2em] text-[10px]">Admin Mode</span>
                <h1 class="text-2xl font-black uppercase tracking-tighter mt-1 italic text-white">
                    Create <span class="text-indigo-500">New Event</span>
                </h1>
            </div>

            {{-- Form Create --}}
            <form action="{{ route('events.store') }}" method="POST" class="space-y-4 bg-black/40 p-6 rounded-[2rem] border border-white/10 shadow-2xl backdrop-blur-md">
                @csrf
                
                <div class="space-y-3">
                    {{-- Title --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-white focus:border-indigo-500 outline-none transition font-medium" placeholder="Event Name">
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Description</label>
                        <textarea name="description" rows="2" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-white focus:border-indigo-500 outline-none transition font-medium resize-none" placeholder="Tell us about the event...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Location & Date --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Location</label>
                            <input type="text" name="location" value="{{ old('location') }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-white focus:border-indigo-500 outline-none transition font-medium" placeholder="Venue">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Date</label>
                            <input type="date" name="event_date" value="{{ old('event_date') }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-gray-400 focus:border-indigo-500 outline-none transition font-medium">
                        </div>
                    </div>

                    {{-- Start & End Time --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Start Time</label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-gray-400 focus:border-indigo-500 outline-none transition font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">End Time</label>
                            <input type="time" name="end_time" value="{{ old('end_time') }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-gray-400 focus:border-indigo-500 outline-none transition font-medium">
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Status</label>
                        <select name="status" required class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-gray-400 focus:border-indigo-500 outline-none transition font-medium appearance-none">
                            <option value="draft">Draft</option>
                            <option value="active">Active</option>
                        </select>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 flex gap-3">
                    <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition shadow-lg shadow-indigo-500/20 uppercase tracking-widest text-[10px]">
                        Save Event
                    </button>
                    <a href="{{ route('events.index') }}" class="flex-1 py-3 bg-white/5 hover:bg-white/10 text-white text-center font-black rounded-xl transition uppercase tracking-widest text-[10px] border border-white/10">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>