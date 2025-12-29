<?php

namespace App\Http\Controllers;

use App\Services\GoogleCalendarService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GoogleCalendarController extends Controller
{
    protected $googleCalendar;

    public function __construct(GoogleCalendarService $googleCalendar)
    {
        $this->googleCalendar = $googleCalendar;
    }

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        $authUrl = $this->googleCalendar->getAuthUrl();
        return redirect($authUrl);
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $code = $request->get('code');
            $this->googleCalendar->handleCallback($code);

            return redirect()->route('my-tickets.index')
                ->with('success', 'Google Calendar berhasil terhubung!');
        } catch (\Exception $e) {
            return redirect()->route('my-tickets.index')
                ->with('error', 'Gagal menghubungkan Google Calendar: ' . $e->getMessage());
        }
    }

    /**
     * Add event to calendar
     */
    public function addEventToCalendar(Request $request)
    {
        $request->validate([
            'event_title' => 'required|string',
            'event_date' => 'required|date',
            'event_location' => 'nullable|string',
            'ticket_code' => 'required|string',
        ]);

        try {
            if (!$this->googleCalendar->isAuthorized()) {
                return redirect()->route('google-calendar.auth')
                    ->with('info', 'Hubungkan Google Calendar terlebih dahulu');
            }

            $startDateTime = Carbon::parse($request->event_date)->format('c');
            $endDateTime = Carbon::parse($request->event_date)->addHours(4)->format('c');

            $description = "Tiket: {$request->ticket_code}\n";
            $description .= "Event dari WalkAtWallClouds\n";
            $description .= "Jangan lupa bawa tiket Anda!";

            $event = $this->googleCalendar->createEvent(
                $request->event_title,
                $description,
                $startDateTime,
                $endDateTime,
                $request->event_location
            );

            return back()->with('success', 'Event berhasil ditambahkan ke Google Calendar!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan ke calendar: ' . $e->getMessage());
        }
    }

    /**
     * Disconnect Google Calendar
     */
    public function disconnect()
    {
        $this->googleCalendar->revokeAccess();
        return back()->with('success', 'Google Calendar berhasil diputuskan');
    }
}