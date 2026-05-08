<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\User;
use App\Models\RSVP;
use App\Models\Speaker;

class DashboardController extends Controller
{
    /**
     * Display dashboard depending on user role
     */
    public function index()
    {
        // Admin dashboard
        if (auth()->user()->is_admin) {

            return $this->adminDashboard();
        }

        // Speaker dashboard
        $speakerProfile = auth()->user()->speakerProfile;

        if ($speakerProfile) {

            return $this->speakerDashboard(
                $speakerProfile
            );
        }

        // Default attendee dashboard
        return $this->attendeeDashboard();
    }

    /**
     * Display administrator dashboard
     */
    private function adminDashboard()
    {
        // System statistics
        $totalEvents = Event::count();

        $totalCategories = Category::count();

        $totalUsers = User::count();

        $totalRsvps = RSVP::count();

        $totalSpeakers = Speaker::count();

        // Latest system activity
        $latestEvents = Event::latest()
            ->take(5)
            ->get();

        $latestSpeakers = Speaker::with('category')
            ->latest()
            ->take(5)
            ->get();

        $latestUsers = User::latest()
            ->take(5)
            ->get();

        return view(
            'dashboard.admin',
            compact(
                'totalEvents',
                'totalCategories',
                'totalUsers',
                'totalRsvps',
                'totalSpeakers',
                'latestEvents',
                'latestSpeakers',
                'latestUsers'
            )
        );
    }

    /**
     * Display speaker dashboard
     */
    private function speakerDashboard($speakerProfile)
    {
        // All hosted sessions
        $hostedEvents = Event::with([
                'category'
            ])
            ->where(
                'speaker_id',
                $speakerProfile->id
            )
            ->orderBy('start_time', 'asc')
            ->get();

        // Hosted session IDs
        $hostedEventIds = $hostedEvents
            ->pluck('id');

        // Total hosted sessions
        $totalHostedEvents = $hostedEvents
            ->count();

        // Total attendee registrations
        $totalAttendees = RSVP::whereIn(
                'event_id',
                $hostedEventIds
            )
            ->count();

        // Upcoming hosted sessions
        $upcomingHostedEvents = Event::with([
                'category'
            ])
            ->where(
                'speaker_id',
                $speakerProfile->id
            )
            ->where(
                'start_time',
                '>=',
                now()
            )
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();

        return view(
            'dashboard.speaker',
            compact(
                'speakerProfile',
                'hostedEvents',
                'totalHostedEvents',
                'totalAttendees',
                'upcomingHostedEvents'
            )
        );
    }

    /**
     * Display attendee dashboard
     */
    private function attendeeDashboard()
    {
        // User registrations
        $myRsvps = RSVP::with([
                'event.speaker',
                'event.category'
            ])
            ->where(
                'user_id',
                auth()->id()
            )
            ->latest()
            ->get();

        // Available sessions
        $availableEvents = Event::with([
                'speaker',
                'category'
            ])
            ->orderBy('start_time', 'asc')
            ->take(6)
            ->get();

        // Recommended speakers
        $recommendedSpeakers = Speaker::with([
                'category'
            ])
            ->latest()
            ->take(5)
            ->get();

        return view(
            'dashboard.user',
            compact(
                'myRsvps',
                'availableEvents',
                'recommendedSpeakers'
            )
        );
    }
}