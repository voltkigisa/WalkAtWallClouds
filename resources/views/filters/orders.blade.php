<?php $title = 'Orders Filter - WalkAtWallClouds'; ?>
<x-admin-layout :$title>
    <main class="bg-gray-900 min-h-screen text-white py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-10">
                <h1 class="text-4xl font-black uppercase italic tracking-tighter text-white mb-2">Filter Orders</h1>
                <p class="text-gray-500 text-sm font-bold uppercase tracking-widest">Kelola dan filter data pemesanan</p>
            </div>
            
            <!-- Filter Form -->
            <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden mb-10">
                <div class="p-6 border-b border-gray-800">
                    <h2 class="text-lg font-black uppercase italic tracking-tighter text-indigo-400 mb-1">Filter Orders</h2>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Temukan order yang sesuai dengan kriteria</p>
                </div>
                
                <form method="GET" action="{{ route('filters.orders') }}" class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Order Number -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Order Number:</label>
                            <input type="text" name="order_number" value="{{ request('order_number') }}" placeholder="Cari order number..." class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- User -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">User:</label>
                            <select name="user_id" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="">Semua User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Status:</label>
                            <select name="status" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <!-- Payment Status -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Payment Status:</label>
                            <select name="payment_status" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="">Semua Payment Status</option>
                                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>

                        <!-- Filter Tanggal Order -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Tanggal Order:</label>
                            <select name="date_filter" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="">Semua Tanggal</option>
                                <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                                <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                            </select>
                        </div>

                        <!-- Tanggal Dari -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Tanggal Dari:</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Tanggal Sampai -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Tanggal Sampai:</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Total Amount Minimum -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Total Minimum:</label>
                            <input type="number" name="amount_min" value="{{ request('amount_min') }}" placeholder="Rp 0" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Total Amount Maximum -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Total Maximum:</label>
                            <input type="number" name="amount_max" value="{{ request('amount_max') }}" placeholder="Rp 10000000" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                        </div>

                        <!-- Urutkan Berdasarkan -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Urutkan Berdasarkan:</label>
                            <select name="sort_by" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal Order</option>
                                <option value="order_number" {{ request('sort_by') == 'order_number' ? 'selected' : '' }}>Order Number</option>
                                <option value="total_amount" {{ request('sort_by') == 'total_amount' ? 'selected' : '' }}>Total Amount</option>
                            </select>
                        </div>

                        <!-- Urutan -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Urutan:</label>
                            <select name="sort_order" class="w-full bg-gray-900 border border-gray-800 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-indigo-500 transition">
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Terlama / Terendah</option>
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Terbaru / Tertinggi</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 mt-6">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-indigo-600/20 flex items-center gap-2">
                            <i class="fa-solid fa-filter"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('filters.orders') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition flex items-center gap-2">
                            <i class="fa-solid fa-rotate-right"></i> Reset Filter
                        </a>
                    </div>
                </form>
            </div>

            <!-- Results Info -->
            <div class="mb-6">
                <p class="text-gray-400 text-sm font-bold">Menampilkan <span class="text-indigo-400 font-black">{{ $orders->count() }}</span> dari <span class="text-indigo-400 font-black">{{ $orders->total() }}</span> orders</p>
            </div>

            <!-- Orders Table -->
            <div class="bg-black rounded-3xl border border-gray-800 shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-900/50 text-[10px] text-gray-500 font-black uppercase tracking-widest">
                                <th class="p-5">Order Details</th>
                                <th class="p-5 text-center">User</th>
                                <th class="p-5 text-center">Status</th>
                                <th class="p-5 text-center">Payment</th>
                                <th class="p-5 text-center">Total</th>
                                <th class="p-5 text-center">Date</th>
                                <th class="p-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($orders as $order)
                            <tr class="border-t border-gray-800 hover:bg-indigo-500/5 transition duration-300">
                                <td class="p-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg bg-indigo-600/20 flex items-center justify-center">
                                            <i class="fa-solid fa-receipt text-indigo-400"></i>
                                        </div>
                                        <div>
                                            <p class="font-black text-white font-mono">{{ $order->order_number }}</p>
                                            <p class="text-xs text-gray-500">{{ $order->orderItems->count() }} items</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-center text-xs text-gray-400">{{ $order->user->name ?? '-' }}</td>
                                <td class="p-5 text-center">
                                    @if($order->status === 'completed')
                                        <span class="px-3 py-1 bg-green-500/10 text-green-400 text-[9px] font-black rounded-full border border-green-500/20 uppercase tracking-widest">Completed</span>
                                    @elseif($order->status === 'cancelled')
                                        <span class="px-3 py-1 bg-red-500/10 text-red-400 text-[9px] font-black rounded-full border border-red-500/20 uppercase tracking-widest">Cancelled</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-500/10 text-gray-400 text-[9px] font-black rounded-full border border-gray-500/20 uppercase tracking-widest">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td class="p-5 text-center">
                                    @if($order->payment_status === 'paid')
                                        <span class="px-3 py-1 bg-green-500/10 text-green-400 text-[9px] font-black rounded-full border border-green-500/20 uppercase tracking-widest">Paid</span>
                                    @elseif($order->payment_status === 'refunded')
                                        <span class="px-3 py-1 bg-yellow-500/10 text-yellow-400 text-[9px] font-black rounded-full border border-yellow-500/20 uppercase tracking-widest">Refunded</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-500/10 text-red-400 text-[9px] font-black rounded-full border border-red-500/20 uppercase tracking-widest">Unpaid</span>
                                    @endif
                                </td>
                                <td class="p-5 text-center text-xs font-bold text-indigo-300">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="p-5 text-center text-xs font-mono text-gray-400">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                <td class="p-5">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('orders.show', $order->id) }}" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg text-xs font-black uppercase tracking-widest transition border border-gray-700">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('orders.edit', $order->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-black uppercase tracking-widest transition">
                                            <i class="fa-solid fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="border-t border-gray-800">
                                <td colspan="7" class="p-12 text-center text-gray-500">
                                    <i class="fa-solid fa-inbox text-5xl mb-4 opacity-20"></i>
                                    <p class="text-sm font-bold uppercase">Tidak ada order yang sesuai dengan filter Anda.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    </main>
</x-admin-layout>
