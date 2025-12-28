<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
