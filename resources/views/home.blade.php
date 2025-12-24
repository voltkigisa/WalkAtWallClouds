<?php $title = 'Home - WalkAtWallClouds'; ?>
<x-layout :$title>
    <script src="https://cdn.tailwindcss.com"></script>

    <main class="bg-gray-900 min-h-screen text-white">
        <section id="home" class="relative max-w-7xl mx-auto px-6 py-12 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                
                <div class="w-full lg:w-1/3 text-center lg:text-left z-10">
                    <span class="inline-block px-3 py-1 text-xs font-semibold tracking-wider text-indigo-400 uppercase bg-indigo-400/10 rounded-full mb-4">
                        Music Festival 2025
                    </span>
                    <div id="text-carousel-info">
                        <h1 class="text-4xl md:text-6xl font-black text-white mb-6 leading-tight uppercase tracking-tighter" id="slide-title">
                            Experience the <span class="text-indigo-500">Clouds</span> of Sound.
                        </h1>
                        <p class="text-gray-400 text-lg mb-8 max-w-2xl" id="slide-desc">
                            Bergabunglah dalam perayaan musik terbesar tahun ini di WalkAtWallClouds. Menghadirkan legenda dan talenta terbaik.
                        </p>
                    </div>
                    
                     <div class="flex flex-wrap justify-center md:justify-start gap-4">
                            <div class="bg-black/50 border border-white/10 p-4 rounded-xl min-w-[140px]">
                                <p class="text-indigo-400 font-bold">DATE</p>
                                <p class="text-white">20 Feb 2025</p>
                            </div>
                            <div class="bg-black/50 border border-white/10 p-4 rounded-xl min-w-[140px]">
                                <p class="text-indigo-400 font-bold">LOCATION</p>
                                <p class="text-white">Senayan, Jakarta</p>
                            </div>
                        </div>

                    <div class="mt-10 h-[2px] w-full bg-gray-800 hidden lg:block">
                        <div id="progress-bar" class="h-full bg-white w-0 transition-all"></div>
                    </div>
                </div>

                <div class="w-full lg:w-2/3 relative">
                    <div class="relative overflow-hidden rounded-3xl aspect-[16/9] shadow-2xl border border-white/10">
                        <div id="carousel" class="flex transition-transform duration-700 ease-in-out h-full">
                            <div class="min-w-full h-full relative">
                                <img src="{{ asset('images/dewa-19.jpeg') }}" class="w-full h-full object-cover" alt="dewa-19">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                                
                            </div>
                            <div class="min-w-full h-full relative">
                                <img src="{{ asset('images/panturas.jpeg') }}" class="w-full h-full object-cover" alt="The Panturas">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                                
                            </div>
                            <div class="min-w-full h-full relative">
                                <img src="{{ asset('images/perunggu.jpeg') }}" class="w-full h-full object-cover" alt="Perunggu">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                                
                            </div>

                            <div class="min-w-full h-full relative">
                                <img src="{{ asset('images/juicy.jpg') }}" class="w-full h-full object-cover" alt="juicy luicy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                                
                            </div>
                        </div>

                        <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/20 hover:bg-black/50 text-white p-2 rounded-full backdrop-blur-sm transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/20 hover:bg-black/50 text-white p-2 rounded-full backdrop-blur-sm transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

            </div>
        </section>

        <section class="py-20 bg-black/20">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <section id="guest-star" class="py-20scroll-mt-20">
                     <div class="mb-12 text-center">
                    <h2 class="text-3xl font-bold text-white mb-2 tracking-tight">GUEST STAR LINE-UP</h2>
                    <div class="h-1 w-20 bg-indigo-500 mx-auto"></div>
                </div>
                </section>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @php
                        $stars = [
                            ['name' => 'DEWA 19', 'img' => 'dewa-19.jpeg', 'tag' => 'Main Headliner'],
                            ['name' => 'THE PANTURAS', 'img' => 'panturas.jpeg', 'tag' => 'Special Performance'],
                            ['name' => 'PERUNGGU', 'img' => 'perunggu.jpeg', 'tag' => 'Indie Rock'],
                            ['name' => 'JUICY LUICY', 'img' => 'juicy.jpg', 'tag' => 'Pop Jazz'],
                        ];
                    @endphp

                    @foreach($stars as $star)
                    <div class="group cursor-pointer">
                        <div class="relative overflow-hidden rounded-2xl bg-gray-800 aspect-[3/4] mb-4">
                            <img src="{{ asset('images/'.$star['img']) }}" alt="{{ $star['name'] }}" class="h-full w-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-110 transition duration-500">
                            <div class="absolute top-3 right-3 bg-black/60 backdrop-blur-md px-3 py-1 rounded text-[10px] font-bold">
                                {{ $star['tag'] }}
                            </div>
                        </div>
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider">{{ $star['name'] }}</h3>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="ticket" class="py-20 bg-gray-900 scroll-mt-24">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-white mb-2 tracking-tight uppercase">Get Your Tickets</h2>
                    <div class="h-1 w-20 bg-indigo-500"></div>
                </div>

                <div class="flex flex-col lg:flex-row gap-12 items-start">
                    <div class="w-full lg:w-3/5 bg-black/40 p-4 rounded-3xl border border-white/5 shadow-2xl">
                        <div class="relative overflow-hidden rounded-2xl group">
                            <img src="{{ asset('images/seat-map.jpg') }}" alt="Festival Seat Map" class="w-full h-auto object-cover group-hover:scale-105 transition duration-700">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end p-6">
                                <p class="text-xs text-gray-400 italic">*Peta ini hanya ilustrasi estimasi jarak panggung</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-2/5 space-y-6">
                        <div class="bg-black/50 p-6 rounded-2xl border border-white/10">
                            <h3 class="text-xl font-bold text-white mb-6 uppercase">Ticket Categories</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl border border-indigo-500/30">
                                    <div>
                                        <h4 class="text-lg font-bold text-white">CAT 1 (Standing)</h4>
                                    </div>
                                    <p class="text-white font-black text-lg">Rp 1.000.000</p>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-gray-800/30 rounded-xl border border-white/5">
                                    <div>
                                        <h4 class="text-lg font-bold text-white">CAT 2 (Standing)</h4>
                                    </div>
                                    <p class="text-white font-black text-lg">Rp 700.000</p>
                                </div>

                                <div class="flex items-center justify-between p-4 bg-gray-800/30 rounded-xl border border-white/5">
                                    <div>
                                        <h4 class="text-lg font-bold text-white">CAT 3 (Standing)</h4>
                                    </div>
                                    <p class="text-white font-black text-lg">Rp 500.000</p>
                                </div>
                            </div>

                            <div class="mt-8">
                                <a href="/ticket" class="block w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white text-center font-black rounded-xl transition duration-300 shadow-lg shadow-indigo-500/20 uppercase tracking-widest">
                                    Beli Tiket Sekarang
                                </a>
                                <p class="text-center text-gray-500 text-[10px] mt-4 uppercase">Harga belum termasuk pajak & biaya layanan</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-black/30 rounded-xl border border-white/5">
                                <h5 class="text-indigo-400 font-bold text-xs uppercase mb-1">Max Capacity</h5>
                                <p class="text-white text-sm">15.000 People</p>
                            </div>
                            <div class="p-4 bg-black/30 rounded-xl border border-white/5">
                                <h5 class="text-indigo-400 font-bold text-xs uppercase mb-1">Gate Open</h5>
                                <p class="text-white text-sm">15:00 WIB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                background: '#111827', 
                color: '#ffffff',
                showConfirmButton: false,
                timer: 2500, 
                timerProgressBar: true,
            });
        });
    </script>
    @endif
</body>
    </main>
    @push('scripts')
        @vite(['resources/js/carousel.js'])
    @endpush
</x-layout>