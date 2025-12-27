<x-admin-layout title="Detail Order Item - WalkAtWallClouds">
    <main class="fixed inset-0 bg-gray-900 flex items-center justify-center ml-64 text-white p-6">
        <div class="max-w-xl w-full">
            
            {{-- Navigasi Atas --}}
            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('order-items.index') }}" class="text-gray-500 hover:text-indigo-400 font-black uppercase text-[10px] tracking-widest transition">
                    ← Kembali ke Daftar
                </a>
                <div class="flex gap-3">
                    <a href="{{ route('order-items.edit', $orderItem->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-[9px] font-black uppercase tracking-widest transition">
                        Edit Record
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 p-2 bg-emerald-500/10 border border-emerald-500/20 rounded-lg text-emerald-400 text-[9px] font-bold uppercase tracking-widest text-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Kartu Utama --}}
            <div class="bg-black/40 border border-white/10 rounded-3xl p-8 backdrop-blur-md shadow-2xl relative overflow-hidden">
                
                <div class="text-center mb-8">
                    <span class="text-indigo-500 font-black uppercase tracking-[0.3em] text-[9px]">Transaction Details</span>
                    <h1 class="text-4xl font-black uppercase italic tracking-tighter mt-2">ID: #{{ $orderItem->id }}</h1>
                </div>

                <div class="space-y-4">
                    {{-- Baris Data 1 --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                            <h3 class="text-[8px] font-black text-gray-500 uppercase tracking-widest mb-1">Customer Name</h3>
                            <p class="text-xs font-bold uppercase">{{ $orderItem->order->user->name ?? '-' }}</p>
                        </div>
                        <div class="bg-white/5 p-4 rounded-xl border border-white/5 text-right">
                            <h3 class="text-[8px] font-black text-gray-500 uppercase tracking-widest mb-1">Order ID Reference</h3>
                            <p class="text-xs font-black text-indigo-400">ORD-{{ $orderItem->order_id }}</p>
                        </div>
                    </div>

                    {{-- Baris Data 2 --}}
                    <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-[8px] font-black text-gray-500 uppercase tracking-widest mb-1">Ticket Type & Event</h3>
                                <p class="text-xs font-black uppercase italic italic tracking-tighter">{{ $orderItem->ticketType->name ?? '-' }}</p>
                                <p class="text-[9px] font-bold text-gray-500 uppercase">{{ $orderItem->ticketType->event->title ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <h3 class="text-[8px] font-black text-gray-500 uppercase tracking-widest mb-1">Quantity</h3>
                                <p class="text-xl font-black italic">{{ $orderItem->quantity }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Total Banner --}}
                    <div class="bg-indigo-600/10 p-5 rounded-2xl border border-indigo-500/20 text-center">
                        <div class="flex justify-between items-center px-4">
                            <div class="text-left">
                                <h3 class="text-[8px] font-black text-indigo-400 uppercase tracking-widest">Price Unit</h3>
                                <p class="text-xs font-bold italic">Rp {{ number_format($orderItem->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <h3 class="text-[8px] font-black text-indigo-400 uppercase tracking-widest">Grand Total</h3>
                                <p class="text-2xl font-black italic tracking-tighter text-emerald-400">Rp {{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Timestamps --}}
                <div class="mt-8 grid grid-cols-2 gap-4 text-[8px] font-black text-gray-600 uppercase tracking-widest border-t border-white/5 pt-4">
                    <div>
                        <span class="block text-gray-500">Created At</span>
                        <span class="text-white">{{ $orderItem->created_at }}</span>
                    </div>
                    <div class="text-right">
                        <span class="block text-gray-500">Updated At</span>
                        <span class="text-white">{{ $orderItem->updated_at }}</span>
                    </div>
                </div>

                {{-- Tombol Hapus --}}
                <div class="mt-8 flex justify-center">
                    <form action="{{ route('order-items.destroy', $orderItem->id) }}" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus order item ini?')" class="w-full py-3 bg-red-500/5 border border-red-500/20 rounded-xl text-[9px] font-black uppercase text-red-500 tracking-[0.2em] hover:bg-red-500 hover:text-white transition">
                            Hapus Record Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>