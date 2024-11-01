<?php
namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;

class GoogleMeetService
{
    public function scheduleGoogleMeet($professionalEmail, $clientName, $clientEmail, $scheduledAt, $duration)
    {
        // Initialize the Google Client
        $client = new Client();
        $client->setAuthConfig(storage_path('app/credentials.json'));
        $client->addScope(Calendar::CALENDAR);
        $client->setSubject('sander@konstruktiv.nl'); // Replace with an email address in your domain

        // Initialize the Calendar service
        $service = new Calendar($client);

        // Create a new event
        $event = new Event([
            'summary' => 'Meeting with ' . $clientName,
            'description' => 'E-consult with ' . $clientName,
            'start' => new EventDateTime([
                'dateTime' => date('c', strtotime($scheduledAt)),
                'timeZone' => 'UTC',
            ]),
            'end' => new EventDateTime([
                'dateTime' => date('c', strtotime($scheduledAt . ' + ' . $duration . ' minutes')),
                'timeZone' => 'UTC',
            ]),
            'attendees' => [
                ['email' => $professionalEmail],
                ['email' => $clientEmail],
            ],
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => uniqid(),
                    'conferenceSolutionKey' => [
                        'type' => 'hangoutsMeet',
                    ],
                ],
            ],
        ]);

        // Set conference data version
        $optParams = ['conferenceDataVersion' => 1, 'sendUpdates' => 'all'];

        try {
            // Insert the event into the calendar
            $calendarId = 'primary';
            $event = $service->events->insert($calendarId, $event, $optParams);
            return $event->htmlLink;
        } catch (\Exception $e) {
            // Handle error
            return 'Error: ' . $e->getMessage();
        }
    }
}
