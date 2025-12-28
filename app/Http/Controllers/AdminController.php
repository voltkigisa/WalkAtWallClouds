<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Artist;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Limit 5 for dashboard preview
        $events = Event::withCount('artists')->limit(5)->get();
        $artists = Artist::withCount('events')->limit(5)->get();
        $ticketTypes = TicketType::with('event')->limit(5)->get();
        $users = User::withCount(['orders'])->limit(5)->get();
        
        // Total counts
        $totalEvents = Event::count();
        $totalArtists = Artist::count();
        $totalOrders = Order::count();
        $totalTickets = Ticket::count();
        $totalTicketTypes = TicketType::count();
        $totalUsers = User::count();
        
        return view('admin', compact('events', 'artists', 'ticketTypes', 'users', 'totalEvents', 'totalArtists', 'totalOrders', 'totalTickets', 'totalTicketTypes', 'totalUsers'));
    }
}
