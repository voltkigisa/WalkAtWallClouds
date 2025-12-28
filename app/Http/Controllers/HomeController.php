<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Artist;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Build query with filters for events
        $query = Event::with('artists');

        // Filter by status (only published for public)
        $query->where('status', 'published');

        // Filter by specific date
        if ($request->filled('date')) {
            $query->whereDate('event_date', $request->date);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Search by title only
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        // Get filtered events
        $events = $query->orderBy('event_date', 'desc')->get();
        
        // Get the first event for hero section
        $event = $events->first();
        
        // Get all artists for guest star section
        $artists = Artist::all();
        
        return view('home', compact('event', 'events', 'artists'));
    }
}
