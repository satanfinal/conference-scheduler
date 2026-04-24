@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
    <div class="page-header">
        <h1>Manage Users</h1>
        <p>View registered attendees, speakers, update account details and manage admin access.</p>
    </div>

    @if(session('msg'))
        <div class="success-box">
            {{ session('msg') }}
        </div>
    @endif

    @if(session('error'))
        <div class="error-box">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        @if($users->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                        @php
                            $speakerProfile = \App\Models\Speaker::where('user_id', $user->id)->first();
                        @endphp

                        <tr>
                            <td>
                                <strong>{{ $user->name }}</strong>

                                @if($user->id === auth()->id())
                                    <div style="color: #64748b; font-size: 13px; margin-top: 4px;">
                                        Current account
                                    </div>
                                @endif
                            </td>

                            <td>{{ $user->email }}</td>

                            <td>
                                @if($user->is_admin)
                                    <span style="background: #dbeafe; color: #1d4ed8; padding: 6px 10px; border-radius: 999px; font-weight: 700;">
                                        Admin
                                    </span>
                                @elseif($speakerProfile)
                                    <span style="background: #dcfce7; color: #166534; padding: 6px 10px; border-radius: 999px; font-weight: 700;">
                                        Speaker
                                    </span>
                                @else
                                    <span style="background: #f1f5f9; color: #475569; padding: 6px 10px; border-radius: 999px; font-weight: 700;">
                                        Attendee
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $user->created_at ? $user->created_at->format('M d, Y') : 'Unknown' }}
                            </td>

                            <td>
                                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                    <a class="btn" href="{{ url('/users/' . $user->id . '/edit') }}">
                                        Edit
                                    </a>

                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ url('/users/' . $user->id) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger"
                                                onclick="return confirm('Delete this user account?')"
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
            <p class="empty">No users found.</p>
        @endif
    </div>
@endsection