@extends('layouts.app')

@section('title', 'Speakers')

@section('content')
    <main class="page">
        <div class="page-header">
            <h1>Conference Speakers</h1>
            <p>Meet the speakers leading sessions across different conference tracks.</p>
        </div>

        @if(auth()->user()->is_admin)
            <div class="card">
                <a class="btn" href="{{ url('/speakers/create') }}">Add New Speaker</a>
            </div>
        @endif

        @if($speakers->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                @foreach($speakers as $speaker)
                    <div class="card">
                        @if($speaker->photo)
                            <img
                                src="{{ asset('storage/' . $speaker->photo) }}"
                                alt="{{ $speaker->name }}"
                                style="width: 100%; height: 220px; object-fit: cover; border-radius: 12px; margin-bottom: 16px;"
                            >
                        @else
                            <div style="height: 220px; background: #e5e7eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #6b7280; margin-bottom: 16px;">
                                No Photo
                            </div>
                        @endif

                        <h2 style="margin-bottom: 8px;">{{ $speaker->name }}</h2>

                        <p style="color: #2563eb; font-weight: bold;">
                            {{ $speaker->topic }}
                        </p>

                        <p>
                            <strong>Category:</strong>
                            {{ $speaker->category->name ?? 'No category' }}
                        </p>

                       <div style="display: flex; gap: 10px; flex-wrap: wrap;">
    <a class="btn" href="{{ url('/speakers/' . $speaker->id) }}">View Profile</a>

    @if(auth()->user()->is_admin)
        <a class="btn btn-secondary" href="{{ url('/speakers/' . $speaker->id . '/edit') }}">Edit</a>

        <form method="POST" action="{{ url('/speakers/' . $speaker->id) }}" style="display: inline;">
            @csrf
            @method('DELETE')

            <button
                class="btn btn-danger"
                type="submit"
                onclick="return confirm('Are you sure you want to delete this speaker?')"
            >
                Delete
            </button>
        </form>
    @endif
</div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <p class="empty">No speakers found.</p>
            </div>
        @endif
    </main>
@endsection