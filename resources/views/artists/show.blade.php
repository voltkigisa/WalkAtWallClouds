<x-layout title="Detail Artist">
    <main class="bg-gray-900 min-h-screen text-white py-12">
        <div class="max-w-4xl mx-auto px-6">
            <div class="mb-10 flex items-center justify-between">
                <a href="{{ route('artists.index') }}" class="text-indigo-400 font-bold uppercase text-xs">← Kembali</a>
                <div class="flex gap-3">
                    {{-- TOMBOL HARUS MENGARAH KE artists.edit dan menggunakan $artist->id --}}
                    <a href="{{ route('artists.edit', $artist->id) }}" class="px-4 py-2 bg-indigo-600 rounded-lg text-xs font-bold uppercase">Edit Artist</a>
                    <form action="{{ route('artists.destroy', $artist->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 rounded-lg text-xs font-bold uppercase">Delete</button>
                    </form>
                </div>
            </div>

            <div class="bg-black/40 border border-white/10 rounded-[2rem] p-8 backdrop-blur-md">
                <div class="flex flex-col md:flex-row gap-10 items-center">
                    <div class="w-48 h-48 bg-gray-800 rounded-3xl border border-white/10 overflow-hidden">
                        @if($artist->photo)
                            <img src="{{ asset('storage/' . $artist->photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-600 font-black">NO PHOTO</div>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-5xl font-black uppercase italic tracking-tighter">{{ $artist->name }}</h1>
                        <p class="text-indigo-400 font-bold uppercase tracking-widest text-sm mt-2">Artist Profile</p>
                        
                        <div class="mt-8">
                            <h3 class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3">Participating In:</h3>
                            <div class="flex flex-wrap gap-2">
                                @forelse($artist->events as $event)
                                    <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-full text-xs font-bold">{{ $event->title }}</span>
                                @empty
                                    <span class="text-gray-600 text-xs italic">Belum terhubung ke event manapun.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>