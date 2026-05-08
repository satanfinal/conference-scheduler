@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

    @php
        // Get all speaker user IDs for role detection
        $speakerUserIds = \App\Models\Speaker::pluck('user_id');
    @endphp

    <main class="page">

        {{-- Dashboard header --}}
        <div class="page-header">
            <h1>Admin Dashboard</h1>

            <p>
                Welcome back, {{ auth()->user()->name }}.
                Manage sessions, speakers, tracks and users from here.
            </p>
        </div>

        {{-- System statistics cards --}}
        <div
            style="
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 20px;
                margin-bottom: 24px;
            "
        >

            <div class="card">
                <h2 style="font-size: 34px; margin: 0;">
                    {{ $totalEvents }}
                </h2>

                <p style="color: #6b7280; margin-bottom: 0;">
                    Sessions
                </p>
            </div>

            <div class="card">
                <h2 style="font-size: 34px; margin: 0;">
                    {{ $totalSpeakers }}
                </h2>

                <p style="color: #6b7280; margin-bottom: 0;">
                    Speakers
                </p>
            </div>

            <div class="card">
                <h2 style="font-size: 34px; margin: 0;">
                    {{ $totalCategories }}
                </h2>

                <p style="color: #6b7280; margin-bottom: 0;">
                    Tracks
                </p>
            </div>

            <div class="card">
                <h2 style="font-size: 34px; margin: 0;">
                    {{ $totalUsers }}
                </h2>

                <p style="color: #6b7280; margin-bottom: 0;">
                    Users
                </p>
            </div>

            <div class="card">
                <h2 style="font-size: 34px; margin: 0;">
                    {{ $totalRsvps }}
                </h2>

                <p style="color: #6b7280; margin-bottom: 0;">
                    RSVPs
                </p>
            </div>
        </div>

        {{-- Quick actions section --}}
        <div class="card">

            <h2>Admin Quick Actions</h2>

            <div style="display: flex; gap: 12px; flex-wrap: wrap;">

                <a class="btn" href="{{ url('/events/create') }}">
                    Create Session
                </a>

                <a class="btn" href="{{ url('/speakers/create') }}">
                    Add Speaker
                </a>

                <a class="btn" href="{{ url('/users') }}">
                    Manage Users
                </a>

                <a class="btn btn-secondary" href="{{ url('/category') }}">
                    View Tracks
                </a>

            </div>
        </div>

        {{-- Dashboard tables --}}
        <div
            style="
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            "
        >

            {{-- Latest sessions --}}
            <div class="card">

                <h2>Latest Sessions</h2>

                @if($latestEvents->count() > 0)

                    <table>

                        <thead>
                            <tr>
                                <th>Session</th>
                                <th>Time</th>
                                <th>Details</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($latestEvents as $event)

                                <tr>

                                    <td>
                                        {{ $event->title ?? 'Untitled Session' }}
                                    </td>

                                    <td>

                                        @if($event->start_time)

                                            {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }}

                                        @else

                                            No time

                                        @endif

                                    </td>

                                    <td>

                                        <a class="btn" href="{{ url('/events/' . $event->id) }}">
                                            View
                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <p class="empty">
                        No sessions have been created yet.
                    </p>

                @endif

            </div>

            {{-- Latest users --}}
            <div class="card">

                <h2>Latest Users</h2>

                @if($latestUsers->count() > 0)

                    <table>

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($latestUsers as $user)

                                @php
                                    // Detect user role
                                    $role = 'Attendee';

                                    if ($user->is_admin) {
                                        $role = 'Admin';
                                    } elseif ($speakerUserIds->contains($user->id)) {
                                        $role = 'Speaker';
                                    }
                                @endphp

                                <tr>

                                    <td>{{ $user->name }}</td>

                                    <td>{{ $user->email }}</td>

                                    <td>

                                        @if($role === 'Admin')

                                            <span class="user-pill">
                                                Admin
                                            </span>

                                        @elseif($role === 'Speaker')

                                            <span
                                                style="
                                                    background: #ede9fe;
                                                    color: #6d28d9;
                                                    padding: 6px 10px;
                                                    border-radius: 999px;
                                                    font-weight: 700;
                                                "
                                            >
                                                Speaker
                                            </span>

                                        @else

                                            <span
                                                style="
                                                    background: #f1f5f9;
                                                    color: #475569;
                                                    padding: 6px 10px;
                                                    border-radius: 999px;
                                                    font-weight: 700;
                                                "
                                            >
                                                Attendee
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <p class="empty">
                        No users found.
                    </p>

                @endif

            </div>

        </div>

        {{-- Latest speakers section --}}
        <div class="card">

            <h2>Latest Speakers</h2>

            @if($latestSpeakers->count() > 0)

                <table>

                    <thead>
                        <tr>
                            <th>Speaker</th>
                            <th>Topic</th>
                            <th>Track</th>
                            <th>Profile</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($latestSpeakers as $speaker)

                            <tr>

                                <td>{{ $speaker->name }}</td>

                                <td>{{ $speaker->topic }}</td>

                                <td>
                                    {{ $speaker->category->name ?? 'No track' }}
                                </td>

                                <td>

                                    <a
                                        class="btn"
                                        href="{{ url('/speakers/' . $speaker->id) }}"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <p class="empty">
                    No speakers have been created yet.
                </p>

            @endif

        </div>

    </main>

@endsection