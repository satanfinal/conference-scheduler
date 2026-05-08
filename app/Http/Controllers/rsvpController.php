<?php

namespace App\Http\Controllers;

use App\Models\RSVP;
use App\Models\Event;

class RSVPController extends Controller
{
    /**
     * Prevent admins from registering for sessions
     */
    private function blockAdmins(): void
    {
        if (auth()->user()->is_admin) {

            abort(
                403,
                'Admins do not need to register for sessions.'
            );
        }
    }

    /**
     * Register attendee for conference session
     */
    public function store(Event $event)
    {
        // Authorization check
        $this->blockAdmins();

        // Prevent duplicate registrations
        RSVP::firstOrCreate([

            'user_id' => auth()->id(),

            'event_id' => $event->id,
        ]);

        return redirect('/events/' . $event->id)
            ->with(
                'msg',
                'You have registered for this session.'
            );
    }

    /**
     * Cancel attendee session registration
     */
    public function destroy(Event $event)
    {
        // Authorization check
        $this->blockAdmins();

        // Remove RSVP registration
        RSVP::where(
                'user_id',
                auth()->id()
            )
            ->where(
                'event_id',
                $event->id
            )
            ->delete();

        return redirect('/events/' . $event->id)
            ->with(
                'msg',
                'Your registration has been cancelled.'
            );
    }
}