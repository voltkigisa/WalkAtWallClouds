<x-layout title="Tambah Event Baru - WalkAtWallClouds">
    <script src="https://cdn.tailwindcss.com"></script>

    <main class="bg-gray-900 min-h-screen text-white py-12 flex items-center justify-center">
        <div class="max-w-2xl w-full px-6">
            {{-- Header --}}
            <div class="text-center mb-10">
                <h1 class="text-3xl font-black uppercase tracking-tighter">Tambah <span class="text-indigo-500">Event</span></h1>
                <p class="text-gray-500 text-sm mt-2 uppercase tracking-widest font-semibold">New Music Celebration</p>
                <div class="h-1 w-20 bg-indigo-500 mx-auto mt-4"></div>
            </div>

            {{-- Error Handling --}}
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 text-red-400 rounded-xl text-sm">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Create --}}
            <form action="{{ route('events.store') }}" method="POST" class="space-y-6 bg-black/40 p-8 rounded-3xl border border-white/10 shadow-2xl">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-indigo-400 uppercase mb-2">Event Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Clouds Festival" required 
                            class="w-full bg-gray-800/50 border border-white/10 rounded-xl p-3 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-indigo-400 uppercase mb-2">Description</label>
                        <textarea name="description" rows="3" placeholder="Jelaskan tentang event ini..." required 
                            class="w-full bg-gray-800/50 border border-white/10 rounded-xl p-3 focus:border-indigo-500 outline-none transition text-white">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-indigo-400 uppercase mb-2">Location</label>
                            <input type="text" name="location" value="{{ old('location') }}" placeholder="Nama Lokasi" required 
                                class="w-full bg-gray-800/50 border border-white/10 rounded-xl p-3 focus:border-indigo-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-indigo-400 uppercase mb-2">Date</label>
                            <input type="date" name="event_date" value="{{ old('event_date') }}" required 
                                class="w-full bg-gray-800/50 border border-white/10 rounded-xl p-3 focus:border-indigo-500 outline-none transition text-gray-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-indigo-400 uppercase mb-2">Start Time</label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}" required 
                                class="w-full bg-gray-800/50 border border-white/10 rounded-xl p-3 focus:border-indigo-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-indigo-400 uppercase mb-2">End Time</label>
                            <input type="time" name="end_time" value="{{ old('end_time') }}" required 
                                class="w-full bg-gray-800/50 border border-white/10 rounded-xl p-3 focus:border-indigo-500 outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-indigo-400 uppercase mb-2">Poster URL</label>
                        <input type="text" name="poster" value="{{ old('poster') }}" placeholder="https://..." required 
                            class="w-full bg-gray-800/50 border border-white/10 rounded-xl p-3 focus:border-indigo-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-indigo-400 uppercase mb-2">Status</label>
                        <select name="status" required class="w-full bg-gray-800/50 border border-white/10 rounded-xl p-3 focus:border-indigo-500 outline-none transition text-gray-400">
                            <option value="draft">Draft</option>
                            <option value="active">Active</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition shadow-lg shadow-indigo-500/20 uppercase tracking-widest">
                        Simpan Event
                    </button>
                    <a href="{{ route('events.index') }}" class="flex-1 py-4 bg-gray-800 hover:bg-gray-700 text-white text-center font-black rounded-xl transition uppercase tracking-widest border border-white/5">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-layout>