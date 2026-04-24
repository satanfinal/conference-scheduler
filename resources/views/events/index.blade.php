@extends('layouts.app')

@section('title', 'Conference Schedule')

@section('content')
    <div class="page-header">
        <h1>Conference Schedule</h1>
        <p>Browse all scheduled conference sessions, speakers and online meeting links.</p>
    </div>

    @if(session('msg'))
        <div class="success-box">
            {{ session('msg') }}
        </div>
    @endif

    @php
        $speakerProfile = \App\Models\Speaker::where('user_id', auth()->id())->first();
        $canCreateSession = auth()->user()->is_admin || $speakerProfile;
    @endphp

    @if($canCreateSession)
        <div class="card">
            <a class="btn" href="{{ url('/events/create') }}">Create New Session</a>
        </div>
    @endif

    <div class="card">
        @if($events->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Session</th>
                        <th>Time</th>
                        <th>Speaker</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($events as $event)
                        @php
                            $canManageThisEvent = auth()->user()->is_admin
                                || ($speakerProfile && $event->speaker_id == $speakerProfile->id);
                        @endphp

                        <tr>
                            <td>{{ $event->title }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }}
                                <br>
                                to {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                            </td>

                            <td>{{ $event->speaker->name ?? 'No speaker' }}</td>
                            <td>{{ $event->category->name ?? 'No category' }}</td>

                            <td>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <a class="btn" href="{{ url('/events/' . $event->id) }}">View</a>

                                    @if($canManageThisEvent)
                                        <a class="btn btn-secondary" href="{{ url('/events/' . $event->id . '/edit') }}">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ url('/events/' . $event->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="btn btn-danger"
                                                type="submit"
                                                onclick="return confirm('Are you sure you want to delete this session?')"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">No conference sessions have been created yet.</p>
        @endif
    </div>
@endsection