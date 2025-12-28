<x-admin-layout title="Edit Event - WalkAtWallClouds">
    <main class="fixed inset-0 bg-gray-900 flex items-center justify-center overflow-hidden ml-64">
        <div class="max-w-lg w-full px-8">
            
            <div class="text-center mb-6 mt-12">
                <span class="text-indigo-500 font-black uppercase tracking-[0.2em] text-[10px]">Admin Mode</span>
                <h1 class="text-2xl font-black uppercase tracking-tighter mt-1 italic text-white">
                    Edit <span class="text-indigo-500">Event</span>
                </h1>
                <p class="text-gray-500 text-[10px] font-bold uppercase mt-1 tracking-widest italic truncate">{{ $event->title }}</p>
            </div>

            {{-- Form Edit --}}
            <form action="{{ route('events.update', $event->id) }}" method="POST" class="space-y-4 bg-black/40 p-6 rounded-[2rem] border border-white/10 shadow-2xl backdrop-blur-md">
                @csrf
                @method('PUT')
                
                <div class="space-y-3">
                    {{-- Title --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Title</label>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-white focus:border-indigo-500 outline-none transition font-medium">
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Description</label>
                        <textarea name="description" rows="2" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-white focus:border-indigo-500 outline-none transition font-medium resize-none">{{ old('description', $event->description) }}</textarea>
                    </div>

                    {{-- Location & Date --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Location</label>
                            <input type="text" name="location" value="{{ old('location', $event->location) }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-white focus:border-indigo-500 outline-none transition font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Date</label>
                            <input type="date" name="event_date" value="{{ old('event_date', $event->event_date) }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-gray-400 focus:border-indigo-500 outline-none transition font-medium">
                        </div>
                    </div>

                    {{-- Start & End Time --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Start Time</label>
                            <input type="time" name="start_time" value="{{ old('start_time', $event->start_time) }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-gray-400 focus:border-indigo-500 outline-none transition font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">End Time</label>
                            <input type="time" name="end_time" value="{{ old('end_time', $event->end_time) }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-gray-400 focus:border-indigo-500 outline-none transition font-medium">
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Status</label>
                        <select name="status" required class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm text-gray-400 focus:border-indigo-500 outline-none transition font-medium appearance-none">
                            <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status', $event->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 flex gap-3">
                    <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition shadow-lg shadow-indigo-500/20 uppercase tracking-widest text-[10px]">
                        Update Event
                    </button>
                    <a href="{{ route('events.show', $event->id) }}" class="flex-1 py-3 bg-white/5 hover:bg-white/10 text-white text-center font-black rounded-xl transition uppercase tracking-widest text-[10px] border border-white/10">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>