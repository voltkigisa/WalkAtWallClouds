<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Artist;

class SearchLandingController extends Controller
{
    public function index(Request $request)
    {
        // STEP 4: ambil keyword dari URL ?q=
        $q = $request->query('q');

        // Kalau belum ngetik apa-apa
        if (!$q) {
            return response()->json([
                'events' => [],
                'artists' => []
            ]);
        }

        // STEP 5 + 6: query + optimasi
        return response()->json([
            'events' => Event::select('id', 'title', 'event_date', 'location')
                ->where('title', 'like', "%{$q}%")
                ->limit(5)
                ->get(),

            'artists' => Artist::select('id', 'name', 'genre')
                ->where('name', 'like', "%{$q}%")
                ->orWhere('genre', 'like', "%{$q}%")
                ->limit(5)
                ->get(),
        ]);
    }
}
