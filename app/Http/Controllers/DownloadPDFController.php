<?php
namespace App\Http\Controllers;

// PASTIKAN BARIS INI ADA
use Illuminate\Http\Request; 
use App\Models\User;
use App\Models\TicketType;
use App\Models\Order;
use App\Models\Event;
use App\Models\Artist;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
class DownloadPDFController extends Controller
{
   public function downloadPDF(Request $request)
{
    $type = $request->query('type', 'tickets');

    // Masukkan statistik kamu di sini
    $stats = [
        'total_events'       => \App\Models\Event::count(),
        'total_artists'      => \App\Models\Artist::count(),
        'total_orders'       => \App\Models\Order::count(),
        'total_tickets'      => \App\Models\Ticket::count(),
        'total_ticket_types' => \App\Models\TicketType::count(),
        'total_users'        => \App\Models\User::count(),
    ];

    $items = ($type == 'users') ? \App\Models\User::all() : \App\Models\TicketType::all();
    $title = ($type == 'users') ? 'Laporan Data User' : 'Laporan Tipe Tiket';

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.dashboard_pdf', [
        'stats' => $stats,
        'items' => $items,
        'title' => $title,
        'type'  => $type,
        'date'  => date('d/m/Y')
    ]);

    return $pdf->stream("Laporan-{$type}.pdf");
}
}