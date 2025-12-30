<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Artist;
use App\Models\OrderItem;

class SearchDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q');

        if (!$query) {
            return response()->json([
                'users' => [],
                'tickets' => [],
                'payments' => [],
                'artists' => [],
                'order_items' => [],
            ]);
        }

        return response()->json([
            // ================= USER =================
            'users' => User::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->limit(5)
                ->get(),

            // ================= TICKET =================
            'tickets' => Ticket::where('title', 'like', "%{$query}%")
                ->orWhere('code', 'like', "%{$query}%")
                ->limit(5)
                ->get(),

            // ================= PAYMENT =================
            'payments' => Payment::where('invoice', 'like', "%{$query}%")
                ->orWhere('status', 'like', "%{$query}%")
                ->limit(5)
                ->get(),

            // ================= ARTIST =================
            'artists' => Artist::where('name', 'like', "%{$query}%")
                ->orWhere('country', 'like', "%{$query}%")
                ->orWhere('genre', 'like', "%{$query}%")
                ->limit(5)
                ->get(),

            // ================= ORDER ITEM =================
            'order_items' => OrderItem::whereHas('order', function ($q) use ($query) {
                    $q->where('invoice', 'like', "%{$query}%");
                })
                ->orWhereHas('ticketType', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->with(['order', 'ticketType'])
                ->limit(5)
                ->get(),
        ]);
    }
}
