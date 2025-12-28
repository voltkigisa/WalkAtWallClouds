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
        // Build query with filters
        $query = Event::withCount('artists');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('event_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('event_date', '<=', $request->date_to);
        }

        // Search by title or location
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $events = $query->orderBy('event_date', 'desc')->get();

        $totalEvents = Event::count();
        $totalArtists = Artist::count();
        $totalOrders = Order::count();
        $totalTickets = Ticket::count();
        
        return view('admin', compact('events', 'totalEvents', 'totalArtists', 'totalOrders', 'totalTickets'));
    }
}
