@extends('layouts.app')

@section('title', $speaker->name)

@section('content')
    @php
        $currentUser = auth()->user();
        $isAdmin = $currentUser->is_admin;
        $isOwnSpeakerProfile = $speaker->user_id == $currentUser->id;
        $canEditSpeaker = $isAdmin || $isOwnSpeakerProfile;
    @endphp

    <div class="page-header">
        <h1>{{ $speaker->name }}</h1>
        <p>{{ $speaker->topic }}</p>
    </div>

    @if(session('success'))
        <div class="success-box">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="error-box">{{ session('error') }}</div>
    @endif

    <div class="card" style="display: grid; grid-template-columns: 280px 1fr; gap: 32px; align-items: start;">
        <div>
            @if($speaker->photo)
                <img
                    src="{{ asset('storage/' . $speaker->photo) }}"
                    alt="{{ $speaker->name }}"
                    style="width: 280px; height: 280px; object-fit: cover; border-radius: 22px;"
                >
            @else
                <div style="width: 280px; height: 280px; background: #eef2f7; border-radius: 22px; display: flex; align-items: center; justify-content: center; color: #64748b; font-weight: 700;">
                    No Photo
                </div>
            @endif
        </div>

        <div>
            <h2>Speaker Profile</h2>

            <p><strong>Email:</strong> {{ $speaker->email ?? 'No email provided' }}</p>
            <p><strong>Track:</strong> {{ $speaker->category->name ?? 'No track' }}</p>
            <p><strong>Topic:</strong> {{ $speaker->topic }}</p>

            <h2 style="margin-top: 24px;">Bio</h2>
            <p style="line-height: 1.8; color: #64748b;">
                {{ $speaker->bio ?? 'No bio provided.' }}
            </p>

            @if($isAdmin)
                <p style="margin-top: 18px;">
                    <strong>Account Status:</strong>

                    @if($speaker->user_id)
                        <span class="user-pill">Speaker account linked</span>
                    @else
                        <span style="color: #b45309; font-weight: 700;">No speaker account yet</span>
                    @endif
                </p>
            @endif

            <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 28px;">
                <a class="btn btn-secondary" href="{{ url('/speakers') }}">Back to Speakers</a>

                @if($canEditSpeaker)
                    <a class="btn" href="{{ url('/speakers/' . $speaker->id . '/edit') }}">Edit Speaker</a>
                @endif

                @if($isAdmin && !$speaker->user_id)
                    <form method="POST" action="{{ url('/speakers/' . $speaker->id . '/create-account') }}" style="display: inline;">
                        @csrf
                        <button class="btn" type="submit">
                            Create Speaker Account
                        </button>
                    </form>
                @endif

                @if($isAdmin)
                    <form method="POST" action="{{ url('/speakers/' . $speaker->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">
                            Delete Speaker
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection