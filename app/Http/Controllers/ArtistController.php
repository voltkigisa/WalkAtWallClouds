<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artists = Artist::all();
        return view('artists.index', compact('artists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = \App\Models\Event::all();
        return view('artists.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArtistRequest $request)
    {
        $data = $request->validated();
        
        // Handle file upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('artists', 'public');
        }
        
        $artist = Artist::create($data);
        
        // Sync events
        if ($request->has('events')) {
            $artist->events()->sync($request->events);
        }
        
        return redirect()->route('artists.index')->with('success', 'Artist berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Artist $artist)
    {
        return view('artists.show', compact('artist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artist $artist)
    {
        $events = \App\Models\Event::all();
        return view('artists.edit', compact('artist', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArtistRequest $request, Artist $artist)
    {
        $data = $request->validated();
        
        // Handle file upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($artist->photo && Storage::disk('public')->exists($artist->photo)) {
                Storage::disk('public')->delete($artist->photo);
            }
            
            $data['photo'] = $request->file('photo')->store('artists', 'public');
        }
        
        $artist->update($data);
        
        // Sync events
        if ($request->has('events')) {
            $artist->events()->sync($request->events);
        } else {
            $artist->events()->sync([]);
        }
        
        return redirect()->route('artists.show', $artist)->with('success', 'Artist berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        // Delete photo if exists
        if ($artist->photo && Storage::disk('public')->exists($artist->photo)) {
            Storage::disk('public')->delete($artist->photo);
        }
        
        $artist->delete();
        return redirect()->route('artists.index')->with('success', 'Artist berhasil dihapus');
    }
}
