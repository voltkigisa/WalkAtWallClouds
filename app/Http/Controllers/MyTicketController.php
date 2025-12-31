<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class MyTicketController extends Controller
{
    /**
     * Display user's tickets
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.ticketType.event', 'items.tickets', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('my-tickets.index', compact('orders'));
    }

    /**
     * Show specific order detail
     */
    public function show(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $order->load(['items.ticketType.event', 'items.tickets', 'payment']);
        
        return view('my-tickets.show', compact('order'));
    }

    /**
     * Download ticket PDF
     */
    public function downloadPdf($id)
    {
        try {
            $order = Order::with(['items.ticketType.event', 'user', 'payment'])
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Cek apakah pembayaran sudah selesai
            if (!$order->payment || $order->payment->status !== 'paid') {
                return redirect()->back()->with('error', 'Tiket hanya bisa didownload setelah pembayaran selesai');
            }

            $data = [
                'order' => $order,
                'title' => 'E-Ticket ' . $order->order_code,
                'date'  => date('d/m/Y')
            ];

            // Sama seperti DownloadPDFController yang berfungsi di dashboard
            $pdf = Pdf::loadView('my-tickets.pdf', $data);

            return $pdf->stream('Tiket_' . $order->order_code . '.pdf');
            
        } catch (\Exception $e) {
            Log::error('PDF Download Error: ' . $e->getMessage(), [
                'order_id' => $id,
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Gagal mendownload tiket: ' . $e->getMessage());
        }
    }
}
