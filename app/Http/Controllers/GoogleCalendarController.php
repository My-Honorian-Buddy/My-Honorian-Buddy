<?php

namespace App\Http\Controllers;

use Google\Client as GoogleClient;
use Google\Service\Calendar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class GoogleCalendarController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri(env('GOOGLE_REDIRECT_URI')); 
        $this->client->addScope(Calendar::CALENDAR_EVENTS);
    }

    public function showCalendar()
    {
        $today = Carbon::now();
        $events = session('events') ?? [];

        return view('workspace', compact('today', 'events'));       //suko naku dol
    }                                                               //dwight sopan munaku pls

    public function redirectToGoogle()
    {
        if (Session::has('google_access_token')) {
            return redirect()->route('workspace.start');
        }

        $authUrl = $this->client->createAuthUrl();
        return redirect()->away($authUrl);
    }
    
    public function handleGoogleCallback(Request $request)
    {
        Log::info('handleGoogleCallback function triggered');

        if (!$request->has('code')) {
            return redirect()->route('google.auth.calendar')->withErrors('Authorization code is missing.');
        }

        try {
            $token = $this->client->fetchAccessTokenWithAuthCode($request->code);

            if (array_key_exists('error', $token)) {
                return redirect()->route('google.auth.calendar')->withErrors('Error fetching access token: ' . $token['error']);
            }

            Log::info('Google Access Token:', $token);

            Session::put('google_access_token', $token);

            $service = new Calendar($this->client);
            $calendarId = 'primary';

            $events = [];
            $pageToken = null;

            do {
                $response = $service->events->listEvents($calendarId, [
                    'pageToken' => $pageToken,
                ]);

                foreach ($response->getItems() as $event) {
                    $events[] = $event;
                }

                $pageToken = $response->getNextPageToken();
            } while ($pageToken);

            Log::info('Fetched Events:', $events);

            Session::put('events', $events);

            $googleUser  = $this->client->verifyIdToken($token['id_token']);
            $email = $googleUser ['email'];

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $googleUser ['name'],
                    'google_id' => $googleUser ['sub'],
                ]
            );

            Auth::login($user);

            return redirect()->route('workspace');
        } catch (\Exception $exception) {
            Log::error("Google Authentication Error: " . $exception->getMessage());
            return redirect()->route('google.auth.calendar')->withErrors('Unable to Sync events: ' . $exception->getMessage());
        }
    }
}