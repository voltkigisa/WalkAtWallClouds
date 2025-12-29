<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Event;
use App\Models\Artist;

class SearchDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $results = collect();

        // Cari User / Pelanggan
        $users = User::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->limit(5)->get()->map(function($user) {
                return [
                    'id' => 'u-' . $user->id,
                    'title' => $user->name,
                    'category' => 'User Admin / Customer',
                    'url' => '#', // Sesuaikan jika ada route detail user
                    'image' => null
                ];
            });

        // Cari Event (Internal)
        $events = Event::where('title', 'like', "%{$query}%")
            ->limit(5)->get()->map(function($event) {
                return [
                    'id' => 'ev-' . $event->id,
                    'title' => $event->title,
                    'category' => 'Event Management',
                    'url' => route('events.index'),
                    'image' => $event->image ? asset('storage/' . $event->image) : null
                ];
            });

        // Cari Tiket berdasarkan Kode atau Judul
        $tickets = Ticket::where('title', 'like', "%{$query}%")
            ->limit(5)->get()->map(function($ticket) {
                return [
                    'id' => 't-' . $ticket->id,
                    'title' => $ticket->title,
                    'category' => 'Ticket Type',
                    'url' => route('ticket-types.index'),
                    'image' => null
                ];
            });

        // Gabungkan dan kirim sebagai satu array
        $final = $results->concat($users)->concat($events)->concat($tickets);

        return response()->json($final);
    }
}