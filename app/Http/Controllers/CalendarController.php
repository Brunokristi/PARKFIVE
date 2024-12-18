<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Calendar;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    public function showEvents()
    {
        // Path to your service account key file
        $keyFilePath = env('GOOGLE_APPLICATION_CREDENTIALS', storage_path('app/credentials.json'));

        $client = new Client();
        $client->setAuthConfig($keyFilePath);
        $client->addScope(Calendar::CALENDAR_READONLY);
        
        $service = new Calendar($client);

        $calendarIdsApt1 = [
            #apt 1
            '4ao7jf4th85a6drtjfsl8knaf79hvu9o@import.calendar.google.com',
            'fea04fdb7d521fe8d9e33bb4a13659a6e27fef0f9d724ce1dca5b51659e96bd8@group.calendar.google.com',
        ];

        $calendarIdsApt2 = [
            #apt 2
            '6lglv41endm9auti5slcnmss9n7p72cr@import.calendar.google.com',
            'e8c14f73fe62415e5a831ec552cdbd6a54f25230c155a623f8ae7632c34a627c@group.calendar.google.com',
        ];

        $eventsApt1 = [];
        $eventsApt2 = [];

        foreach ($calendarIdsApt1 as $calendarId) {
            // Fetch events from each calendar
            $events = $service->events->listEvents($calendarId, [
                'maxResults' => 10,
                'orderBy' => 'startTime',
                'singleEvents' => true,
            ])->getItems();

            foreach ($events as $event) {
                $eventsApt1[] = $event; 
            }
        }

        foreach ($calendarIdsApt2 as $calendarId) {
            // Fetch events from each calendar
            $events = $service->events->listEvents($calendarId, [
                'maxResults' => 10,
                'orderBy' => 'startTime',
                'singleEvents' => true,
            ])->getItems();

            foreach ($events as $event) {
                $eventsApt2[] = $event; 
            }
        }

        return view('calendar', ['eventsApt1' => $eventsApt1, 'eventsApt2' => $eventsApt2]);
    }
}
