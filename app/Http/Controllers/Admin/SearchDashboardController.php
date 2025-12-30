<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Artist;

class SearchDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q');

        if (!$query) {
            return response()->json([]);
        }

        return response()->json([
            'users' => User::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->limit(5)
                ->get(),

            'tickets' => Ticket::where('title', 'like', "%{$query}%")
                ->orWhere('code', 'like', "%{$query}%")
                ->limit(5)
                ->get(),

            'payments' => Payment::where('invoice', 'like', "%{$query}%")
                ->orWhere('status', 'like', "%{$query}%")
                ->limit(5)
                ->get(),


            'artists' => Artist::where('name', 'like', "%{$query}%")
                ->orWhere('country', 'like', "%{$query}%")
                ->orWhere('genre', 'like', "%{$query}%")
                ->limit(5)
                ->get(),
        ]);
    }
}
