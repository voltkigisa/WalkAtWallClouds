<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.4; font-size: 11px; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #4f46e5; text-transform: uppercase; font-size: 22px; }
        
        .section-title { font-size: 12px; font-weight: bold; margin: 20px 0 8px 0; text-transform: uppercase; color: #4f46e5; border-left: 4px solid #4f46e5; padding-left: 10px; }
        
        /* Style Tabel */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #e2e8f0; }
        th { background-color: #f1f5f9; padding: 10px; text-align: left; font-size: 10px; color: #475569; text-transform: uppercase; }
        td { padding: 8px; font-size: 11px; }

        /* Khusus Lebar Kolom Statistik */
        .col-category { width: 70%; background-color: #f8fafc; font-weight: bold; }
        .col-value { width: 30%; text-align: center; font-weight: bold; font-size: 12px; }
        
        .footer { margin-top: 30px; text-align: right; font-size: 9px; color: #94a3b8; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>WalkAtWall Clouds</h1>
        <p>Laporan Dashboard Admin | Dicetak: {{ $date }}</p>
    </div>

    <div class="section-title">Ringkasan Statistik Utama</div>
    <table>
        <thead>
            <tr>
                <th style="width: 70%;">Kategori Data</th>
                <th style="width: 30%; text-align: center;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-category">Total Events</td>
                <td class="col-value">{{ $stats['total_events'] }}</td>
            </tr>
            <tr>
                <td class="col-category">Total Artists</td>
                <td class="col-value">{{ $stats['total_artists'] }}</td>
            </tr>
            <tr>
                <td class="col-category">Total Orders</td>
                <td class="col-value">{{ $stats['total_orders'] }}</td>
            </tr>
            <tr>
                <td class="col-category">Total Tickets Habis</td>
                <td class="col-value">{{ $stats['total_tickets'] }}</td>
            </tr>
            <tr>
                <td class="col-category">Total Ticket Types</td>
                <td class="col-value">{{ $stats['total_ticket_types'] }}</td>
            </tr>
            <tr>
                <td class="col-category">Total Users</td>
                <td class="col-value">{{ $stats['total_users'] }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Detail Data: {{ $title }}</div>
    <table>
        <thead>
            @if($type == 'tickets')
                <tr>
                    <th>Nama Tiket</th>
                    <th>Event</th>
                    <th>Harga</th>
                    <th>Kuota</th>
                </tr>
            @else
                <tr>
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tanggal Join</th>
                </tr>
            @endif
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                @if($type == 'tickets')
                    <td><strong>{{ $item->name }}</strong></td>
                    <td>{{ $item->event->title ?? '-' }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->quota }}</td>
                @else
                    <td><strong>{{ $item->name }}</strong></td>
                    <td>{{ $item->email }}</td>
                    <td>{{ strtoupper($item->role ?? 'User') }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh sistem WalkAtWall pada {{ $date }}.
    </div>

</body>
</html>