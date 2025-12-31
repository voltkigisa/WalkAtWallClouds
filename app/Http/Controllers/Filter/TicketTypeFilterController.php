<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketType;
use App\Models\Event;
use Carbon\Carbon;

class TicketTypeFilterController extends Controller
{
    public function index(Request $request)
    {
        $ticketTypesQuery = TicketType::with('event');
        
        // Filter berdasarkan event
        if ($request->filled('event_id')) {
            $ticketTypesQuery->where('event_id', $request->event_id);
        }
        
        // Filter berdasarkan nama ticket type
        if ($request->filled('name')) {
            $ticketTypesQuery->where('name', 'LIKE', '%' . $request->name . '%');
        }
        
        // Filter berdasarkan range harga
        if ($request->filled('price_min')) {
            $ticketTypesQuery->where('price', '>=', $request->price_min);
        }
        
        if ($request->filled('price_max')) {
            $ticketTypesQuery->where('price', '<=', $request->price_max);
        }
        
        // Filter berdasarkan quota
        if ($request->filled('quota_min')) {
            $ticketTypesQuery->where('quota', '>=', $request->quota_min);
        }
        
        if ($request->filled('quota_max')) {
            $ticketTypesQuery->where('quota', '<=', $request->quota_max);
        }
        
        // Filter berdasarkan status ketersediaan
        if ($request->filled('availability')) {
            if ($request->availability == 'available') {
                $ticketTypesQuery->whereRaw('sold < quota');
            } elseif ($request->availability == 'sold_out') {
                $ticketTypesQuery->whereRaw('sold >= quota');
            }
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $ticketTypesQuery->orderBy($sortBy, $sortOrder);
        
        // Pagination
        $ticketTypes = $ticketTypesQuery->paginate(12);
        
        // Get all events untuk dropdown filter
        $events = Event::orderBy('title')->get();
        
        return view('filters.ticket-types', compact('ticketTypes', 'events'));
    }
}
