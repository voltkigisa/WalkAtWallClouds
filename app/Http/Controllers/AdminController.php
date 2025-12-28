<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Artist;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketType;

class AdminController extends Controller
{
    public function index()
    {
        $events = Event::withCount('artists')->get();
        $artists = Artist::withCount('events')->get();
        $ticketTypes = TicketType::with('event')->get();
        $totalEvents = Event::count();
        $totalArtists = Artist::count();
        $totalOrders = Order::count();
        $totalTickets = Ticket::count();
        $totalTicketTypes = TicketType::count();
        
        return view('admin', compact('events', 'artists', 'ticketTypes', 'totalEvents', 'totalArtists', 'totalOrders', 'totalTickets', 'totalTicketTypes'));
    }
}
