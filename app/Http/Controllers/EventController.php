<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Safe admin check (no error when logged out)
        $isAdmin = false;
        if (Auth::check()) {
            $isAdmin = (bool) Auth::user()->is_admin;
        }

        $query = Event::query();

        // USER & GUEST: only published events
        if (!$isAdmin) {
            $query->where('status', 'published');
        }

        // Search (admin & user)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // ADMIN: filter by status
        if ($isAdmin && $request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ADMIN: filter by date
        if ($isAdmin && $request->filled('date')) {
            $query->whereDate('event_date', $request->date);
        }

        $events = $query->latest()->get();

        return view('events.index', compact('events', 'isAdmin'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();

        if ($data['status'] === 'published') {
            Event::where('status', 'published')->update(['status' => 'draft']);
        }

        Event::create($data);

        return redirect()->route('events.index')
            ->with('success', 'Event successfully created');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $data = $request->validated();

        if ($data['status'] === 'published') {
            Event::where('status', 'published')
                ->where('id', '!=', $event->id)
                ->update(['status' => 'draft']);
        }

        $event->update($data);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event successfully updated');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event successfully deleted');
    }
}
