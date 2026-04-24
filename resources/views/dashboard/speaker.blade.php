@extends('layouts.app')

@section('title', 'Speaker Dashboard')

@section('content')
    <div class="page-header">
        <h1>Speaker Dashboard</h1>
        <p>
            Welcome back, {{ auth()->user()->name }}. Manage your speaker profile,
            hosted sessions and attendee engagement.
        </p>
    </div>

    <div class="grid-3" style="margin-bottom: 24px;">
        <div class="stat-card">
            <div class="stat-value">{{ $totalHostedEvents }}</div>
            <div class="stat-label">Sessions Hosted</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">{{ $totalAttendees }}</div>
            <div class="stat-label">Total Registered Attendees</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">{{ $upcomingHostedEvents->count() }}</div>
            <div class="stat-label">Upcoming Sessions</div>
        </div>
    </div>

    <div class="card">
        <h2>Speaker Quick Actions</h2>

        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a class="btn" href="{{ url('/speakers/' . $speakerProfile->id) }}">View My Profile</a>
            <a class="btn btn-secondary" href="{{ url('/speakers/' . $speakerProfile->id . '/edit') }}">Edit My Profile</a>
            <a class="btn" href="{{ url('/events/create') }}">Create New Session</a>
            <a class="btn btn-secondary" href="{{ url('/events') }}">View Schedule</a>
        </div>
    </div>

    <div class="card">
        <h2>Upcoming Hosted Sessions</h2>

        @if($upcomingHostedEvents->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Session</th>
                        <th>Time</th>
                        <th>Track</th>
                        <th>Details</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($upcomingHostedEvents as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }}
                                <br>
                                to {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                            </td>
                            <td>{{ $event->category->name ?? 'No track' }}</td>
                            <td>
                                <a class="btn" href="{{ url('/events/' . $event->id) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">You do not have any upcoming hosted sessions yet.</p>
        @endif
    </div>

    <div class="card">
        <h2>All My Sessions</h2>

        @if($hostedEvents->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Session</th>
                        <th>Time</th>
                        <th>Registered Attendees</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($hostedEvents as $event)
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }}
                                <br>
                                to {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                            </td>
                            <td>
                                {{ \App\Models\RSVP::where('event_id', $event->id)->count() }}
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <a class="btn" href="{{ url('/events/' . $event->id) }}">View</a>
                                    <a class="btn btn-secondary" href="{{ url('/events/' . $event->id . '/edit') }}">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">You have not hosted any sessions yet.</p>
        @endif
    </div>
@endsection