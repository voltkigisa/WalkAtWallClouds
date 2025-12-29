@php $title = 'Detail Order - ' . $order->order_code; @endphp
<x-layout :title="$title">
    <main class="bg-gray-900 min-h-screen text-white py-20">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('my-tickets.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm mb-4 inline-block">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Tiket Saya
                </a>
                <h1 class="text-3xl font-black text-white uppercase">Detail Order</h1>
            </div>

            <!-- Order Status -->
            <div class="bg-black/50 border border-gray-800 rounded-2xl overflow-hidden mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-xs text-gray-500 uppercase mb-1">Kode Order</p>
                            <p class="text-2xl font-black text-indigo-400">{{ $order->order_code }}</p>
                        </div>
                        @if($order->payment && $order->payment->status === 'paid')
                            <span class="px-4 py-2 bg-green-600/20 text-green-400 text-sm font-black rounded-full border border-green-600/30 uppercase">
                                <i class="fa-solid fa-check-circle mr-1"></i>Dibayar
                            </span>
                        @else
                            <span class="px-4 py-2 bg-yellow-600/20 text-yellow-400 text-sm font-black rounded-full border border-yellow-600/30 uppercase">
                                <i class="fa-solid fa-clock mr-1"></i>Menunggu Pembayaran
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4 p-4 bg-gray-900/50 rounded-xl">
                        <div>
                            <p class="text-xs text-gray-500 uppercase mb-1">Tanggal Order</p>
                            <p class="font-bold text-white">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase mb-1">Total Pembayaran</p>
                            <p class="text-xl font-black text-indigo-400">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                        @if($order->payment)
                        <div>
                            <p class="text-xs text-gray-500 uppercase mb-1">Metode Pembayaran</p>
                            <p class="font-bold text-white capitalize">{{ str_replace('-', ' ', $order->payment->payment_method) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase mb-1">Status Pembayaran</p>
                            <p class="font-bold {{ $order->payment->status === 'paid' ? 'text-green-400' : 'text-yellow-400' }} capitalize">
                                {{ $order->payment->status }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tickets -->
            <div class="bg-black/50 border border-gray-800 rounded-2xl overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-indigo-600/20 to-purple-600/20 border-b border-gray-800 p-6">
                    <h2 class="text-xl font-black text-indigo-400">Tiket Anda</h2>
                </div>

                <div class="p-6 space-y-6">
                    @foreach($order->items as $item)
                    <div>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 bg-indigo-600/20 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-ticket text-indigo-400 text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xl font-black text-white">{{ $item->ticketType->name }}</p>
                                <p class="text-sm text-indigo-400">{{ $item->ticketType->event->title }}</p>
                                <div class="flex gap-4 mt-2 text-xs text-gray-500">
                                    <span><i class="fa-solid fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($item->ticketType->event->event_date)->format('d F Y') }}</span>
                                    <span><i class="fa-solid fa-map-marker-alt mr-1"></i>{{ $item->ticketType->event->location }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 uppercase">Quantity</p>
                                <p class="text-2xl font-black text-white">{{ $item->quantity }}</p>
                            </div>
                        </div>

                        <!-- Individual Tickets -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ml-4">
                            @foreach($item->tickets as $ticket)
                            <div class="relative p-4 bg-gradient-to-br from-gray-900 to-gray-800 border border-gray-700 rounded-xl overflow-hidden group hover:border-indigo-500/50 transition">
                                <!-- Decorative -->
                                <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-600/5 rounded-full -mr-10 -mt-10"></div>
                                
                                <div class="relative">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xs font-black text-gray-500 uppercase tracking-widest">E-Ticket</span>
                                        @if($ticket->status === 'used')
                                            <span class="px-2 py-1 bg-gray-600/20 text-gray-400 text-[9px] font-black rounded border border-gray-600/30 uppercase">Used</span>
                                        @else
                                            <span class="px-2 py-1 bg-green-600/20 text-green-400 text-[9px] font-black rounded border border-green-600/30 uppercase">Active</span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <p class="text-lg font-black text-white font-mono">{{ $ticket->ticket_code }}</p>
                                    </div>

                                    <!-- QR Code - Using Google Charts API -->
                                    @if($ticket->qr_code)
                                    <div class="w-full aspect-square bg-white rounded-lg flex items-center justify-center mb-3 p-2">
                                        <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ urlencode($ticket->qr_code) }}&choe=UTF-8" 
                                            alt="QR Code" 
                                            class="w-full h-full object-contain">
                                    </div>
                                    @else
                                    <div class="w-full aspect-square bg-white/5 rounded-lg flex items-center justify-center mb-3">
                                        <div class="text-center">
                                            <i class="fa-solid fa-qrcode text-4xl text-gray-700 mb-2"></i>
                                            <p class="text-[10px] text-gray-600 uppercase font-bold">No QR Code</p>
                                        </div>
                                    </div>
                                    @endif
                                    @if($order->payment && $order->payment->status === 'paid')
                                        <div class="flex gap-2">
                                            @if(session()->has('google_access_token'))
                                                <!-- Authorized - Direct add to calendar -->
                                                <form action="{{ route('calendar.add-event') }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <input type="hidden" name="event_title" value="{{ $item->ticketType->event->title }}">
                                                    <input type="hidden" name="event_date" value="{{ $item->ticketType->event->event_date }}">
                                                    <input type="hidden" name="event_location" value="{{ $item->ticketType->event->location }}">
                                                    <input type="hidden" name="ticket_code" value="{{ $ticket->ticket_code }}">
                                                    <button type="submit" class="w-full py-2 bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-400 text-xs font-bold rounded-lg transition border border-indigo-600/30">
                                                        <i class="fa-brands fa-google mr-1"></i>Add to Google Calendar
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Not authorized - Redirect to OAuth -->
                                                <a href="{{ route('google-calendar.auth') }}" class="flex-1 py-2 bg-indigo-600/20 hover:bg-indigo-600/30 text-indigo-400 text-xs font-bold rounded-lg transition border border-indigo-600/30 text-center">
                                                    <i class="fa-brands fa-google mr-1"></i>Connect Google Calendar
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Instructions if Pending -->
            @if($order->payment && $order->payment->status !== 'paid' && $order->payment->status !== 'success')
            <div class="bg-yellow-600/10 border border-yellow-600/30 rounded-2xl p-6">
                <h3 class="text-lg font-black text-yellow-400 mb-4">
                    <i class="fa-solid fa-exclamation-circle mr-2"></i>Menunggu Konfirmasi Pembayaran
                </h3>
                <p class="text-sm text-gray-400 mb-4">
                    Pembayaran Anda sedang diproses. Klik tombol di bawah untuk cek status pembayaran terbaru dari Midtrans atau bayar ulang jika diperlukan.
                </p>
                <div class="flex gap-3">
                    <form action="{{ route('payment.check-status', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-black rounded-xl transition">
                            <i class="fa-solid fa-refresh mr-2"></i>Cek Status Pembayaran
                        </button>
                    </form>
                    
                    <a href="{{ route('payment.create', $order->id) }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl transition inline-block">
                        <i class="fa-solid fa-credit-card mr-2"></i>Bayar Sekarang
                    </a>
                </div>
            </div>
            @endif
        </div>
    </main>

    <script>
        function addToCalendar(title, date, location) {
            // Simple Google Calendar link
            const eventDate = new Date(date);
            const startDate = eventDate.toISOString().replace(/-|:|\.\d\d\d/g,"");
            const endDate = new Date(eventDate.getTime() + (4 * 60 * 60 * 1000)).toISOString().replace(/-|:|\.\d\d\d/g,"");
            
            const googleCalendarUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(title)}&dates=${startDate}/${endDate}&location=${encodeURIComponent(location)}&details=${encodeURIComponent('Tiket event dari WalkAtWallClouds')}`;
            
            window.open(googleCalendarUrl, '_blank');
        }
    </script>
</x-layout>
