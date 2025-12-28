@php
    $isAdmin = Auth::user()->role === 'admin';
    $layout = $isAdmin ? 'admin-layout' : 'layout';
@endphp

<x-dynamic-component :component="$layout" :title="$isAdmin ? 'User Profile - WalkAtWallClouds' : 'My Profile - WalkAtWallClouds'">
    <main class="bg-gray-900 min-h-screen text-white py-12">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="flex justify-between items-center mb-10">
                <a href="{{ Auth::user()->role === 'admin' ? route('users.index') : route('admin') }}" class="text-gray-500 hover:text-white font-black uppercase text-[10px] tracking-[0.2em] transition">
                    ← Back
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- User Info Card --}}
                <div class="lg:col-span-1">
                    <div class="bg-black/40 border border-white/10 rounded-[2.5rem] p-8 shadow-2xl backdrop-blur-md text-center">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-4xl font-black mx-auto mb-6 shadow-lg shadow-indigo-500/30">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        
                        <h2 class="text-2xl font-black uppercase tracking-tighter italic mb-2">{{ $user->name }}</h2>
                        <p class="text-gray-500 text-sm mb-4">{{ $user->email }}</p>
                        
                        <div class="inline-block px-4 py-2 rounded-full text-[10px] font-black uppercase border 
                            {{ $user->role === 'admin' ? 'bg-purple-500/10 border-purple-500 text-purple-500' : 'bg-blue-500/10 border-blue-500 text-blue-500' }}">
                            {{ $user->role }}
                        </div>

                        @if($user->provider)
                            <div class="mt-4 p-3 bg-green-500/10 border border-green-500/20 rounded-xl">
                                <p class="text-[9px] text-gray-500 uppercase font-bold mb-1">Login Via</p>
                                <p class="text-sm font-black uppercase text-green-400">{{ $user->provider }}</p>
                            </div>
                        @endif

                        <div class="mt-6 pt-6 border-t border-white/5">
                            <p class="text-[9px] text-gray-500 uppercase font-bold mb-1">Member Since</p>
                            <p class="text-sm font-bold">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Statistics & History --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Statistics Cards --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gradient-to-br from-indigo-600/20 to-purple-600/20 p-6 rounded-2xl border border-indigo-500/30 shadow-xl">
                            <p class="text-indigo-300 text-[10px] font-black uppercase tracking-widest mb-2">Total Tickets</p>
                            <h3 class="text-4xl font-black italic text-white">{{ $totalTickets }}</h3>
                        </div>
                        
                        <div class="bg-gradient-to-br from-green-600/20 to-emerald-600/20 p-6 rounded-2xl border border-green-500/30 shadow-xl">
                            <p class="text-green-300 text-[10px] font-black uppercase tracking-widest mb-2">Total Spent</p>
                            <h3 class="text-2xl font-black italic text-white">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h3>
                        </div>
                        
                        <div class="bg-gradient-to-br from-yellow-600/20 to-orange-600/20 p-6 rounded-2xl border border-yellow-500/30 shadow-xl">
                            <p class="text-yellow-300 text-[10px] font-black uppercase tracking-widest mb-2">Events Attended</p>
                            <h3 class="text-4xl font-black italic text-white">{{ $eventsAttended->count() }}</h3>
                        </div>
                    </div>

                    {{-- Events Attended --}}
                    <div class="bg-black/40 border border-white/10 rounded-3xl overflow-hidden shadow-2xl backdrop-blur-md">
                        <div class="p-6 border-b border-white/5">
                            <h3 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400">Events Attended</h3>
                        </div>
                        <div class="p-6">
                            @if($eventsAttended->count() > 0)
                                <div class="space-y-3">
                                    @foreach($eventsAttended as $event)
                                        <div class="flex items-center gap-4 p-4 bg-white/5 rounded-xl border border-white/5 hover:bg-white/10 transition">
                                            <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center flex-shrink-0">
                                                <i class="fa-solid fa-calendar text-white"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-black uppercase italic text-white">{{ $event->title }}</h4>
                                                <p class="text-[10px] text-gray-500 font-bold uppercase">{{ $event->location }} • {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center text-gray-500 py-8 text-sm uppercase font-bold">No events attended yet</p>
                            @endif
                        </div>
                    </div>

                    {{-- Ticket Types Purchased --}}
                    <div class="bg-black/40 border border-white/10 rounded-3xl overflow-hidden shadow-2xl backdrop-blur-md">
                        <div class="p-6 border-b border-white/5">
                            <h3 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400">Ticket Purchase History</h3>
                        </div>
                        <div class="p-6">
                            @if($ticketTypes->count() > 0)
                                <div class="space-y-3">
                                    @foreach($ticketTypes as $ticket)
                                        <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5">
                                            <div>
                                                <h4 class="font-black uppercase text-sm text-white">{{ $ticket['name'] }}</h4>
                                                <p class="text-[10px] text-gray-500 font-bold uppercase">{{ $ticket['event'] }}</p>
                                            </div>
                                            <div class="text-right">
                                                <span class="px-3 py-1 bg-indigo-500/10 text-indigo-400 text-[10px] font-black rounded-full border border-indigo-500/20">
                                                    {{ $ticket['quantity'] }}x Tickets
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center text-gray-500 py-8 text-sm uppercase font-bold">No tickets purchased yet</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</x-dynamic-component>
