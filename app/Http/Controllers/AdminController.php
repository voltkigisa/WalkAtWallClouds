<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Artist;
use App\Models\Order;
use App\Models\Ticket;

class AdminController extends Controller
{
    public function index()
    {
        $events = Event::withCount('artists')->get();
        $artists = Artist::withCount('events')->get();
        $totalEvents = Event::count();
        $totalArtists = Artist::count();
        $totalOrders = Order::count();
        $totalTickets = Ticket::count();
        
        return view('admin', compact('events', 'artists', 'totalEvents', 'totalArtists', 'totalOrders', 'totalTickets'));
    }
}
