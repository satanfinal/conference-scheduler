@extends('layouts.app')

@section('title', 'Create Conference Session')

@section('content')
    <main class="page">
        <div class="page-header">
            <h1>Create Conference Session</h1>
            <p>Add a scheduled session with speaker, category, time and online meeting link.</p>
        </div>

        <div class="card">
            @if($errors->any())
                <div class="error-box">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ url('/events') }}">
                @csrf

                <label for="title">Session Title</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    placeholder="Example: Future of AI in Business"
                    value="{{ old('title') }}"
                    required
                >

                <label for="description">Session Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                    placeholder="Describe what this session is about"
                    required
                >{{ old('description') }}</textarea>

                <label for="start_time">Start Date and Time</label>
                <input
                    type="datetime-local"
                    id="start_time"
                    name="start_time"
                    value="{{ old('start_time') }}"
                    required
                >

                <label for="end_time">End Date and Time</label>
                <input
                    type="datetime-local"
                    id="end_time"
                    name="end_time"
                    value="{{ old('end_time') }}"
                    required
                >

                <label for="speaker_id">Speaker</label>
                <select id="speaker_id" name="speaker_id">
                    <option value="">No speaker selected</option>
                    @foreach($speakers as $speaker)
                        <option value="{{ $speaker->id }}" {{ old('speaker_id') == $speaker->id ? 'selected' : '' }}>
                            {{ $speaker->name }} - {{ $speaker->topic }}
                        </option>
                    @endforeach
                </select>

                <label for="category_id">Category</label>
                <select id="category_id" name="category_id">
                    <option value="">No category selected</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <label for="meeting_link">Online Meeting Link</label>
                <input
                    type="url"
                    id="meeting_link"
                    name="meeting_link"
                    placeholder="Example: https://meet.google.com/abc-defg-hij"
                    value="{{ old('meeting_link') }}"
                >

                <button class="btn" type="submit">Create Session</button>
                <a class="btn btn-secondary" href="{{ url('/events') }}">Cancel</a>
            </form>
        </div>
    </main>
@endsection