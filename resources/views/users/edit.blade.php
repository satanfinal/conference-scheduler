@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    @php
        $speakerProfile = \App\Models\Speaker::where('user_id', $user->id)->first();

        if ($user->is_admin) {
            $role = 'Admin';
        } elseif ($speakerProfile) {
            $role = 'Speaker';
        } else {
            $role = 'Attendee';
        }
    @endphp

    <div class="page-header">
        <h1>Edit User</h1>
        <p>Update user account information. Roles are assigned automatically by the system.</p>
    </div>

    <div class="card">
        @if($errors->any())
            <div class="error-box">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ url('/users/' . $user->id) }}">
            @csrf
            @method('PUT')

            <label for="name">Full Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                required
            >

            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                required
            >

            <label>User Role</label>
            <div style="background: #f8fafc; border: 1px solid #dbe4ef; border-radius: 14px; padding: 14px 16px; margin-top: 8px; margin-bottom: 18px;">
                <strong>{{ $role }}</strong>
                <div style="color: #64748b; font-size: 14px; margin-top: 6px;">
                    Roles are not edited here. Speaker accounts are created from speaker profiles. Admin access is controlled separately.
                </div>
            </div>

            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button class="btn" type="submit">Update User</button>
                <a class="btn btn-secondary" href="{{ url('/users') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection