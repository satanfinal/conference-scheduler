@extends('layouts.app')

@section('title', $category->name)

@section('content')
@php
    $descriptions = [
        'Technology' => 'Sessions about software, AI, web development and digital innovation.',
        'Business' => 'Sessions about entrepreneurship, leadership, startups and business strategy.',
        'Education' => 'Sessions about learning, teaching, training and academic development.',
        'Design' => 'Sessions about UI, UX, branding, creativity and product design.',
        'Health' => 'Sessions about health technology, wellness and healthcare innovation.',
        'Marketing' => 'Sessions about digital marketing, content strategy and customer engagement.',
    ];
@endphp

<div class="page-header">
    <h1>{{ $category->name }}</h1>
    <p>{{ $descriptions[$category->name] ?? 'Browse speakers and conference sessions related to this category.' }}</p>
</div>

        <div class="card">
            <h2>Speakers in this Category</h2>

            @if($speakers->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Speaker</th>
                            <th>Topic</th>
                            <th>Email</th>
                            <th>Profile</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($speakers as $speaker)
                            <tr>
                                <td>{{ $speaker->name }}</td>
                                <td>{{ $speaker->topic }}</td>
                                <td>{{ $speaker->email ?? 'No email' }}</td>
                                <td>
                                    <a class="btn" href="{{ url('/speakers/' . $speaker->id) }}">View Speaker</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="empty">No speakers are currently assigned to this category.</p>
            @endif
        </div>

        <div class="card">
            <h2>Sessions in this Category</h2>

            @if($events->count() > 0)
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
                        @foreach($events as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y H:i') }}
                                    <br>
                                    to {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                                </td>
                                <td>{{ $event->speaker->name ?? 'No speaker' }}</td>
                                <td>
                                    <a class="btn" href="{{ url('/events/' . $event->id) }}">View Session</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="empty">No sessions are currently assigned to this category.</p>
            @endif
        </div>

        <a class="btn btn-secondary" href="{{ url('/category') }}">Back to Categories</a>
    </main>
@endsection