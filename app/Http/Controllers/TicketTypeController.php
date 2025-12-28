<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use App\Http\Requests\StoreTicketTypeRequest;
use App\Http\Requests\UpdateTicketTypeRequest;

class TicketTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ticketTypes = TicketType::all();
        $ticketTypes = TicketType::with('event')->get();
        return view('ticket-types.index', compact('ticketTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ticket-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketTypeRequest $request)
    {
        TicketType::create($request->validated());
        return redirect()->route('ticket-types.index')->with('success', 'Ticket Type berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketType $ticketType)
    {
        return view('ticket-types.show', compact('ticketType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketType $ticketType)
    {
        return view('ticket-types.edit', compact('ticketType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketTypeRequest $request, TicketType $ticketType)
    {
        $ticketType->update($request->validated());
        return redirect()->route('ticket-types.show', $ticketType)->with('success', 'Ticket Type berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketType $ticketType)
    {
        $ticketType->delete();
        return redirect()->route('ticket-types.index')->with('success', 'Ticket Type berhasil dihapus');
    }
}
