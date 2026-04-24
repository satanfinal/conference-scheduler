@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <h1>Dashboard</h1>
        <p>Overview of events, users, categories and RSVPs.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px;">
        <div class="card">
            <h2>{{ $totalEvents }}</h2>
            <p>Total Events</p>
        </div>

        <div class="card">
            <h2>{{ $totalCategories }}</h2>
            <p>Total Categories</p>
        </div>

        <div class="card">
            <h2>{{ $totalUsers }}</h2>
            <p>Total Users</p>
        </div>

        <div class="card">
            <h2>{{ $totalRsvps }}</h2>
            <p>Total RSVPs</p>
        </div>
    </div>

    <div class="card">
        <h2>Latest Events</h2>

        @if($latestEvents->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Location</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($latestEvents as $event)
                        <tr>
                            <td>{{ $event->title ?? $event->name ?? 'Untitled Event' }}</td>
                            <td>{{ $event->date ?? $event->event_date ?? 'No date' }}</td>
                            <td>{{ $event->location ?? 'No location' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">No events found.</p>
        @endif
    </div>
@endsection