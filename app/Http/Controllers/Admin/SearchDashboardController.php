<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Event;
use App\Models\Artist;
use App\Models\TicketType;
use App\Models\Order;
use App\Models\OrderItem;

class SearchDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q');

        if (!$query || strlen($query) < 1) {
            return response()->json([]);
        }

        $results = [];

        // ================= USERS =================
        // Optimized: removed % at beginning for better index usage
        $users = User::where('name', 'like', "{$query}%")
            ->orWhere('email', 'like', "{$query}%")
            ->limit(3)
            ->get();

        foreach ($users as $user) {
            $results[] = [
                'id' => 'user-' . $user->id,
                'title' => $user->name,
                'category' => 'User • ' . $user->email,
                'url' => route('users.show', $user->id),
                'image' => null,
            ];
        }

        // ================= EVENTS =================
        // Optimized: only search in title and location for better performance
        $events = Event::where('title', 'like', "{$query}%")
            ->orWhere('location', 'like', "{$query}%")
            ->limit(3)
            ->get();

        foreach ($events as $event) {
            $results[] = [
                'id' => 'event-' . $event->id,
                'title' => $event->title,
                'category' => 'Event • ' . $event->location,
                'url' => route('events.show', $event->id),
                'image' => $event->poster ? asset('storage/' . $event->poster) : null,
            ];
        }

        // ================= ARTISTS =================
        // Optimized: only search in name and genre
        $artists = Artist::where('name', 'like', "{$query}%")
            ->orWhere('genre', 'like', "{$query}%")
            ->limit(3)
            ->get();

        foreach ($artists as $artist) {
            $results[] = [
                'id' => 'artist-' . $artist->id,
                'title' => $artist->name,
                'category' => 'Artist • ' . $artist->genre,
                'url' => route('artists.show', $artist->id),
                'image' => $artist->photo ? asset('storage/' . $artist->photo) : null,
            ];
        }

        // ================= TICKET TYPES =================
        // Optimized: simplified search
        $ticketTypes = TicketType::where('name', 'like', "{$query}%")
            ->with('event')
            ->limit(3)
            ->get();

        foreach ($ticketTypes as $ticketType) {
            $results[] = [
                'id' => 'ticket-' . $ticketType->id,
                'title' => $ticketType->name,
                'category' => 'Ticket • ' . ($ticketType->event->title ?? 'No Event'),
                'url' => route('ticket-types.show', $ticketType->id),
                'image' => null,
            ];
        }

        // ================= ORDERS =================
        // Optimized: focus on order_code search
        $orders = Order::where('order_code', 'like', "{$query}%")
            ->orWhere('status', 'like', "{$query}%")
            ->with('user')
            ->limit(3)
            ->get();

        foreach ($orders as $order) {
            $results[] = [
                'id' => 'order-' . $order->id,
                'title' => $order->order_code,
                'category' => 'Order • ' . ($order->user->name ?? 'Unknown User'),
                'url' => route('orders.show', $order->id),
                'image' => null,
            ];
        }

        // ================= ORDER ITEMS =================
        // Optimized: removed to reduce query load, can search via Orders instead
        // This prevents multiple joins that slow down the query

        foreach ($orderItems as $orderItem) {
            $results[] = [
                'id' => 'order-item-' . $orderItem->id,
                'title' => ($orderItem->order->order_code ?? 'N/A'),
                'category' => 'Order Item • ' . ($orderItem->ticketType->name ?? 'Unknown Ticket'),
                'url' => route('order-items.show', $orderItem->id),
                'image' => null,
            ];
        }

        return response()->json($results);
    }
}
