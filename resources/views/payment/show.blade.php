<?php $title = 'Payment - WalkAtWallClouds'; ?>
<x-layout :$title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 py-12">
        <div class="max-w-2xl mx-auto px-4">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20">
                <h1 class="text-3xl font-bold text-white mb-6">Payment</h1>
                
                <!-- Order Info -->
                <div class="bg-white/5 rounded-lg p-6 mb-6">
                    <p class="text-gray-300 mb-2">Order Code: <span class="text-white font-bold">{{ $order->order_code }}</span></p>
                    <p class="text-gray-300 mb-2">Total Amount: <span class="text-white font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>
                    <p class="text-gray-300">Status: <span class="text-yellow-400 font-bold">{{ ucfirst($payment->status) }}</span></p>
                </div>

                <!-- Items -->
                <div class="bg-white/5 rounded-lg p-6 mb-6">
                    <h3 class="text-white font-bold mb-4">Order Items:</h3>
                    @foreach($order->items as $item)
                    <div class="flex justify-between text-gray-300 mb-2">
                        <span>{{ $item->ticketType->event->title }} - {{ $item->ticketType->name }} (x{{ $item->quantity }})</span>
                        <span class="text-white">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>

                <!-- Payment Button -->
                <button id="pay-button" class="w-full py-4 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold rounded-lg transition transform hover:scale-105">
                    <i class="fa-solid fa-credit-card mr-2"></i>Bayar Sekarang
                </button>

                <p class="text-gray-400 text-sm text-center mt-4">
                    Powered by <span class="text-purple-400 font-bold">Midtrans</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Midtrans Snap.js -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        const payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $payment->snap_token }}', {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    // Tunggu sebentar untuk Midtrans update status
                    setTimeout(() => {
                        // Check status otomatis setelah payment success
                        fetch("{{ route('payment.check-status', $order->id) }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(response => response.json())
                        .then(data => {
                            // Langsung redirect ke my tickets
                            window.location.href = "{{ route('my-tickets.show', $order->id) }}";
                        }).catch(error => {
                            // Tetap redirect meskipun error
                            window.location.href = "{{ route('my-tickets.show', $order->id) }}";
                        });
                    }, 1000); // Tunggu 1 detik
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    // Redirect ke my tickets untuk cek status
                    window.location.href = "{{ route('my-tickets.show', $order->id) }}";
                },
                onError: function(result) {
                    console.log('Payment error:', result);
                    alert('Pembayaran gagal! ' + result.status_message);
                    window.location.href = "{{ route('my-tickets.show', $order->id) }}";
                },
                onClose: function() {
                    console.log('Payment popup closed');
                    // Redirect ke my tickets saat user tutup popup
                    window.location.href = "{{ route('my-tickets.show', $order->id) }}";
                }
            });
        });
    </script>
</x-layout>
