<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Artist;

class SearchLandingController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q');

        if (!$query) {
            return response()->json([]);
        }

        $results = collect();

        // Cari Event Aktif
        $events = Event::where('title', 'like', "%{$query}%")
            ->where('status', 'active') // Asumsi ada kolom status
            ->limit(4)->get()->map(function($event) {
                return [
                    'id' => 'landing-ev-' . $event->id,
                    'title' => $event->title,
                    'category' => 'Upcoming Event',
                    'url' => url('/events/' . $event->slug), // Route detail event publik
                    'image' => asset('storage/' . $event->image)
                ];
            });

        // Cari Artist / Guest Star
        $artists = Artist::where('name', 'like', "%{$query}%")
            ->limit(4)->get()->map(function($artist) {
                return [
                    'id' => 'landing-art-' . $artist->id,
                    'title' => $artist->name,
                    'category' => 'Guest Star',
                    'url' => url('/artists/' . $artist->slug),
                    'image' => asset('storage/' . $artist->photo)
                ];
            });

        $final = $results->concat($events)->concat($artists);

        return response()->json($final);
    }
}