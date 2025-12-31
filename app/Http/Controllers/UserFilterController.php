<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UserFilterController extends Controller
{
    public function index(Request $request)
    {
        $usersQuery = User::withCount('orders');
        
        // Filter berdasarkan role
        if ($request->filled('role')) {
            $usersQuery->where('role', $request->role);
        }
        
        // Filter berdasarkan email
        if ($request->filled('email')) {
            $usersQuery->where('email', 'LIKE', '%' . $request->email . '%');
        }
        
        // Filter berdasarkan nama
        if ($request->filled('name')) {
            $usersQuery->where('name', 'LIKE', '%' . $request->name . '%');
        }
        
        // Filter berdasarkan tanggal registrasi
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $usersQuery->whereDate('created_at', Carbon::today());
                    break;
                case 'this_week':
                    $usersQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $usersQuery->whereMonth('created_at', Carbon::now()->month)
                               ->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }
        
        // Filter berdasarkan range tanggal custom
        if ($request->filled('date_from')) {
            $usersQuery->where('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $usersQuery->where('created_at', '<=', $request->date_to);
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $usersQuery->orderBy($sortBy, $sortOrder);
        
        // Pagination
        $users = $usersQuery->paginate(12);
        
        return view('filters.users', compact('users'));
    }
}
