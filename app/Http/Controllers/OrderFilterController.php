<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class OrderFilterController extends Controller
{
    public function index(Request $request)
    {
        $ordersQuery = Order::with(['user', 'orderItems.ticketType.event']);
        
        // Filter berdasarkan user
        if ($request->filled('user_id')) {
            $ordersQuery->where('user_id', $request->user_id);
        }
        
        // Filter berdasarkan order number
        if ($request->filled('order_number')) {
            $ordersQuery->where('order_number', 'LIKE', '%' . $request->order_number . '%');
        }
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $ordersQuery->where('status', $request->status);
        }
        
        // Filter berdasarkan payment status
        if ($request->filled('payment_status')) {
            $ordersQuery->where('payment_status', $request->payment_status);
        }
        
        // Filter berdasarkan tanggal order
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $ordersQuery->whereDate('created_at', Carbon::today());
                    break;
                case 'this_week':
                    $ordersQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $ordersQuery->whereMonth('created_at', Carbon::now()->month)
                               ->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }
        
        // Filter berdasarkan range tanggal custom
        if ($request->filled('date_from')) {
            $ordersQuery->where('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $ordersQuery->where('created_at', '<=', $request->date_to);
        }
        
        // Filter berdasarkan range total amount
        if ($request->filled('amount_min')) {
            $ordersQuery->where('total_amount', '>=', $request->amount_min);
        }
        
        if ($request->filled('amount_max')) {
            $ordersQuery->where('total_amount', '<=', $request->amount_max);
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $ordersQuery->orderBy($sortBy, $sortOrder);
        
        // Pagination
        $orders = $ordersQuery->paginate(12);
        
        // Get all users untuk dropdown filter
        $users = User::orderBy('name')->get();
        
        return view('filters.orders', compact('orders', 'users'));
    }
}
