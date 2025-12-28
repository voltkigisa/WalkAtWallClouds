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
        $events = Event::where('status', 'published')->with('ticketTypes')->get();
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
     * Show checkout form from cart
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('purchase.index')
                ->with('error', 'Keranjang Anda kosong');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.checkout', compact('cart', 'total'));
    }

    /**
     * Store the order and create tickets from cart
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => ['required', 'in:transfer,card,e-wallet'],
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('purchase.index')
                ->with('error', 'Keranjang Anda kosong');
        }

        // Calculate total and validate stock
        $totalPrice = 0;
        foreach ($cart as $item) {
            $ticketType = TicketType::find($item['ticket_type_id']);
            $available = $ticketType->quota - $ticketType->sold;
            
            if ($item['quantity'] > $available) {
                return back()->withErrors(['error' => "Stok {$ticketType->name} tidak cukup. Tersedia: $available tiket"]);
            }
            
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Create Order
        $orderCode = 'ORD-' . date('YmdHis') . '-' . rand(1000, 9999);

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_code' => $orderCode,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Create OrderItems and Tickets from cart
        foreach ($cart as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'ticket_type_id' => $item['ticket_type_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $subtotal,
            ]);

            // Generate Tickets
            for ($i = 0; $i < $item['quantity']; $i++) {
                $ticketCode = 'TKT-' . date('YmdHis') . '-' . $order->id . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
                
                // Generate simple QR code data (URL atau string unik)
                $qrData = url('/verify-ticket/' . $ticketCode);
                
                Ticket::create([
                    'order_item_id' => $orderItem->id,
                    'ticket_code' => $ticketCode,
                    'qr_code' => $qrData,
                    'status' => 'unused', // Fix: gunakan 'unused' bukan 'issued'
                    'used_at' => null,
                ]);
            }

            // Update ticket sold count
            $ticketType = TicketType::findOrFail($item['ticket_type_id']);
            $ticketType->sold += $item['quantity'];
            $ticketType->save();
        }

        // Create Payment record
        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $request->payment_method,
            'payment_reference' => null,
            'amount' => $totalPrice,
            'status' => 'pending',
            'paid_at' => null,
        ]);

        // Clear cart
        session()->forget('cart');

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
