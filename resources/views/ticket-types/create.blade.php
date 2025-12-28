<x-admin-layout title="Tambah Ticket Type - WalkAtWallClouds">
    <main class="fixed inset-0 bg-gray-900 flex items-center justify-center overflow-hidden ml-64 text-white">
        <div class="max-w-xl w-full px-8">
            {{-- Header --}}
            <div class="text-center mb-6">
                <span class="text-indigo-500 font-bold uppercase tracking-[0.2em] text-[10px]">Management</span>
                <h1 class="text-2xl font-black uppercase tracking-tighter mt-1 italic">
                    Create <span class="text-indigo-500">New Ticket</span>
                </h1>
            </div>

            {{-- Error Handling --}}
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-500/10 border border-red-500/50 text-red-400 rounded-xl text-[10px] font-bold uppercase">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Create --}}
            <form action="{{ route('ticket-types.store') }}" method="POST" 
                class="space-y-4 bg-black/40 p-8 rounded-[2.5rem] border border-white/10 shadow-2xl backdrop-blur-md">
                @csrf
                
                <div class="space-y-4">
                    {{-- Event Selection --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Select Event</label>
                        <select name="event_id" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition text-gray-300 appearance-none cursor-pointer">
                            <option value="" class="bg-gray-900">Pilih Event</option>
                            @foreach(\App\Models\Event::all() as $event)
                                <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }} class="bg-gray-900">
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Ticket Name --}}
                    <div>
                        <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Ticket Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. VIP, Festival, Early Bird" required 
                            class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition font-bold text-white">
                    </div>

                    {{-- Price & Quota --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Price (IDR)</label>
                            <input type="number" name="price" value="{{ old('price') }}" placeholder="0" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition text-white font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-indigo-400 uppercase mb-1 tracking-widest">Quota</label>
                            <input type="number" name="quota" value="{{ old('quota') }}" placeholder="100" required 
                                class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-sm focus:border-indigo-500 outline-none transition text-white font-bold">
                        </div>
                    </div>

                    {{-- Default Sold (Hidden) --}}
                    <input type="hidden" name="sold" value="0">
                </div>

                {{-- Buttons --}}
                <div class="pt-4 flex gap-3">
                    <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition shadow-lg shadow-indigo-500/20 uppercase tracking-widest text-[10px]">
                        Save Ticket
                    </button>
                    <a href="{{ route('ticket-types.index') }}" class="flex-1 py-3 bg-white/5 hover:bg-white/10 text-white text-center font-black rounded-xl transition uppercase tracking-widest text-[10px] border border-white/10">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-admin-layout>