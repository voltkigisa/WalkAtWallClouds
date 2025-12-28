<x-admin-layout title="Daftar Order Item - WalkAtWallClouds">
    <main class="fixed inset-0 bg-gray-900 flex items-center justify-center ml-64 text-white p-6">
        <div class="max-w-5xl w-full">
            
            {{-- Header & Tombol Tambah --}}
            <div class="flex justify-between items-end mb-6">
                <div>
                    <h1 class="text-3xl font-black uppercase tracking-tighter italic">Order <span class="text-indigo-500">Log</span></h1>
                    <p class="text-gray-500 text-[10px] uppercase tracking-[0.2em] font-bold">Transaction History Records</p>
                </div>
                <a href="{{ route('order-items.create') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-[10px] font-black uppercase tracking-widest transition shadow-lg shadow-indigo-500/20">
                    + Tambah Order Baru
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-[10px] font-bold uppercase tracking-widest text-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Container Tabel --}}
            <div class="bg-black/40 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-md shadow-2xl">
                <div class="max-h-[500px] overflow-y-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/10 text-[9px] font-black uppercase tracking-widest text-indigo-400 sticky top-0 z-10">
                                <th class="p-4">ID / Order ID</th>
                                <th class="p-4">Customer</th>
                                <th class="p-4">Ticket Type</th>
                                <th class="p-4 text-center">Qty</th>
                                <th class="p-4 text-right">Total</th>
                                <th class="p-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($orderItems as $orderItem)
                                <tr class="hover:bg-white/[0.02] transition group">
                                    <td class="p-4">
                                        <div class="text-[10px] text-gray-500 font-bold">#{{ $orderItem->id }}</div>
                                        <div class="text-xs font-black text-indigo-300 italic">ORD-{{ $orderItem->order_id }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-xs font-bold uppercase">{{ $orderItem->order->user->name ?? '-' }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-xs font-black uppercase italic tracking-tighter">{{ $orderItem->ticketType->name ?? '-' }}</div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="bg-white/5 px-2 py-1 rounded-md text-[10px] font-black italic">{{ $orderItem->quantity }}</span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <div class="text-xs font-black text-emerald-400 italic">Rp {{ number_format($orderItem->price * $orderItem->quantity, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('order-items.show', $orderItem->id) }}" class="px-2.5 py-1 bg-gray-800/50 hover:bg-gray-700 text-[9px] font-black uppercase text-gray-400 hover:text-white transition rounded-lg whitespace-nowrap">View</a>
                                            <a href="{{ route('order-items.edit', $orderItem->id) }}" class="px-2.5 py-1 bg-indigo-600/20 hover:bg-indigo-600/30 text-[9px] font-black uppercase text-indigo-400 hover:text-indigo-300 transition rounded-lg whitespace-nowrap">Edit</a>
                                            <form action="{{ route('order-items.destroy', $orderItem->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Yakin ingin menghapus order item ini?')" class="px-2.5 py-1 bg-red-500/10 hover:bg-red-500/20 text-[9px] font-black uppercase text-red-500/70 hover:text-red-500 transition rounded-lg whitespace-nowrap">Del</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-10 text-center text-gray-600 uppercase font-black italic tracking-widest text-xs">
                                        Tidak ada data order item ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                <a href="/admin/dashboard" class="text-[10px] font-black uppercase text-gray-500 hover:text-indigo-400 tracking-widest transition">
                    ← Kembali ke Dashboard
                </a>
            </div>
        </div>
    </main>
</x-admin-layout>