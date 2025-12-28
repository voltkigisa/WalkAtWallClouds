<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Payment;

class SearchDashboardController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));
        $type = trim($request->query('type', ''));
        $status = trim($request->query('status', ''));
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        if ($q === '') {
            return response()->json([
                'users' => [],
                'tickets' => [],
                'payments' => [],
            ]);
        }

        // Users
        $users = User::query()
            ->when($q, fn($qb) => $qb->where(function($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%");
            }))
            ->limit(5)
            ->get();

        // Tickets
        $tickets = Ticket::query()
            ->when($q, fn($qb) => $qb->where(function($qq) use ($q) {
                $qq->where('ticket_code', 'like', "%{$q}%")
                   ->orWhere('code', 'like', "%{$q}%");
            }))
            ->when($dateFrom, fn($qb) => $qb->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($qb) => $qb->whereDate('created_at', '<=', $dateTo))
            ->limit(5)
            ->get();

        // Payments
        $payments = Payment::query()
            ->when($q, fn($qb) => $qb->where(function($qq) use ($q) {
                $qq->where('invoice', 'like', "%{$q}%")
                   ->orWhere('status', 'like', "%{$q}%");
            }))
            ->when($status, fn($qb) => $qb->where('status', $status))
            ->when($dateFrom, fn($qb) => $qb->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($qb) => $qb->whereDate('created_at', '<=', $dateTo))
            ->limit(5)
            ->get();

        // Type gating
        if ($type) {
            return response()->json([
                'users' => $type === 'users' ? $users : [],
                'tickets' => $type === 'tickets' ? $tickets : [],
                'payments' => $type === 'payments' ? $payments : [],
            ]);
        }

        return response()->json([
            'users' => $users,
            'tickets' => $tickets,
            'payments' => $payments,
        ]);
    }
}
