@extends('layouts.app')

@section('title', 'Conference Scheduler')

@section('content')
    <section class="hero" style="margin-bottom: 28px;">
        <div class="hero-panel">
            <h1>Plan, manage and experience conferences beautifully.</h1>
            <p>
                Conference Scheduler helps organizers create sessions, manage speakers, organize tracks,
                and let attendees register for sessions with a polished and professional experience.
            </p>

            <div class="hero-actions">
                @auth
                    <a class="btn" href="{{ url('/dashboard') }}">Open Dashboard</a>
                    <a class="btn btn-secondary" href="{{ url('/events') }}">View Schedule</a>
                @else
                    <a class="btn" href="{{ url('/register') }}">Create Account</a>
                    <a class="btn btn-secondary" href="{{ url('/login') }}">Login</a>
                @endauth
            </div>
        </div>

        <div class="hero-mini">
            <div class="feature-card">
                <h3>Smart Session Scheduling</h3>
                <p>
                    Create, edit and manage conference sessions with date, time, meeting links,
                    speaker assignment and category mapping.
                </p>
            </div>

            <div class="feature-card">
                <h3>Speaker Management</h3>
                <p>
                    Showcase expert speakers with photos, bios, topics and categories in a polished speaker directory.
                </p>
            </div>

            <div class="feature-card">
                <h3>Attendee Friendly</h3>
                <p>
                    Let users browse sessions, discover tracks and register for talks through a clean and intuitive interface.
                </p>
            </div>
        </div>
    </section>

    <section class="card">
        <h2 class="section-title">Why choose Conference Scheduler?</h2>
        <p class="section-subtitle">
            A complete student project solution for managing modern conferences with a premium user interface.
        </p>

        <div class="grid-3">
            <div class="feature-card">
                <h3>Professional Dashboard</h3>
                <p>Separate admin and attendee dashboards make the platform feel realistic and role based.</p>
            </div>

            <div class="feature-card">
                <h3>Beautiful Session Pages</h3>
                <p>Every conference session includes schedule details, category, speaker and online meeting link.</p>
            </div>

            <div class="feature-card">
                <h3>Simple Registration</h3>
                <p>Attendees can quickly register for sessions and manage their conference experience from one place.</p>
            </div>
        </div>
    </section>

    <section class="grid-3">
        <div class="stat-card">
            <div class="stat-value">10+</div>
            <div class="stat-label">Pages designed for a complete conference workflow</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">Role Based</div>
            <div class="stat-label">Separate admin and attendee experiences</div>
        </div>

        <div class="stat-card">
            <div class="stat-value">Modern UI</div>
            <div class="stat-label">Responsive layout with premium styling and clean structure</div>
        </div>
    </section>
@endsection