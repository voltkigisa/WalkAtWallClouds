<x-admin-layout title="Detail Order - WalkAtWallClouds">
    <main class="bg-gray-900 min-h-screen text-white py-12">
        <div class="max-w-5xl mx-auto px-6">
            
            {{-- Header --}}
            <div class="flex justify-between items-center mb-10">
                <a href="{{ route('order-items.index') }}" class="text-gray-500 hover:text-white font-black uppercase text-[10px] tracking-[0.2em] transition">
                    ← Back to Order List
                </a>
                <div class="flex gap-3">
                    @if($order->status !== 'cancelled')
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan order ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 bg-red-600/20 hover:bg-red-600 border border-red-600/50 rounded-xl text-[10px] font-black uppercase tracking-widest transition">
                            Cancel Order
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-sm font-bold uppercase tracking-widest text-center">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Order Info Card --}}
                <div class="lg:col-span-1">
                    <div class="bg-black/40 border border-white/10 rounded-3xl p-8 shadow-2xl backdrop-blur-md">
                        <div class="text-center mb-6">
                            <span class="text-indigo-500 font-black uppercase tracking-[0.3em] text-[9px]">Order Details</span>
                            <h1 class="text-2xl font-black uppercase italic tracking-tighter mt-2 break-all">{{ $order->order_code }}</h1>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="p-4 bg-white/5 rounded-xl border border-white/5">
                                <p class="text-[9px] text-gray-500 uppercase font-bold mb-1">Customer</p>
                                <p class="text-sm font-black uppercase">{{ $order->user->name ?? 'Unknown' }}</p>
                                <p class="text-[10px] text-gray-400">{{ $order->user->email ?? '-' }}</p>
                            </div>
                            
                            <div class="p-4 bg-white/5 rounded-xl border border-white/5">
                                <p class="text-[9px] text-gray-500 uppercase font-bold mb-1">Order Status</p>
                                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black uppercase border 
                                    {{ $order->status === 'paid' ? 'bg-green-500/10 border-green-500 text-green-500' : '' }}
                                    {{ $order->status === 'pending' ? 'bg-yellow-500/10 border-yellow-500 text-yellow-500' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-500/10 border-red-500 text-red-500' : '' }}
                                    {{ $order->status === 'expired' ? 'bg-gray-500/10 border-gray-500 text-gray-500' : '' }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                            
                            <div class="p-4 bg-indigo-600/10 border border-indigo-500/20 rounded-xl">
                                <p class="text-[9px] text-indigo-400 uppercase font-bold mb-1">Total Amount</p>
                                <p class="text-2xl font-black italic text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>

                            <div class="pt-4 border-t border-white/5">
                                <p class="text-[9px] text-gray-500 uppercase font-bold mb-1">Order Date</p>
                                <p class="text-sm font-bold">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="lg:col-span-2">
                    <div class="bg-black/40 border border-white/10 rounded-3xl overflow-hidden shadow-2xl backdrop-blur-md">
                        <div class="p-6 border-b border-white/5">
                            <h3 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400">Order Items</h3>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">{{ $order->items->count() }} item(s)</p>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @forelse($order->items as $item)
                                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-xl border border-white/5 hover:bg-white/10 transition">
                                        <div class="flex-1">
                                            <h4 class="font-black uppercase text-sm text-white">{{ $item->ticketType->name ?? 'Unknown Ticket' }}</h4>
                                            <p class="text-[10px] text-gray-500 font-bold uppercase">{{ $item->ticketType->event->title ?? 'Unknown Event' }}</p>
                                            <p class="text-xs text-gray-400 mt-1">Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-black italic text-indigo-300">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500 py-8 text-sm uppercase font-bold">No items in this order</p>
                                @endforelse
                            </div>

                            <div class="mt-6 pt-6 border-t border-white/5">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400 font-bold uppercase text-sm">Total</span>
                                    <span class="text-3xl font-black italic text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Info --}}
                    @if($order->payment)
                    <div class="mt-6 bg-black/40 border border-white/10 rounded-3xl p-6 shadow-2xl backdrop-blur-md">
                        <h3 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400 mb-4">Payment Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-white/5 rounded-xl">
                                <p class="text-[9px] text-gray-500 uppercase font-bold mb-1">Payment Method</p>
                                <p class="text-sm font-bold uppercase">{{ $order->payment->payment_method ?? 'N/A' }}</p>
                            </div>
                            <div class="p-4 bg-white/5 rounded-xl">
                                <p class="text-[9px] text-gray-500 uppercase font-bold mb-1">Payment Status</p>
                                <p class="text-sm font-bold uppercase">{{ $order->payment->status ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>
