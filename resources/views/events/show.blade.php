@extends('layouts.app')

@section('title', $event->title)

@section('content')
    @php
        $speakerProfile = \App\Models\Speaker::where('user_id', auth()->id())->first();

        $canManageThisEvent = auth()->user()->is_admin
            || ($speakerProfile && $event->speaker_id == $speakerProfile->id);

        $isRegistered = \App\Models\RSVP::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->exists();

        $isAttendee = !auth()->user()->is_admin && !$speakerProfile;
    @endphp

    <div class="page-header">
        <h1>{{ $event->title }}</h1>
        <p>Conference session details and schedule information.</p>
    </div>

    @if(session('msg'))
        <div class="success-box">
            {{ session('msg') }}
        </div>
    @endif

    <div class="card">
        <h2>Session Information</h2>

        <p><strong>Description:</strong> {{ $event->description }}</p>

        <p>
            <strong>Start Time:</strong>
            {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }}
        </p>

        <p>
            <strong>End Time:</strong>
            {{ \Carbon\Carbon::parse($event->end_time)->format('M d, Y H:i') }}
        </p>

        <p><strong>Speaker:</strong> {{ $event->speaker->name ?? 'No speaker assigned' }}</p>

        <p><strong>Category:</strong> {{ $event->category->name ?? 'No category assigned' }}</p>

        @if($event->meeting_link)
            <p>
                <strong>Online Meeting:</strong>
                <a class="btn" href="{{ $event->meeting_link }}" target="_blank">Join Meeting</a>
            </p>
        @else
            <p><strong>Online Meeting:</strong> No meeting link provided.</p>
        @endif

        @if($isAttendee)
            <div style="margin-top: 24px;">
                @if($isRegistered)
                    <p style="color: #166534; font-weight: bold; margin-bottom: 12px;">
                        You are registered for this session.
                    </p>

                    <form method="POST" action="{{ url('/events/' . $event->id . '/rsvp') }}">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger" type="submit">
                            Cancel Registration
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ url('/events/' . $event->id . '/rsvp') }}">
                        @csrf

                        <button class="btn" type="submit">
                            Register for this Session
                        </button>
                    </form>
                @endif
            </div>
        @endif

        <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 28px;">
            <a class="btn btn-secondary" href="{{ url('/events') }}">Back to Schedule</a>

            @if($canManageThisEvent)
                <a class="btn" href="{{ url('/events/' . $event->id . '/edit') }}">Edit Session</a>

                <form method="POST" action="{{ url('/events/' . $event->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')

                    <button
                        class="btn btn-danger"
                        type="submit"
                        onclick="return confirm('Delete this session?')"
                    >
                        Delete Session
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection