<x-admin-layout title="Detail Ticket Type - WalkAtWallClouds">
    {{-- Gunakan h-screen dan padding untuk memastikan konten tidak terpotong --}}
    <main class="fixed inset-0 bg-gray-900 flex items-center justify-center ml-64 text-white p-6">
        
        {{-- max-w-lg atau max-w-xl akan membuat lebar kartu lebih ramping --}}
        <div class="max-w-lg w-full">
            
            {{-- Navigasi Atas --}}
            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('ticket-types.index') }}" class="text-gray-500 hover:text-indigo-400 font-black uppercase text-[10px] tracking-widest transition">
                    ← Kembali
                </a>
                <div class="flex gap-2">
                    <a href="{{ route('ticket-types.edit', $ticketType->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-lg text-[9px] font-black uppercase tracking-widest transition">
                        Edit
                    </a>
                </div>
            </div>

            {{-- Kartu Utama dengan padding (p-8) yang lebih ramping agar tidak memakan banyak ruang --}}
            <div class="bg-black/40 border border-white/10 rounded-3xl p-8 backdrop-blur-md shadow-2xl relative overflow-hidden text-center">
                <span class="text-indigo-500 font-black uppercase tracking-[0.3em] text-[9px]">Konfigurasi Tiket</span>
                
                {{-- Ukuran font dikurangi sedikit agar proporsional (text-5xl) --}}
                <h1 class="text-5xl font-black uppercase italic tracking-tighter mt-3 mb-1 leading-none">
                    {{ $ticketType->name }}
                </h1>
                
                <p class="text-gray-500 font-bold uppercase text-[11px] tracking-widest mb-8">
                    Event: <span class="text-white">{{ $ticketType->event->title ?? 'Tidak Ada Event' }}</span>
                </p>

                {{-- Grid Statistik dengan gap yang lebih kecil --}}
                <div class="grid grid-cols-3 gap-3 mb-8">
                    <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                        <h3 class="text-[8px] font-black text-indigo-400 uppercase tracking-widest mb-1">Harga</h3>
                        <p class="text-sm font-black italic">Rp{{ number_format($ticketType->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                        <h3 class="text-[8px] font-black text-gray-500 uppercase tracking-widest mb-1">Kuota</h3>
                        <p class="text-sm font-black italic">{{ $ticketType->quota }}</p>
                    </div>
                    <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                        <h3 class="text-[8px] font-black text-red-400 uppercase tracking-widest mb-1">Terjual</h3>
                        <p class="text-sm font-black italic text-red-400">{{ $ticketType->sold }}</p>
                    </div>
                </div>

                {{-- Kotak Sisa Tiket yang lebih ringkas --}}
                <div class="bg-indigo-600/10 p-5 rounded-2xl border border-indigo-500/20 mb-2">
                    <h3 class="text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-1">Sisa Stok</h3>
                    <p class="text-3xl font-black italic tracking-tighter text-white">
                        {{ $ticketType->quota - $ticketType->sold }} <span class="text-[10px] text-indigo-500 uppercase not-italic">Tiket</span>
                    </p>
                </div>

                {{-- Footer Timestamps --}}
                <div class="mt-8 flex justify-between items-center text-[8px] font-black text-gray-600 uppercase tracking-widest border-t border-white/5 pt-4">
                    <div class="text-left">
                        <span>Dibuat: {{ $ticketType->created_at ? $ticketType->created_at->format('d/m/y') : '-' }}</span>
                    </div>
                    <div class="text-right">
                        <span>Update: {{ $ticketType->updated_at ? $ticketType->updated_at->format('d/m/y H:i') : 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>