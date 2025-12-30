<?php $title = 'Events - WalkAtWallClouds'; ?>
<x-layout :$title>
    <main>
        <h1>Daftar Event WalkAtWallClouds</h1>
        
        <!-- Filter Form untuk User -->
        <div style="border: 1px solid #ccc; padding: 20px; margin-bottom: 20px;">
            <h2>Filter Event</h2>
            <form method="GET" action="{{ route('events.list') }}">
                <table border="0" cellpadding="5">
                    <tr>
                        <td><label>Lokasi:</label></td>
                        <td>
                            <select name="location">
                                <option value="">Semua Lokasi</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                        {{ $location }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Filter Tanggal:</label></td>
                        <td>
                            <select name="date_filter">
                                <option value="">Semua Tanggal</option>
                                <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                                <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                                <option value="upcoming" {{ request('date_filter') == 'upcoming' ? 'selected' : '' }}>Event Mendatang</option>
                                <option value="past" {{ request('date_filter') == 'past' ? 'selected' : '' }}>Event Lewat</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Tanggal Dari:</label></td>
                        <td><input type="date" name="date_from" value="{{ request('date_from') }}"></td>
                    </tr>
                    <tr>
                        <td><label>Tanggal Sampai:</label></td>
                        <td><input type="date" name="date_to" value="{{ request('date_to') }}"></td>
                    </tr>
                    <tr>
                        <td><label>Harga Minimum:</label></td>
                        <td><input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Rp 0"></td>
                    </tr>
                    <tr>
                        <td><label>Harga Maximum:</label></td>
                        <td><input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Rp 1000000"></td>
                    </tr>
                    <tr>
                        <td><label>Urutkan Berdasarkan:</label></td>
                        <td>
                            <select name="sort_by">
                                <option value="event_date" {{ request('sort_by') == 'event_date' ? 'selected' : '' }}>Tanggal Event</option>
                                <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Nama Event</option>
                                <option value="location" {{ request('sort_by') == 'location' ? 'selected' : '' }}>Lokasi</option>
                            </select>
                            <select name="sort_order">
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>A-Z / Terlama</option>
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Z-A / Terbaru</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit">Terapkan Filter</button>
                            <a href="{{ route('events.list') }}">Reset Filter</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <!-- Results Info -->
        <p>Menampilkan {{ $events->count() }} dari {{ $events->total() }} event</p>

        <!-- Event List Table -->
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Poster</th>
                    <th>Judul Event</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Waktu</th>
                    <th>Harga Tiket</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td width="100">
                            @if($event->poster)
                                <img src="{{ $event->poster }}" alt="{{ $event->title }}" width="80">
                            @else
                                <div style="width: 80px; height: 100px; background: #ccc; display: flex; align-items: center; justify-content: center;">
                                    No Image
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $event->title }}</strong>
                            <br>
                            <small>{{ Str::limit($event->description, 100) }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                        <td>{{ $event->location }}</td>
                        <td>{{ $event->start_time }} - {{ $event->end_time }}</td>
                        <td>
                            @php
                                $minPrice = $event->ticketTypes->min('price');
                                $maxPrice = $event->ticketTypes->max('price');
                            @endphp
                            @if($minPrice)
                                Rp {{ number_format($minPrice, 0, ',', '.') }}
                                @if($minPrice != $maxPrice)
                                    - Rp {{ number_format($maxPrice, 0, ',', '.') }}
                                @endif
                            @else
                                Belum Ada Tiket
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('events.show', $event->id) }}">Detail</a>
                            @if($event->ticketTypes->count() > 0)
                                <br>
                                <a href="{{ route('purchase.index') }}">Beli Tiket</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            <p>Tidak ada event yang sesuai dengan filter Anda.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div style="margin-top: 20px;">
            {{ $events->appends(request()->query())->links() }}
        </div>
    </main>
</x-layout>
