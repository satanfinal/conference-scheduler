<?php

namespace App\Http\Controllers;

use App\Models\RSVP;
use App\Models\Event;
use Illuminate\Http\Request;

class rsvpController extends Controller
{
    public function store($eventId)
    {
        if (auth()->user()->is_admin) {
            abort(403, 'Admins do not need to register for sessions.');
        }

        $event = Event::findOrFail($eventId);

        RSVP::firstOrCreate([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
        ]);

        return redirect('/events/' . $event->id)->with('msg', 'You have registered for this session.');
    }

    public function destroy($eventId)
    {
        if (auth()->user()->is_admin) {
            abort(403, 'Admins do not need to cancel session registration.');
        }

        RSVP::where('user_id', auth()->id())
            ->where('event_id', $eventId)
            ->delete();

        return redirect('/events/' . $eventId)->with('msg', 'Your registration has been cancelled.');
    }
}