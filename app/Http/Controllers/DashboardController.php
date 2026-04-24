<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\User;
use App\Models\RSVP;
use App\Models\Speaker;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_admin) {
            $totalEvents = Event::count();
            $totalCategories = Category::count();
            $totalUsers = User::count();
            $totalRsvps = RSVP::count();
            $totalSpeakers = Speaker::count();

            $latestEvents = Event::latest()->take(5)->get();
            $latestSpeakers = Speaker::with('category')->latest()->take(5)->get();
            $latestUsers = User::latest()->take(5)->get();

            return view('dashboard.admin', compact(
                'totalEvents',
                'totalCategories',
                'totalUsers',
                'totalRsvps',
                'totalSpeakers',
                'latestEvents',
                'latestSpeakers',
                'latestUsers'
            ));
        }

        $speakerProfile = auth()->user()->speakerProfile;

if ($speakerProfile) {
    $hostedEvents = Event::with(['category'])
        ->where('speaker_id', $speakerProfile->id)
        ->orderBy('start_time', 'asc')
        ->get();

    $hostedEventIds = $hostedEvents->pluck('id');

    $totalHostedEvents = $hostedEvents->count();

    $totalAttendees = RSVP::whereIn('event_id', $hostedEventIds)->count();

    $upcomingHostedEvents = Event::with(['category'])
        ->where('speaker_id', $speakerProfile->id)
        ->where('start_time', '>=', now())
        ->orderBy('start_time', 'asc')
        ->take(5)
        ->get();

    return view('dashboard.speaker', compact(
        'speakerProfile',
        'hostedEvents',
        'totalHostedEvents',
        'totalAttendees',
        'upcomingHostedEvents'
    ));
}

      $myRsvps = RSVP::with('event.speaker', 'event.category')
    ->where('user_id', auth()->id())
    ->latest()
    ->get();

$availableEvents = Event::with(['speaker', 'category'])
    ->orderBy('start_time', 'asc')
    ->take(6)
    ->get();

$recommendedSpeakers = Speaker::with('category')
    ->latest()
    ->take(5)
    ->get();

return view('dashboard.user', compact(
    'myRsvps',
    'availableEvents',
    'recommendedSpeakers'
));
    }
}