<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use Carbon\Carbon;

class ArtistFilterController extends Controller
{
    public function index(Request $request)
    {
        $artistsQuery = Artist::withCount('events');
        
        // Filter berdasarkan nama artist
        if ($request->filled('name')) {
            $artistsQuery->where('name', 'LIKE', '%' . $request->name . '%');
        }
        
        // Filter berdasarkan genre
        if ($request->filled('genre')) {
            $artistsQuery->where('genre', 'LIKE', '%' . $request->genre . '%');
        }
        
        // Filter berdasarkan bio
        if ($request->filled('bio')) {
            $artistsQuery->where('bio', 'LIKE', '%' . $request->bio . '%');
        }
        
        // Filter berdasarkan jumlah events
        if ($request->filled('events_min')) {
            $artistsQuery->has('events', '>=', $request->events_min);
        }
        
        if ($request->filled('events_max')) {
            $artistsQuery->has('events', '<=', $request->events_max);
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if ($sortBy == 'events_count') {
            $artistsQuery->orderBy('events_count', $sortOrder);
        } else {
            $artistsQuery->orderBy($sortBy, $sortOrder);
        }
        
        // Pagination
        $artists = $artistsQuery->paginate(12);
        
        // Get unique genres untuk dropdown filter
        $genres = Artist::distinct()
                       ->pluck('genre')
                       ->filter()
                       ->sort();
        
        return view('filters.artists', compact('artists', 'genres'));
    }
}
