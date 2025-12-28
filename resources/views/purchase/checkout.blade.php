<?php $title = 'Checkout'; ?>
<x-layout :$title>
    <script src="https://cdn.tailwindcss.com"></script>

    <main class="bg-gray-900 min-h-screen text-white py-20">
        <div class="max-w-2xl mx-auto px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-black text-white mb-2 uppercase">Checkout</h1>
                <a href="{{ route('purchase.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm">← Kembali ke daftar tiket</a>
            </div>

            <div class="bg-black/50 border border-gray-800 rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600/20 to-purple-600/20 border-b border-gray-800 p-6">
                    <h2 class="text-xl font-black text-indigo-400">{{ $ticketType->name }}</h2>
                    <p class="text-sm text-gray-400">{{ $ticketType->event->title ?? 'Event' }}</p>
                </div>

                <form action="{{ route('checkout.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Ticket Info -->
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-gray-900/50 rounded-xl border border-gray-800">
                            <div>
                                <p class="text-xs text-gray-500 uppercase mb-1">Harga Per Tiket</p>
                                <p class="text-lg font-bold">Rp {{ number_format($ticketType->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 uppercase mb-1">Stok Tersedia</p>
                                <p class="text-lg font-bold text-green-400">{{ $ticketType->quota - $ticketType->sold }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quantity Selection -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-3">Jumlah Tiket</label>
                        <input type="hidden" name="ticket_type_id" value="{{ $ticketType->id }}">
                        
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" max="{{ $ticketType->quota - $ticketType->sold }}" 
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white focus:border-indigo-500 focus:outline-none"
                                    required>
                                @error('quantity')
                                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Maksimal {{ $ticketType->quota - $ticketType->sold }} tiket</p>
                    </div>

                    <!-- Total Price Calculation -->
                    <div class="p-4 bg-indigo-600/10 border border-indigo-600/30 rounded-xl">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-gray-300">Harga Satuan</span>
                            <span class="font-bold">Rp {{ number_format($ticketType->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-gray-300">Jumlah</span>
                            <span class="font-bold" id="quantity-display">1</span>
                        </div>
                        <div class="border-t border-gray-700 pt-3 flex justify-between items-center">
                            <span class="text-lg font-black">Total</span>
                            <span class="text-2xl font-black text-indigo-400" id="total-price">Rp {{ number_format($ticketType->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label class="block text-sm font-bold text-gray-300 mb-3">Metode Pembayaran</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 bg-gray-900/50 border border-gray-800 rounded-xl cursor-pointer hover:border-indigo-500/50 transition">
                                <input type="radio" name="payment_method" value="transfer" checked class="w-5 h-5 text-indigo-600">
                                <span class="ml-3 font-semibold">Transfer Bank</span>
                            </label>
                            <label class="flex items-center p-4 bg-gray-900/50 border border-gray-800 rounded-xl cursor-pointer hover:border-indigo-500/50 transition">
                                <input type="radio" name="payment_method" value="card" class="w-5 h-5 text-indigo-600">
                                <span class="ml-3 font-semibold">Kartu Kredit</span>
                            </label>
                            <label class="flex items-center p-4 bg-gray-900/50 border border-gray-800 rounded-xl cursor-pointer hover:border-indigo-500/50 transition">
                                <input type="radio" name="payment_method" value="e-wallet" class="w-5 h-5 text-indigo-600">
                                <span class="ml-3 font-semibold">E-Wallet (GCash, Dana, etc)</span>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Button -->
                    <div class="flex gap-3">
                        <a href="{{ route('purchase.index') }}" class="flex-1 py-3 bg-gray-800 hover:bg-gray-700 text-white text-center font-bold rounded-xl transition">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition shadow-lg shadow-indigo-500/20 uppercase tracking-wider">
                            Lanjut Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        const quantityInput = document.querySelector('input[name="quantity"]');
        const quantityDisplay = document.getElementById('quantity-display');
        const totalPrice = document.getElementById('total-price');
        const pricePerTicket = parseInt('{{ $ticketType->price }}');

        function updateTotal() {
            const quantity = parseInt(quantityInput.value) || 1;
            const total = quantity * pricePerTicket;
            quantityDisplay.textContent = quantity;
            totalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        quantityInput.addEventListener('change', updateTotal);
        quantityInput.addEventListener('input', updateTotal);
    </script>

</x-layout>
