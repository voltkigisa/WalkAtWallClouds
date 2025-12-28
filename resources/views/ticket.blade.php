<?php $title = 'ticket'; ?>
<x-layout :$title>
    <main class="bg-gray-900 min-h-screen py-20 px-4">
        <div class="max-w-4xl mx-auto">
            
            <div class="text-center mb-12">
                <h1 class="text-4xl font-black text-white uppercase italic tracking-tighter">
                    Pick Your <span class="text-indigo-500">Experience</span>
                </h1>
                <p class="text-gray-400 mt-2 font-medium uppercase tracking-widest text-xs">WalkAtWall Clouds Festival 2025</p>
            </div>

            <div class="space-y-6">
                @foreach($ticketTypes as $ticket)
                <div class="bg-black border border-gray-800 rounded-3xl overflow-hidden shadow-2xl transition-all duration-300 hover:border-indigo-500/50 group">
                    <div class="flex flex-col md:flex-row items-center p-6 gap-6">
                        
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-xl font-bold text-white uppercase italic">{{ $ticket->name }}</h3>
                                @if($ticket->stock <= 0)
                                    <span class="bg-red-500/10 text-red-500 text-[10px] font-black px-3 py-1 rounded-full border border-red-500/20 uppercase">Sold Out</span>
                                @else
                                    <span class="bg-indigo-500/10 text-indigo-400 text-[10px] font-black px-3 py-1 rounded-full border border-indigo-500/20 uppercase tracking-widest">Available</span>
                                @endif
                            </div>
                            <p class="text-gray-500 text-sm mb-4">{{ $ticket->description }}</p>
                            <p class="text-2xl font-black text-white italic">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                        </div>

                        <div class="flex flex-col items-center gap-4 w-full md:w-48">
                            @if($ticket->stock > 0)
                                <div class="flex items-center bg-gray-900 rounded-2xl border border-gray-800 p-1 w-full justify-between">
                                    <button type="button" data-action="decrement" data-target="qty-{{ $ticket->id }}" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-white transition text-xl font-bold">-</button>
                                    
                                    <input type="number" id="qty-{{ $ticket->id }}" name="qty[]" value="1" min="1" max="{{ $ticket->stock }}" 
                                        class="ticket-qty bg-transparent text-center w-12 text-white font-black focus:outline-none appearance-none">
                                    
                                    <button type="button" data-action="increment" data-target="qty-{{ $ticket->id }}" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-white transition text-xl font-bold">+</button>
                                </div>
                                
                                <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-2xl font-black uppercase tracking-widest transition shadow-lg shadow-indigo-600/20 active:scale-95">
                                    Buy Now
                                </button>
                            @else
                                <div class="w-full bg-gray-800/50 text-gray-600 py-3 rounded-2xl font-black uppercase tracking-widest text-center cursor-not-allowed border border-gray-700">
                                    Sold Out
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 p-6 bg-indigo-600/5 border border-indigo-500/20 rounded-3xl text-center">
                <p class="text-gray-400 text-xs uppercase font-bold tracking-[0.2em]">All prices include tax. 1 account max 4 tickets.</p>
            </div>
        </div>
    </main>

    @push('scripts')
        <script src="{{ asset('js/ticket-handler.js') }}"></script>
    @endpush
</x-layout>