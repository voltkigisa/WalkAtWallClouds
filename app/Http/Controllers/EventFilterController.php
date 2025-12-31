<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class EventFilterController extends Controller
{
    public function index(Request $request)
    {
        // Query builder untuk events
        $eventsQuery = Event::where('status', 'published')->with('artists');
        
        // Filter berdasarkan lokasi
        if ($request->filled('location')) {
            $eventsQuery->where('location', 'LIKE', '%' . $request->location . '%');
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
        
        // Filter berdasarkan range harga
        if ($request->filled('price_min') || $request->filled('price_max')) {
            $eventsQuery->whereHas('ticketTypes', function($query) use ($request) {
                if ($request->filled('price_min')) {
                    $query->where('price', '>=', $request->price_min);
                }
                if ($request->filled('price_max')) {
                    $query->where('price', '<=', $request->price_max);
                }
            });
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'event_date');
        $sortOrder = $request->get('sort_order', 'asc');
        $eventsQuery->orderBy($sortBy, $sortOrder);
        
        // Pagination
        $events = $eventsQuery->paginate(12);
        
        // Get unique locations untuk dropdown filter
        $locations = Event::where('status', 'published')
                         ->distinct()
                         ->pluck('location')
                         ->filter()
                         ->sort();
        
        return view('filters.events', compact('events', 'locations'));
    }
}
