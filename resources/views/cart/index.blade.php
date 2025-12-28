@php $title = 'Keranjang Belanja'; @endphp
<x-layout :title="$title">
    <main class="bg-gray-900 min-h-screen text-white py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-12">
                <h1 class="text-4xl font-black text-white mb-2 tracking-tight uppercase">Keranjang <span class="text-indigo-500">Belanja</span></h1>
                <a href="{{ route('purchase.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm">← Lanjut belanja tiket</a>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-600/20 border border-green-600/50 rounded-xl text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-600/20 border border-red-600/50 rounded-xl text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            @if(empty($cart))
                <div class="bg-black/50 border border-gray-800 rounded-2xl p-12 text-center">
                    <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-cart-shopping text-gray-600 text-3xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white mb-2">Keranjang Kosong</h2>
                    <p class="text-gray-400 mb-6">Belum ada tiket di keranjang Anda</p>
                    <a href="{{ route('purchase.index') }}" class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition uppercase">
                        Mulai Belanja
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($cart as $itemId => $item)
                        <div class="bg-black/40 border border-gray-800 rounded-2xl overflow-hidden hover:border-indigo-500/50 transition">
                            <div class="p-6">
                                <div class="flex gap-6">
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <h3 class="text-xl font-black text-white mb-1">{{ $item['name'] }}</h3>
                                                <p class="text-sm text-indigo-400 font-bold">{{ $item['event_title'] }}</p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    <i class="fa-solid fa-calendar mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($item['event_date'])->format('d M Y') }}
                                                </p>
                                            </div>
                                            <form action="{{ route('cart.remove', $itemId) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-400 transition" onclick="return confirm('Hapus tiket ini dari keranjang?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-2xl font-black text-indigo-400">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                                <p class="text-xs text-gray-500">per tiket</p>
                                            </div>

                                            <div class="flex items-center gap-4">
                                                <form action="{{ route('cart.update', $itemId) }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="flex items-center bg-gray-900 rounded-xl border border-gray-800">
                                                        <button type="button" onclick="decrementQty(this)" class="w-10 h-10 text-gray-400 hover:text-white transition">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </button>
                                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="10" 
                                                            class="w-16 text-center bg-transparent text-white font-bold focus:outline-none"
                                                            onchange="this.form.submit()">
                                                        <button type="button" onclick="incrementQty(this)" class="w-10 h-10 text-gray-400 hover:text-white transition">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </form>

                                                <div class="text-right">
                                                    <p class="text-sm text-gray-500">Subtotal</p>
                                                    <p class="text-lg font-black text-white">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <form action="{{ route('cart.clear') }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-500 hover:text-red-400 transition" onclick="return confirm('Kosongkan semua keranjang?')">
                                <i class="fa-solid fa-trash mr-2"></i>Kosongkan Keranjang
                            </button>
                        </form>
                    </div>

                    <!-- Cart Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-black/40 border border-gray-800 rounded-2xl p-6 sticky top-24">
                            <h3 class="text-xl font-black text-white mb-6 uppercase">Ringkasan Belanja</h3>

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
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-black">Total Pembayaran</span>
                                        <span class="text-2xl font-black text-indigo-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('cart.checkout') }}" class="block w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white text-center font-black rounded-xl transition shadow-lg shadow-indigo-500/20 uppercase mb-3">
                                <i class="fa-solid fa-credit-card mr-2"></i>Lanjut ke Pembayaran
                            </a>

                            <a href="{{ route('purchase.index') }}" class="block w-full py-3 bg-gray-800 hover:bg-gray-700 text-white text-center font-bold rounded-xl transition">
                                <i class="fa-solid fa-plus mr-2"></i>Tambah Tiket Lain
                            </a>

                            <div class="mt-6 p-4 bg-indigo-600/10 border border-indigo-600/30 rounded-xl">
                                <p class="text-xs text-gray-400">
                                    <i class="fa-solid fa-shield-halved text-indigo-400 mr-2"></i>
                                    Transaksi Anda aman dan terenkripsi
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <script>
        function decrementQty(btn) {
            const input = btn.parentElement.querySelector('input[type="number"]');
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
                input.form.submit();
            }
        }

        function incrementQty(btn) {
            const input = btn.parentElement.querySelector('input[type="number"]');
            if (input.value < 10) {
                input.value = parseInt(input.value) + 1;
                input.form.submit();
            }
        }
    </script>
</x-layout>
