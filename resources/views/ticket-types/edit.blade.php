<x-admin-layout title="Edit Ticket Type - WalkAtWallClouds">
    <main class="fixed inset-0 bg-gray-900 flex items-center justify-center overflow-hidden ml-64 text-white">
        <div class="max-w-xl w-full px-8">
            {{-- Header --}}
            <div class="text-center mb-6">
                <span class="text-indigo-500 font-bold uppercase tracking-[0.2em] text-[10px]">Editor Mode</span>
                <h1 class="text-2xl font-black uppercase tracking-tighter mt-1 italic">
                    Edit <span class="text-indigo-500">Ticket Details</span>
                </h1>
                <p class="text-gray-500 text-[10px] font-bold uppercase mt-1 tracking-widest">{{ $ticketType->name }}</p>
            </div>

            {{-- Form Edit --}}
            <form action="{{ route('ticket-types.update', $ticketType->id) }}" method="POST" 
                class="space-y-4 bg-black/40 p-8 rounded-[2.5rem] border border-white/10 shadow-2xl backdrop-blur-md">
                @csrf
                @method('PUT')
                
                <div class="space-y-3">
                    {{-- Event Selection --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Event Assignment</label>
                        <select name="event_id" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition text-gray-300 appearance-none">
                            @foreach(\App\Models\Event::all() as $event)
                                <option value="{{ $event->id }}" {{ old('event_id', $ticketType->event_id) == $event->id ? 'selected' : '' }} class="bg-gray-900">
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Ticket Name --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Ticket Name</label>
                        <input type="text" name="name" value="{{ old('name', $ticketType->name) }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition font-bold text-white">
                    </div>

                    {{-- Price --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Price (IDR)</label>
                        <input type="number" name="price" value="{{ old('price', $ticketType->price) }}" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition text-white font-bold">
                    </div>

                    {{-- Quota & Sold Row --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Total Quota</label>
                            <input type="number" name="quota" value="{{ old('quota', $ticketType->quota) }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition text-white">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-red-400 uppercase mb-1 tracking-widest">Sold Amount</label>
                            <input type="number" name="sold" value="{{ old('sold', $ticketType->sold) }}" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-red-500 outline-none transition text-white">
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="pt-6 flex gap-3">
                    <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition shadow-lg shadow-indigo-500/20 uppercase tracking-widest text-[10px]">
                        Update Changes
                    </button>
                    <a href="{{ route('ticket-types.show', $ticketType->id) }}" class="flex-1 py-3 bg-white/5 hover:bg-white/10 text-white text-center font-black rounded-xl transition uppercase tracking-widest text-[10px] border border-white/10">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>