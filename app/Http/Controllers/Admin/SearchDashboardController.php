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
        $users = User::where('id', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('role', 'like', "%{$query}%")
            ->limit(5)
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
        $events = Event::where('id', 'like', "%{$query}%")
            ->orWhere('title', 'like', "%{$query}%")
            ->orWhere('location', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('status', 'like', "%{$query}%")
            ->limit(5)
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
        $artists = Artist::where('id', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->orWhere('genre', 'like', "%{$query}%")
            ->orWhere('country', 'like', "%{$query}%")
            ->orWhere('bio', 'like', "%{$query}%")
            ->limit(5)
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
        // Search in ticket name AND related event title
        $ticketTypes = TicketType::where('id', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->orWhereHas('event', function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%");
            })
            ->with('event')
            ->limit(5)
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
        // Search in order_code, status, and user name
        $orders = Order::where('id', 'like', "%{$query}%")
            ->orWhere('order_code', 'like', "%{$query}%")
            ->orWhere('status', 'like', "%{$query}%")
            ->orWhereHas('user', function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })
            ->with('user')
            ->limit(5)
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
        // Search in order items by ticket type name or order code
        $orderItems = OrderItem::where('id', 'like', "%{$query}%")
            ->orWhereHas('ticketType', function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->orWhereHas('order', function($q) use ($query) {
                $q->where('order_code', 'like', "%{$query}%");
            })
            ->with(['order.user', 'ticketType'])
            ->limit(5)
            ->get();

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
