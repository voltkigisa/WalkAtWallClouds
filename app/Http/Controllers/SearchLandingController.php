<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Artist;

class SearchLandingController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));
        $location = trim($request->query('location', ''));
        $date = trim($request->query('date', ''));
        $type = trim($request->query('type', ''));

        if ($q === '') {
            return response()->json([
                'events' => [],
                'artists' => [],
                'tickets' => []
            ]);
        }

        // Events filter
        $eventsQuery = Event::select('id', 'title', 'event_date', 'location')
            ->when($q, fn($qbuilder) => $qbuilder->where('title', 'like', "%{$q}%"))
            ->when($location, fn($qbuilder) => $qbuilder->where('location', 'like', "%{$location}%"))
            ->when($date, fn($qbuilder) => $qbuilder->whereDate('event_date', $date))
            ->orderBy('event_date', 'desc')
            ->limit(5);

        // Artists filter
        $artistsQuery = Artist::select('id', 'name', 'genre')
            ->when($q, function ($qbuilder) use ($q) {
                $qbuilder->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                       ->orWhere('genre', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->limit(5);

        // Type gating (if provided)
        $events = ($type && $type !== 'events') ? collect() : $eventsQuery->get();
        $artists = ($type && $type !== 'artists') ? collect() : $artistsQuery->get();

        return response()->json([
            'events' => $events,
            'artists' => $artists,
        ]);
    }
}
