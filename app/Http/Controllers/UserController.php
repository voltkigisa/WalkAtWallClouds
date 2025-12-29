<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::withCount(['orders'])->paginate(20);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);
        
        return redirect()->route('users.index')->with('success', 'User berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Check if user is viewing their own profile or is admin
        if (Auth::id() !== $user->id && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Load user relationships with statistics
        $user->load(['orders.items.ticketType.event', 'orders.payment']);
        
        // Calculate statistics
        $totalTickets = $user->orders->sum(function($order) {
            return $order->items->sum('quantity');
        });
        
        $totalSpent = $user->orders->where('payment.status', 'paid')->sum(function($order) {
            return $order->payment ? $order->payment->amount : 0;
        });
        
        // Get unique events attended
        $eventsAttended = $user->orders->flatMap(function($order) {
            return $order->items->pluck('ticketType.event');
        })->unique('id')->filter();
        
        // Get ticket types purchased
        $ticketTypes = $user->orders->flatMap(function($order) {
            return $order->items->map(function($item) {
                return [
                    'name' => $item->ticketType->name,
                    'quantity' => $item->quantity,
                    'event' => $item->ticketType->event->title,
                ];
            });
        });
        
        return view('users.show', compact('user', 'totalTickets', 'totalSpent', 'eventsAttended', 'ticketTypes'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deletion of main admin
        if ($user->name === 'Admin Walk At Wall Clouds') {
            return redirect()->route('users.index')->with('error', 'Admin utama tidak dapat dihapus');
        }
        
        // Only allow deleting other admin users, not regular users
        if ($user->role !== 'admin') {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus user biasa. Hanya admin yang bisa dihapus.');
        }
        
        // Prevent users from deleting themselves
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun sendiri');
        }
        
        $user->delete();
        
        return redirect()->route('users.index')->with('success', 'Admin berhasil dihapus');
    }
}
