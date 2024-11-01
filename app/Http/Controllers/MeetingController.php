<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Services\GoogleMeetService;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    protected $googleMeetService;

    public function __construct(GoogleMeetService $googleMeetService)
    {
        $this->googleMeetService = $googleMeetService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'professional_id' => 'required|exists:professionals,id',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'scheduled_at' => 'required|date',
            'duration' => 'required|integer',
        ]);

        $meeting = Meeting::create($request->all());

        $professional = $meeting->professional;
        $googleMeetLink = $this->googleMeetService->scheduleGoogleMeet(
            $professional->email,
            $request->client_name,
            $request->client_email,
            $request->scheduled_at,
            $request->duration
        );

        return redirect('/')->with('success', 'Meeting scheduled successfully! Google Meet link: ' . $googleMeetLink);
    }
}
