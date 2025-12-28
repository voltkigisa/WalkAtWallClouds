<?php $title = 'Beli Tiket'; ?>
<x-layout :$title>
    <script src="https://cdn.tailwindcss.com"></script>

    <main class="bg-gray-900 min-h-screen text-white py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-black text-white mb-2 tracking-tight uppercase">Beli <span class="text-indigo-500">Tiket</span></h1>
                <p class="text-gray-400">Pilih event dan jenis tiket yang ingin dibeli</p>
            </div>

            @if($events->isEmpty())
                <div class="bg-black/50 border border-gray-800 rounded-2xl p-8 text-center">
                    <p class="text-gray-400">Tidak ada event yang tersedia saat ini.</p>
                </div>
            @else
                @foreach($events as $event)
                <div class="mb-12">
                    <div class="flex items-center gap-4 mb-6">
                        <h2 class="text-2xl font-black text-indigo-400 uppercase">{{ $event->title }}</h2>
                        <div class="h-1 flex-1 bg-gray-800"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($event->ticketTypes as $ticketType)
                            <div class="bg-black/40 border border-gray-800 rounded-2xl overflow-hidden hover:border-indigo-500/50 transition duration-300 group">
                                <div class="p-6">
                                    <h3 class="text-xl font-black text-white mb-2">{{ $ticketType->name }}</h3>
                                    
                                    <div class="bg-gray-900/50 rounded-xl p-4 mb-4">
                                        <p class="text-xs text-gray-500 uppercase mb-1">Harga</p>
                                        <p class="text-2xl font-black text-indigo-400">Rp {{ number_format($ticketType->price, 0, ',', '.') }}</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 mb-6">
                                        <div class="bg-gray-900/50 rounded-lg p-3">
                                            <p class="text-[10px] text-gray-500 uppercase">Quota</p>
                                            <p class="font-bold">{{ $ticketType->quota }}</p>
                                        </div>
                                        <div class="bg-gray-900/50 rounded-lg p-3">
                                            <p class="text-[10px] text-gray-500 uppercase">Tersisa</p>
                                            <p class="font-bold {{ ($ticketType->quota - $ticketType->sold) > 0 ? 'text-green-400' : 'text-red-400' }}">
                                                {{ $ticketType->quota - $ticketType->sold }}
                                            </p>
                                        </div>
                                    </div>

                                    @if(($ticketType->quota - $ticketType->sold) > 0)
                                        <a href="{{ route('purchase.show', $ticketType) }}" class="block w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-center font-black rounded-xl transition duration-300 shadow-lg shadow-indigo-500/20 uppercase tracking-wider">
                                            Beli Sekarang
                                        </a>
                                    @else
                                        <button disabled class="block w-full py-3 bg-gray-700 text-gray-400 text-center font-black rounded-xl cursor-not-allowed uppercase tracking-wider">
                                            Terjual Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-400">
                                <p>Tidak ada tipe tiket untuk event ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </main>

</x-layout>
