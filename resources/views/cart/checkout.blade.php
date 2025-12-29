@php $title = 'Checkout - Pembayaran'; @endphp
<x-layout :title="$title">
    <main class="bg-gray-900 min-h-screen text-white py-20">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-black text-white mb-2 uppercase">Checkout</h1>
                <a href="{{ route('cart.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm">← Kembali ke keranjang</a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Summary -->
                <div class="lg:col-span-2">
                    <div class="bg-black/50 border border-gray-800 rounded-2xl overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-indigo-600/20 to-purple-600/20 border-b border-gray-800 p-6">
                            <h2 class="text-xl font-black text-indigo-400">Tiket yang Dibeli</h2>
                        </div>

                        <div class="p-6 space-y-4">
                            @foreach($cart as $item)
                            <div class="p-4 bg-gray-900/50 border border-gray-800 rounded-xl">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-black text-white">{{ $item['name'] }}</p>
                                        <p class="text-sm text-indigo-400">{{ $item['event_title'] }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <i class="fa-solid fa-calendar mr-1"></i>
                                            {{ \Carbon\Carbon::parse($item['event_date'])->format('d F Y') }}
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 bg-indigo-600/20 text-indigo-400 text-xs font-bold rounded">{{ $item['quantity'] }}x</span>
                                </div>
                                <div class="flex justify-between items-center pt-3 border-t border-gray-800 gap-4">
                                    <span class="text-gray-400 text-sm">Rp {{ number_format($item['price'], 0, ',', '.') }} × {{ $item['quantity'] }}</span>
                                    <span class="font-black text-right whitespace-nowrap">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment Method Form -->
                    <div class="bg-black/50 border border-gray-800 rounded-2xl overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-600/20 to-purple-600/20 border-b border-gray-800 p-6">
                            <h2 class="text-xl font-black text-indigo-400">Metode Pembayaran</h2>
                        </div>

                        <form action="{{ route('checkout.store') }}" method="POST" class="p-6">
                            @csrf

                            <div class="space-y-3 mb-6">
                                <label class="flex items-center p-4 bg-gray-900/50 border border-gray-800 rounded-xl cursor-pointer hover:border-indigo-500/50 transition group">
                                    <input type="radio" name="payment_method" value="transfer" checked class="w-5 h-5 text-indigo-600">
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-indigo-600/20 rounded-lg flex items-center justify-center">
                                                <i class="fa-solid fa-building-columns text-indigo-400"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-white group-hover:text-indigo-400 transition">Transfer Bank</p>
                                                <p class="text-xs text-gray-500">BCA, Mandiri, BNI, BRI</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 bg-gray-900/50 border border-gray-800 rounded-xl cursor-pointer hover:border-indigo-500/50 transition group">
                                    <input type="radio" name="payment_method" value="card" class="w-5 h-5 text-indigo-600">
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-indigo-600/20 rounded-lg flex items-center justify-center">
                                                <i class="fa-solid fa-credit-card text-indigo-400"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-white group-hover:text-indigo-400 transition">Kartu Kredit/Debit</p>
                                                <p class="text-xs text-gray-500">Visa, Mastercard, JCB</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 bg-gray-900/50 border border-gray-800 rounded-xl cursor-pointer hover:border-indigo-500/50 transition group">
                                    <input type="radio" name="payment_method" value="e-wallet" class="w-5 h-5 text-indigo-600">
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-indigo-600/20 rounded-lg flex items-center justify-center">
                                                <i class="fa-solid fa-wallet text-indigo-400"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-white group-hover:text-indigo-400 transition">E-Wallet</p>
                                                <p class="text-xs text-gray-500">GoPay, OVO, Dana, ShopeePay</p>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            @error('payment_method')
                                <p class="text-red-400 text-xs mb-4">{{ $message }}</p>
                            @enderror

                            <div class="flex gap-3">
                                <a href="{{ route('cart.index') }}" class="flex-1 py-3 bg-gray-800 hover:bg-gray-700 text-white text-center font-bold rounded-xl transition">
                                    Kembali
                                </a>
                                <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition shadow-lg shadow-indigo-500/20 uppercase">
                                    Proses Pembayaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-black/40 border border-gray-800 rounded-2xl p-6 sticky top-24">
                        <h3 class="text-lg font-black text-white mb-6 uppercase">Ringkasan</h3>

                        <div class="space-y-3 mb-6">
                            @php $itemCount = 0; @endphp
                            @foreach($cart as $item)
                                @php $itemCount += $item['quantity']; @endphp
                            @endforeach

                            <div class="flex justify-between text-gray-400">
                                <span>Total Item</span>
                                <span class="font-bold">{{ $itemCount }} tiket</span>
                            </div>

                            <div class="border-t border-gray-800 pt-3">
                                <div class="flex justify-between items-center mb-2 gap-4">
                                    <span class="text-lg font-black">Total</span>
                                    <span class="text-2xl font-black text-indigo-400 whitespace-nowrap">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-indigo-600/10 border border-indigo-600/30 rounded-xl">
                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-info text-indigo-400 mt-1"></i>
                                <div>
                                    <p class="text-sm text-indigo-400 font-bold">Pastikan data sudah benar sebelum melanjutkan ke pembayaran. Setelah pembayaran berhasil, tiket akan dikirim ke email Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
