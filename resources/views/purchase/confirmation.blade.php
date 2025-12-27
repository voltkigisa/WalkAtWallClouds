<?php $title = 'Konfirmasi Order'; ?>
<x-layout :$title>
    <script src="https://cdn.tailwindcss.com"></script>

    <main class="bg-gray-900 min-h-screen text-white py-20">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            <!-- Success Message -->
            <div class="mb-8 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-600/20 border border-green-600 rounded-full mb-4">
                    <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-black text-white mb-2 uppercase">Pesanan Berhasil Dibuat!</h1>
                <p class="text-gray-400">Silahkan lakukan pembayaran untuk mengaktifkan tiket Anda</p>
            </div>

            <!-- Order Details -->
            <div class="bg-black/50 border border-gray-800 rounded-2xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-indigo-600/20 to-purple-600/20 border-b border-gray-800 p-6">
                    <h2 class="text-xl font-black text-indigo-400">Detail Pesanan</h2>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Order Code -->
                    <div class="flex justify-between items-center p-4 bg-gray-900/50 rounded-xl border border-gray-800">
                        <div>
                            <p class="text-xs text-gray-500 uppercase mb-1">Kode Pesanan</p>
                            <p class="text-lg font-black text-indigo-400">{{ $order->order_code }}</p>
                        </div>
                        <button onclick="copyCode('{{ $order->order_code }}')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-sm font-bold transition">
                            Salin
                        </button>
                    </div>

                    <!-- Order Status -->
                    <div class="p-4 bg-yellow-600/10 border border-yellow-600/30 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 6v2m0-20v2m0 4v2M7 9a2 2 0 100-4 2 2 0 000 4zm14 0a2 2 0 100-4 2 2 0 000 4z"></path>
                        </svg>
                        <div>
                            <p class="text-xs text-gray-400 uppercase">Status Pesanan</p>
                            <p class="font-black text-yellow-400">MENUNGGU PEMBAYARAN</p>
                        </div>
                    </div>

                    <!-- Tickets Ordered -->
                    <div>
                        <h3 class="text-lg font-black text-white mb-4">Tiket yang Dipesan</h3>
                        <div class="space-y-3">
                            @foreach($order->items as $item)
                                <div class="p-4 bg-gray-900/50 border border-gray-800 rounded-xl">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <p class="font-black text-white">{{ $item->ticketType->name }}</p>
                                            <p class="text-sm text-gray-400">{{ $item->ticketType->event->title ?? 'Event' }}</p>
                                        </div>
                                        <span class="px-3 py-1 bg-indigo-600/20 text-indigo-400 text-xs font-bold rounded">{{ $item->quantity }}x</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-3 border-t border-gray-800">
                                        <span class="text-gray-400">Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}</span>
                                        <span class="font-black">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <!-- Ticket Codes -->
                                <div class="ml-4 space-y-2">
                                    @foreach($item->tickets as $ticket)
                                        <div class="p-3 bg-gray-950 border border-gray-800 rounded-lg text-xs font-mono">
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-500">Tiket #{{ $loop->iteration }}:</span>
                                                <span class="text-indigo-400 font-bold">{{ $ticket->ticket_code }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="border-t border-gray-800 pt-6">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-black">Total Pembayaran</span>
                            <span class="text-3xl font-black text-indigo-400">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Instructions -->
            <div class="bg-black/50 border border-gray-800 rounded-2xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-indigo-600/20 to-purple-600/20 border-b border-gray-800 p-6">
                    <h2 class="text-xl font-black text-indigo-400">Petunjuk Pembayaran</h2>
                </div>

                <div class="p-6 space-y-4">
                    @if($order->payment)
                        <div class="p-4 bg-gray-900/50 rounded-xl">
                            <p class="text-sm text-gray-400 mb-2">Metode Pembayaran:</p>
                            <p class="font-bold text-white capitalize">
                                {{ str_replace('-', ' ', $order->payment->payment_method) }}
                            </p>
                        </div>
                    @endif

                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-indigo-600/20 border border-indigo-600 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-indigo-400">1</span>
                            </div>
                            <div>
                                <p class="font-bold text-white">Salin Kode Pesanan</p>
                                <p class="text-xs text-gray-400">Gunakan kode <span class="font-mono text-indigo-400">{{ $order->order_code }}</span> sebagai referensi pembayaran</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-indigo-600/20 border border-indigo-600 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-indigo-400">2</span>
                            </div>
                            <div>
                                <p class="font-bold text-white">Lakukan Pembayaran</p>
                                <p class="text-xs text-gray-400">Transfer sejumlah <span class="font-mono text-indigo-400">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span> ke rekening yang telah ditentukan</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-indigo-600/20 border border-indigo-600 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-indigo-400">3</span>
                            </div>
                            <div>
                                <p class="font-bold text-white">Verifikasi Pembayaran</p>
                                <p class="text-xs text-gray-400">Tiket Anda akan otomatis aktif setelah pembayaran dikonfirmasi (biasanya 5-30 menit)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('purchase.index') }}" class="flex-1 py-3 bg-gray-800 hover:bg-gray-700 text-white text-center font-bold rounded-xl transition">
                    Lanjut Belanja Tiket
                </a>
                <a href="/" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-center font-black rounded-xl transition shadow-lg shadow-indigo-500/20 uppercase tracking-wider">
                    Kembali ke Home
                </a>
            </div>
        </div>
    </main>

    <script>
        function copyCode(code) {
            navigator.clipboard.writeText(code).then(() => {
                alert('Kode pesanan berhasil disalin!');
            });
        }
    </script>

</x-layout>
