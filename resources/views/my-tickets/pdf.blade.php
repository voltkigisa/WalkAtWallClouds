<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>E-Ticket</title>
    <style>
        @page { 
            margin: 0px; 
        }
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #ffffff; 
            color: #000000;
        }

        .ticket-card {
            width: 550pt;
            height: 220pt;
            margin: 20pt auto;
            position: relative;
            background-color: #0f172a; 
            border: 2px solid #1e293b;
        }

        .main-content {
            width: 380pt;
            height: 220pt;
            float: left;
            padding: 22pt 25pt;
            background-color: #0f172a;
        }

        .stub-content {
            width: 170pt;
            height: 220pt;
            float: right;
            background-color: #4f46e5; 
            border-left: 3px dashed #030712;
            text-align: center;
            padding: 20pt;
        }

        .badge {
            display: inline-block;
            padding: 3pt 8pt;
            background-color: #4f46e5;
            border: 1px solid #6366f1;
            color: #a5b4fc;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8pt;
        }

        .event-title {
            font-size: 20pt;
            font-weight: bold;
            margin: 2pt 0;
            color: #ffffff;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .event-subtitle {
            font-size: 10pt;
            color: #818cf8;
            font-weight: bold;
            margin-bottom: 12pt;
        }

        .info-grid {
            width: 100%;
            margin-top: 10pt;
        }
        .info-label {
            font-size: 7pt;
            color: #94a3b8;
            text-transform: uppercase;
        }
        .info-value {
            font-size: 10pt;
            font-weight: bold;
            color: #f1f5f9;
        }

        .entry-instruction {
            margin-top: 18pt;
            font-size: 7.5pt;
            color: #6366f1;
            border-top: 1px solid #94a3b8;
            padding-top: 8pt;
        }

        .qr-box {
            background-color: #ffffff;
            width: 90pt;
            height: 90pt;
            margin: 12pt auto;
            padding: 6pt;
            border: 1px solid #cccccc;
        }
        .qr-inner {
            border: 1px solid #eeeeee;
            width: 100%;
            height: 100%;
            line-height: 75pt;
            color: #bbbbbb;
            font-size: 7pt;
            text-align: center;
        }

        .order-code {
            font-family: monospace;
            font-size: 9pt;
            color: #ffffff;
            font-weight: bold;
            background-color: #000000;
            padding: 4pt 8pt;
            display: inline-block;
            margin-top: 10pt;
        }

        .gate-info {
            font-size: 7.5pt;
            margin-top: 22pt;
            color: #e0e7ff;
            text-transform: uppercase;
            font-weight: bold;
        }

        .page-break { 
            page-break-after: always; 
        }
    </style>
</head>
<body>

@foreach($order->items as $item)
    @for($i = 1; $i <= $item->quantity; $i++)
    <div class="ticket-card">
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
                ⓘ Tunjukkan e-tiket ini di pintu masuk untuk discan. Harap bawa kartu identitas yang berlaku.
            </div>
        </div>

        <div class="stub-content">
            <div style="font-size: 7pt; color: #e0e7ff; font-weight: bold;">SCAN DISINI</div>
            <div class="qr-box">
                <div class="qr-inner">
                    QR CODE
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