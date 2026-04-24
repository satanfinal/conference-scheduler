@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
    <main class="page">
        <div class="page-header">
            <h1>My Dashboard</h1>
            <p>Welcome back, {{ auth()->user()->name }}. Browse upcoming events and discover conference speakers.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px;">
            <div class="card">
    <h2 style="font-size: 34px; margin: 0;">{{ $myRsvps->count() }}</h2>
    <p style="color: #6b7280; margin-bottom: 0;">Registered Sessions</p>
</div>
<div class="card">
    <h2>My Registered Sessions</h2>

    @if($myRsvps->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Session</th>
                    <th>Time</th>
                    <th>Speaker</th>
                    <th>Details</th>
                </tr>
            </thead>

            <tbody>
                @foreach($myRsvps as $rsvp)
                    @if($rsvp->event)
                        <tr>
                            <td>{{ $rsvp->event->title }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($rsvp->event->start_time)->format('M d, Y H:i') }}
                                <br>
                                to {{ \Carbon\Carbon::parse($rsvp->event->end_time)->format('H:i') }}
                            </td>
                            <td>{{ $rsvp->event->speaker->name ?? 'No speaker' }}</td>
                            <td>
                                <a class="btn" href="{{ url('/events/' . $rsvp->event->id) }}">View Session</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <p class="empty">You have not registered for any sessions yet.</p>
    @endif
</div>

            <div class="card">
                <h2 style="font-size: 34px; margin: 0;">{{ $availableEvents->count() }}</h2>
                <p style="color: #6b7280; margin-bottom: 0;">Available Events</p>
            </div>

            <div class="card">
                <h2 style="font-size: 34px; margin: 0;">{{ $recommendedSpeakers->count() }}</h2>
                <p style="color: #6b7280; margin-bottom: 0;">Recommended Speakers</p>
            </div>
        </div>

        <div class="card">
            <h2>Available Events</h2>

            @if($availableEvents->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Details</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($availableEvents as $event)
                            <tr>
                                <td>{{ $event->title ?? $event->name ?? 'Untitled Event' }}</td>
                                <td>{{ $event->date ?? $event->event_date ?? 'No date' }}</td>
                                <td>
                                    <a class="btn" href="{{ url('/events/' . $event->id) }}">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="empty">No events available yet.</p>
            @endif
        </div>

        <div class="card">
            <h2>Recommended Speakers</h2>

            @if($recommendedSpeakers->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Speaker</th>
                            <th>Topic</th>
                            <th>Category</th>
                            <th>Profile</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($recommendedSpeakers as $speaker)
                            <tr>
                                <td>{{ $speaker->name }}</td>
                                <td>{{ $speaker->topic }}</td>
                                <td>{{ $speaker->category->name ?? 'No category' }}</td>
                                <td>
                                    <a class="btn" href="{{ url('/speakers/' . $speaker->id) }}">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="empty">No speakers available yet.</p>
            @endif
        </div>
    </main>
@endsection