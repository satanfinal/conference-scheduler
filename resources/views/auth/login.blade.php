@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-card">
            <h1>Login</h1>
            <p>Login to access the conference management website.</p>

            @if($errors->any())
                <div class="error-box">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
                @csrf

                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email address"
                    value="{{ old('email') }}"
                    required
                >

                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                >

                <div class="auth-actions">
                    <button class="btn" type="submit">Login</button>
                    <a class="btn btn-secondary" href="{{ url('/register') }}">Create Account</a>
                </div>
            </form>
        </div>
    </div>
@endsection