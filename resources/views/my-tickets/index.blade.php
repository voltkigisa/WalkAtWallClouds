@php $title = 'Tiket Saya'; @endphp
<x-layout :title="$title">
    <main class="bg-gray-900 min-h-screen text-white py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-12">
                <h1 class="text-4xl font-black text-white mb-2 tracking-tight uppercase">Tiket <span class="text-indigo-500">Saya</span></h1>
                <p class="text-gray-400">Kelola dan lihat semua tiket yang Anda beli</p>
            </div>

            @if($orders->isEmpty())
                <div class="bg-black/50 border border-gray-800 rounded-2xl p-12 text-center">
                    <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-ticket text-gray-600 text-3xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white mb-2">Belum Ada Tiket</h2>
                    <p class="text-gray-400 mb-6">Anda belum membeli tiket apapun</p>
                    <a href="{{ route('purchase.index') }}" class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition uppercase">
                        Beli Tiket Sekarang
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($orders as $order)
                    <div class="bg-black/40 border border-gray-800 rounded-2xl overflow-hidden hover:border-indigo-500/50 transition">
                        <div class="p-6">
                            <!-- Order Header -->
                            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 pb-6 border-b border-gray-800">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase mb-1">Kode Order</p>
                                    <p class="text-lg font-black text-indigo-400">{{ $order->order_code }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fa-solid fa-calendar mr-1"></i>
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                                <div class="mt-4 md:mt-0 flex flex-col items-start md:items-end gap-2">
                                    @if($order->payment && $order->payment->status === 'paid')
                                        <span class="px-4 py-2 bg-green-600/20 text-green-400 text-xs font-black rounded-full border border-green-600/30 uppercase">
                                            <i class="fa-solid fa-check-circle mr-1"></i>Dibayar
                                        </span>
                                    @elseif($order->status === 'cancelled')
                                        <span class="px-4 py-2 bg-red-600/20 text-red-400 text-xs font-black rounded-full border border-red-600/30 uppercase">
                                            <i class="fa-solid fa-times-circle mr-1"></i>Dibatalkan
                                        </span>
                                    @else
                                        <span class="px-4 py-2 bg-yellow-600/20 text-yellow-400 text-xs font-black rounded-full border border-yellow-600/30 uppercase">
                                            <i class="fa-solid fa-clock mr-1"></i>Menunggu Pembayaran
                                        </span>
                                    @endif
                                    <p class="text-xl font-black text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="space-y-4 mb-6">
                                @foreach($order->items as $item)
                                <div class="flex items-center gap-4 p-4 bg-gray-900/50 rounded-xl">
                                    <div class="w-12 h-12 bg-indigo-600/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fa-solid fa-ticket text-indigo-400 text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-black text-white">{{ $item->ticketType->name }}</p>
                                        <p class="text-sm text-indigo-400">{{ $item->ticketType->event->title }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="fa-solid fa-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($item->ticketType->event->event_date)->format('d F Y') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Quantity</p>
                                        <p class="text-lg font-black text-white">{{ $item->quantity }}x</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3">
                                <a href="{{ route('my-tickets.show', $order->id) }}" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-center font-black rounded-xl transition uppercase">
                                    <i class="fa-solid fa-eye mr-2"></i>Lihat Detail
                                </a>
                                @if($order->payment && $order->payment->status === 'paid')
                                    <a href="{{ route('my-tickets.download', $order->id) }}" 
                                       target="_blank"
                                       class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-xl transition inline-flex items-center">
                                        <i class="fa-solid fa-download mr-2"></i>Download Tiket
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($orders->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="flex gap-2">
                        @if ($orders->onFirstPage())
                            <span class="px-4 py-2 bg-white/5 text-gray-600 rounded-xl text-xs font-bold uppercase cursor-not-allowed">Previous</span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}" class="px-4 py-2 bg-white/5 hover:bg-indigo-600 text-gray-400 hover:text-white rounded-xl text-xs font-bold uppercase transition">Previous</a>
                        @endif

                        @foreach ($orders->links()->elements[0] as $page => $url)
                            @if ($page == $orders->currentPage())
                                <span class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-2 bg-white/5 hover:bg-indigo-600 text-gray-400 hover:text-white rounded-xl text-xs font-bold transition">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" class="px-4 py-2 bg-white/5 hover:bg-indigo-600 text-gray-400 hover:text-white rounded-xl text-xs font-bold uppercase transition">Next</a>
                        @else
                            <span class="px-4 py-2 bg-white/5 text-gray-600 rounded-xl text-xs font-bold uppercase cursor-not-allowed">Next</span>
                        @endif
                    </div>
                </div>
                @endif
            @endif
        </div>
    </main>
</x-layout>
