<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1|max:10',
            'direct_checkout' => 'nullable|boolean'
        ]);

        $ticketType = TicketType::with('event')->findOrFail($request->ticket_type_id);
        
        // Check if event is published
        if ($ticketType->event->status !== 'published') {
            return back()->with('error', 'Event ini belum dipublikasikan');
        }

        // Check stock
        $available = $ticketType->quota - $ticketType->sold;
        if ($request->quantity > $available) {
            return back()->with('error', "Stok tiket tidak cukup. Tersedia: $available tiket");
        }

        $cart = session()->get('cart', []);
        $itemId = 'ticket_' . $ticketType->id;

        // If item already exists in cart, update quantity
        if (isset($cart[$itemId])) {
            $newQuantity = $cart[$itemId]['quantity'] + $request->quantity;
            
            // Check if new quantity exceeds stock
            if ($newQuantity > $available) {
                return back()->with('error', "Total quantity melebihi stok. Tersedia: $available tiket");
            }
            
            $cart[$itemId]['quantity'] = $newQuantity;
        } else {
            // Add new item to cart
            $cart[$itemId] = [
                'ticket_type_id' => $ticketType->id,
                'name' => $ticketType->name,
                'event_title' => $ticketType->event->title,
                'event_date' => $ticketType->event->event_date,
                'price' => $ticketType->price,
                'quantity' => $request->quantity,
                'image' => $ticketType->event->cover_image ?? null
            ];
        }

        session()->put('cart', $cart);
        
        // If direct_checkout is true, redirect to checkout
        if ($request->direct_checkout) {
            return redirect()->route('cart.checkout');
        }
        
        return back()->with('success', 'Tiket berhasil ditambahkan ke keranjang');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $cart = session()->get('cart', []);
        
        if (!isset($cart[$itemId])) {
            return back()->with('error', 'Item tidak ditemukan di keranjang');
        }

        // Get ticket type to check stock
        $ticketTypeId = $cart[$itemId]['ticket_type_id'];
        $ticketType = TicketType::findOrFail($ticketTypeId);
        $available = $ticketType->quota - $ticketType->sold;

        if ($request->quantity > $available) {
            return back()->with('error', "Stok tiket tidak cukup. Tersedia: $available tiket");
        }

        $cart[$itemId]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        return back()->with('success', 'Jumlah tiket berhasil diperbarui');
    }

    /**
     * Remove item from cart
     */
    public function remove($itemId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Tiket berhasil dihapus dari keranjang');
    }

    /**
     * Clear all cart
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang berhasil dikosongkan');
    }

    /**
     * Get cart count for badge
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = 0;
        
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        
        return response()->json(['count' => $count]);
    }
}
