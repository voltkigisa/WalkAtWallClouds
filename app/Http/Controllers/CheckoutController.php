<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Display a listing of all ticket types
     */
    public function index()
    {
        $events = Event::where('status', 'active')->with('ticketTypes')->get();
        return view('purchase.index', compact('events'));
    }

    /**
     * Show checkout form for a specific ticket type
     */
    public function show(TicketType $ticketType)
    {
        return view('purchase.checkout', compact('ticketType'));
    }

    /**
     * Store the order and create tickets
     */
    public function store(Request $request)
    {
        $request->validate([
            'ticket_type_id' => ['required', 'exists:ticket_types,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'payment_method' => ['required', 'in:transfer,card,e-wallet'],
        ]);

        $ticketType = TicketType::findOrFail($request->ticket_type_id);
        $quantity = $request->quantity;

        // Check stock availability
        $available = $ticketType->quota - $ticketType->sold;
        if ($quantity > $available) {
            return back()->withErrors(['quantity' => "Stok tiket tidak cukup. Tersedia: $available tiket"]);
        }

        // Create Order
        $orderCode = 'ORD-' . date('YmdHis') . '-' . rand(1000, 9999);
        $totalPrice = $ticketType->price * $quantity;

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_code' => $orderCode,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Create OrderItem
        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'ticket_type_id' => $ticketType->id,
            'quantity' => $quantity,
            'price' => $ticketType->price,
        ]);

        // Generate Tickets
        for ($i = 0; $i < $quantity; $i++) {
            $ticketCode = 'TKT-' . date('YmdHis') . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
            Ticket::create([
                'order_item_id' => $orderItem->id,
                'ticket_code' => $ticketCode,
                'qr_code' => null, // Can be generated later
                'status' => 'issued',
                'used_at' => null,
            ]);
        }

        // Update ticket sold count
        $ticketType->increment('sold', $quantity);

        // Create Payment record
        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $request->payment_method,
            'payment_reference' => null,
            'amount' => $totalPrice,
            'status' => 'pending',
            'paid_at' => null,
        ]);

        return redirect()->route('checkout.confirmation', $order->id)
            ->with('success', 'Order berhasil dibuat. Silahkan lakukan pembayaran.');
    }

    /**
     * Show order confirmation
     */
    public function confirmation(Order $order)
    {
        // Check if user is the order owner
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $order->load('items.ticketType', 'payment', 'items.tickets');
        
        return view('purchase.confirmation', compact('order'));
    }
}
