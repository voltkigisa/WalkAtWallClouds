<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Response;

class GuestRedirectController extends Controller
{
    public function redirectToArtist(Artist $artist): Response
    {
        return response()->view('artists.guestarartistlineup', compact('artist'));
    }
}
