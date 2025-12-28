<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Artist;
use App\Models\Order;
use App\Models\Ticket;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'events');
        
        // Filter Events
        if ($type === 'events') {
            $query = Event::withCount('artists');
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('date_from')) {
                $query->whereDate('event_date', '>=', $request->date_from);
            }
            
            if ($request->filled('date_to')) {
                $query->whereDate('event_date', '<=', $request->date_to);
            }
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            }
            
            $events = $query->orderBy('event_date', 'desc')->get();
            $artists = collect();
            $orders = collect();
            $tickets = collect();
        }
        // Filter Artists
        elseif ($type === 'artists') {
            $query = Artist::query();
            
            if ($request->filled('search')) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search}%")
                      ->orWhere('genre', 'like', "%{$request->search}%");
                });
            }
            
            $artists = $query->orderBy('name')->get();
            $events = collect();
            $orders = collect();
            $tickets = collect();
        }
        // Filter Orders
        elseif ($type === 'orders') {
            $query = Order::with('user');
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            
            if ($request->filled('search')) {
                $query->where('order_number', 'like', "%{$request->search}%");
            }
            
            $orders = $query->orderBy('created_at', 'desc')->get();
            $events = collect();
            $artists = collect();
            $tickets = collect();
        }
        // Filter Tickets
        elseif ($type === 'tickets') {
            $query = Ticket::with(['ticketType', 'order']);
            
            if ($request->filled('search')) {
                $query->where('ticket_code', 'like', "%{$request->search}%");
            }
            
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            
            $tickets = $query->orderBy('created_at', 'desc')->get();
            $events = collect();
            $artists = collect();
            $orders = collect();
        }
        else {
            $events = Event::withCount('artists')->orderBy('event_date', 'desc')->get();
            $artists = collect();
            $orders = collect();
            $tickets = collect();
        }

        $totalEvents = Event::count();
        $totalArtists = Artist::count();
        $totalOrders = Order::count();
        $totalTickets = Ticket::count();
        
        return view('admin', compact('events', 'artists', 'orders', 'tickets', 'totalEvents', 'totalArtists', 'totalOrders', 'totalTickets', 'type'));
    }
}
