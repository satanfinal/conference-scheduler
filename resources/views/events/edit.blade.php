@extends('layouts.app')

@section('title', 'Edit Conference Session')

@section('content')
    <main class="page">
        <div class="page-header">
            <h1>Edit Conference Session</h1>
            <p>Update session details, speaker, category, time and meeting link.</p>
        </div>

        <div class="card">
            @if($errors->any())
                <div class="error-box">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ url('/events/' . $event->id) }}">
                @csrf
                @method('PUT')

                <label for="title">Session Title</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $event->title) }}"
                    required
                >

                <label for="description">Session Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    required
                >{{ old('description', $event->description) }}</textarea>

                <label for="start_time">Start Date and Time</label>
                <input
                    type="datetime-local"
                    id="start_time"
                    name="start_time"
                    value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i')) }}"
                    required
                >

                <label for="end_time">End Date and Time</label>
                <input
                    type="datetime-local"
                    id="end_time"
                    name="end_time"
                    value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('Y-m-d\TH:i')) }}"
                    required
                >

                <label for="speaker_id">Speaker</label>
                <select id="speaker_id" name="speaker_id">
                    <option value="">No speaker selected</option>

                    @foreach($speakers as $speaker)
                        <option
                            value="{{ $speaker->id }}"
                            {{ old('speaker_id', $event->speaker_id) == $speaker->id ? 'selected' : '' }}
                        >
                            {{ $speaker->name }} | {{ $speaker->topic }}
                        </option>
                    @endforeach
                </select>

                <label for="category_id">Category</label>
                <select id="category_id" name="category_id">
                    <option value="">No category selected</option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <label for="meeting_link">Online Meeting Link</label>
                <input
                    type="url"
                    id="meeting_link"
                    name="meeting_link"
                    value="{{ old('meeting_link', $event->meeting_link) }}"
                    placeholder="Example: https://meet.google.com/abc-defg-hij"
                >

                <button class="btn" type="submit">Update Session</button>
                <a class="btn btn-secondary" href="{{ url('/events/' . $event->id) }}">Cancel</a>
            </form>
        </div>
    </main>
@endsection