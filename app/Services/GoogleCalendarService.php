<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;
use Illuminate\Support\Facades\Session;

class GoogleCalendarService
{
    protected $client;
    protected $calendar;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(config('services.google.redirect'));
        $this->client->addScope(Calendar::CALENDAR_EVENTS);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');

        // Set access token if available
        if (Session::has('google_access_token')) {
            $this->client->setAccessToken(Session::get('google_access_token'));
        }

        $this->calendar = new Calendar($this->client);
    }

    /**
     * Get authorization URL
     */
    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Handle callback and store token
     */
    public function handleCallback($code)
    {
        $token = $this->client->fetchAccessTokenWithAuthCode($code);
        
        if (isset($token['error'])) {
            throw new \Exception($token['error']);
        }

        Session::put('google_access_token', $token);
        return $token;
    }

    /**
     * Create calendar event
     */
    public function createEvent($summary, $description, $startDateTime, $endDateTime, $location = null)
    {
        if (!$this->client->getAccessToken()) {
            throw new \Exception('Not authorized. Please connect Google Calendar first.');
        }

        $event = new Event([
            'summary' => $summary,
            'location' => $location,
            'description' => $description,
            'start' => [
                'dateTime' => $startDateTime,
                'timeZone' => 'Asia/Jakarta',
            ],
            'end' => [
                'dateTime' => $endDateTime,
                'timeZone' => 'Asia/Jakarta',
            ],
            'reminders' => [
                'useDefault' => false,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 24 * 60],
                    ['method' => 'popup', 'minutes' => 30],
                ],
            ],
        ]);

        $calendarId = 'primary';
        $event = $this->calendar->events->insert($calendarId, $event);

        return $event;
    }

    /**
     * Check if user is authorized
     */
    public function isAuthorized()
    {
        return Session::has('google_access_token') && 
               !empty($this->client->getAccessToken());
    }

    /**
     * Revoke access
     */
    public function revokeAccess()
    {
        if ($this->client->getAccessToken()) {
            $this->client->revokeToken();
        }
        Session::forget('google_access_token');
    }
}