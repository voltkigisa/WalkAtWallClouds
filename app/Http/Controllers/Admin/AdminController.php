<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Artist;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Query builder untuk events dengan filter
        $eventsQuery = Event::withCount('artists');
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $eventsQuery->where('status', $request->status);
        }
        
        // Filter berdasarkan tanggal
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $eventsQuery->whereDate('event_date', Carbon::today());
                    break;
                case 'this_week':
                    $eventsQuery->whereBetween('event_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $eventsQuery->whereMonth('event_date', Carbon::now()->month)
                               ->whereYear('event_date', Carbon::now()->year);
                    break;
                case 'upcoming':
                    $eventsQuery->where('event_date', '>=', Carbon::today());
                    break;
                case 'past':
                    $eventsQuery->where('event_date', '<', Carbon::today());
                    break;
            }
        }
        
        // Filter berdasarkan range tanggal custom
        if ($request->filled('date_from')) {
            $eventsQuery->where('event_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $eventsQuery->where('event_date', '<=', $request->date_to);
        }
        
        // Limit 5 for dashboard preview
        $events = $eventsQuery->limit(5)->get();
        
        // Artists query with filters
        $artistsQuery = Artist::withCount('events');
        if ($request->filled('artist_name')) {
            $artistsQuery->where('name', 'LIKE', '%' . $request->artist_name . '%');
        }
        if ($request->filled('artist_genre')) {
            $artistsQuery->where('genre', 'LIKE', '%' . $request->artist_genre . '%');
        }
        $artists = $artistsQuery->limit(5)->get();
        
        // Ticket Types query with filters
        $ticketTypesQuery = TicketType::with('event');
        if ($request->filled('ticket_name')) {
            $ticketTypesQuery->where('name', 'LIKE', '%' . $request->ticket_name . '%');
        }
        if ($request->filled('ticket_event_id')) {
            $ticketTypesQuery->where('event_id', $request->ticket_event_id);
        }
        if ($request->filled('ticket_availability')) {
            if ($request->ticket_availability == 'available') {
                $ticketTypesQuery->whereRaw('sold < quota');
            } elseif ($request->ticket_availability == 'sold_out') {
                $ticketTypesQuery->whereRaw('sold >= quota');
            }
        }
        $ticketTypes = $ticketTypesQuery->limit(5)->get();
        
        // Users query with filters
        $usersQuery = User::withCount(['orders']);
        if ($request->filled('user_name')) {
            $usersQuery->where('name', 'LIKE', '%' . $request->user_name . '%');
        }
        if ($request->filled('user_email')) {
            $usersQuery->where('email', 'LIKE', '%' . $request->user_email . '%');
        }
        if ($request->filled('user_role')) {
            $usersQuery->where('role', $request->user_role);
        }
        $users = $usersQuery->limit(5)->get();
        
        // Get all events for dropdown
        $allEvents = Event::orderBy('title')->get();
        
        // Total counts
        $totalEvents = Event::count();
        $totalArtists = Artist::count();
        $totalOrders = Order::count();
        $totalTickets = Ticket::count();
        $totalTicketTypes = TicketType::count();
        $totalUsers = User::count();
        
        return view('admin', compact('events', 'artists', 'ticketTypes', 'users', 'totalEvents', 'totalArtists', 'totalOrders', 'totalTickets', 'totalTicketTypes', 'totalUsers', 'allEvents'));
    }
}
