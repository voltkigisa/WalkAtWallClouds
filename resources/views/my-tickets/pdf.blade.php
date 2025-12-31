<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        /* Setup Halaman */
        @page { 
            margin: 0px; 
        }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #ffffff; 
            color: #ffffff;
        }

        /* Container Tiket */
        .ticket-card {
            width: 550pt;
            height: 220pt;
            margin: 20pt auto;
            position: relative;
            background-color: #0f172a; 
            border-radius: 12pt;
            overflow: hidden;
            border: 1px solid #1e293b;
        }

        .main-content {
            width: 380pt;
            height: 220pt;
            float: left;
            padding: 22pt 25pt;
            box-sizing: border-box;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        }

        .stub-content {
            width: 170pt;
            height: 220pt;
            float: right;
            background-color: #4f46e5; 
            border-left: 3px dashed #030712;
            text-align: center;
            padding: 20pt;
            box-sizing: border-box;
        }

        /* Tipografi */
        .badge {
            display: inline-block;
            padding: 3pt 8pt;
            background: rgba(79, 70, 229, 0.2);
            border: 1px solid #6366f1;
            color: #a5b4fc;
            font-size: 7pt;
            font-weight: bold;
            border-radius: 50pt;
            text-transform: uppercase;
            margin-bottom: 8pt;
        }

        .event-title {
            font-size: 20pt;
            font-weight: 900;
            margin: 2pt 0;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: -1pt;
            line-height: 1.1;
        }

        .event-subtitle {
            font-size: 10pt;
            color: #818cf8;
            font-weight: bold;
            margin-bottom: 12pt;
        }

        /* Tabel Info */
        .info-grid {
            width: 100%;
            margin-top: 10pt;
        }
        .info-label {
            font-size: 6pt;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1pt;
        }
        .info-value {
            font-size: 10pt;
            font-weight: bold;
            color: #f1f5f9;
        }

        /* Instruksi Tambahan */
        .entry-instruction {
            margin-top: 18pt;
            font-size: 7.5pt;
            color: #6366f1;
            font-style: italic;
            border-top: 1px solid rgba(148, 163, 184, 0.1);
            padding-top: 8pt;
        }

        /* QR & Stub */
        .qr-box {
            background: white;
            width: 90pt;
            height: 90pt;
            margin: 12pt auto;
            padding: 6pt;
            border-radius: 6pt;
        }
        .qr-inner {
            border: 1px solid #eee;
            width: 100%;
            height: 100%;
            line-height: 75pt;
            color: #bbb;
            font-size: 7pt;
        }

        /* Kode Order Diperkecil */
        .order-code {
            font-family: monospace;
            font-size: 9pt; /* Ukuran lebih kecil sesuai request */
            color: #ffffff;
            font-weight: bold;
            letter-spacing: 0.5pt;
            background: rgba(0,0,0,0.2);
            padding: 2pt 6pt;
            border-radius: 4pt;
            display: inline-block;
        }

        .gate-info {
            font-size: 7.5pt;
            margin-top: 22pt;
            color: #e0e7ff;
            text-transform: uppercase;
            font-weight: bold;
        }

        /* Lingkaran Dekorasi Potongan */
        .cut-top, .cut-bottom {
            position: absolute;
            left: 371pt;
            width: 18pt;
            height: 18pt;
            background-color: #ffffff; /* Sesuai background body */
            border-radius: 50%;
            z-index: 10;
        }
        .cut-top { top: -9pt; }
        .cut-bottom { bottom: -9pt; }

        .page-break { page-break-after: always; }
    </style>
</head>
<body>

@foreach($order->items as $item)
    @for($i = 1; $i <= $item->quantity; $i++)
    <div class="ticket-card">
        <div class="cut-top"></div>
        <div class="cut-bottom"></div>

        <div class="main-content">
            <div class="badge">Official Admission</div>
            <div class="event-title">{{ $item->ticketType->event->title }}</div>
            <div class="event-subtitle">{{ $item->ticketType->name }} Class</div>
            
            <table class="info-grid" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="50%">
                        <div class="info-label">Guest Name</div>
                        <div class="info-value">{{ $order->user->name }}</div>
                    </td>
                    <td>
                        <div class="info-label">Date & Time</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($item->ticketType->event->event_date)->format('d M Y, H:i') }}</div>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 12pt;">
                        <div class="info-label">Venue</div>
                        <div class="info-value">{{ $item->ticketType->event->location ?? 'Main Stadium Area' }}</div>
                    </td>
                    <td style="padding-top: 12pt;">
                        <div class="info-label">Ticket No.</div>
                        <div class="info-value">#{{ $order->order_code }}-{{ $i }}</div>
                    </td>
                </tr>
            </table>

            <div class="entry-instruction">
                <i class="fa-solid fa-info-circle"></i> Tunjukkan e-tiket ini di pintu masuk untuk discan. Harap bawa kartu identitas yang berlaku.
            </div>
        </div>

        <div class="stub-content">
            <div style="font-size: 7pt; color: #e0e7ff; font-weight: bold; letter-spacing: 1pt;">SCAN DISINI</div>
            <div class="qr-box">
                <div class="qr-inner">
                    <div style="padding: 2px;">
                        <small style="color: #999; font-weight: bold;">QR CODE </small>
                    </div>
                </div>
            </div>
            <div class="order-code">{{ $order->order_code }}</div>

        </div>
    </div>
    <div class="page-break"></div>
    @endfor
@endforeach

</body>
</html>