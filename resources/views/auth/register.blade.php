@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-card">
            <h1>Create Account</h1>
            <p>Sign up to access the conference management website.</p>

            @if($errors->any())
                <div class="error-box">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ url('/register') }}">
                @csrf

                <label for="name">Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter your full name"
                    value="{{ old('name') }}"
                    required
                >

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
                    placeholder="Create a password"
                    required
                >

                <label for="password_confirmation">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Re enter your password"
                    required
                >

                <div class="auth-actions">
                    <button class="btn" type="submit">Sign Up</button>
                    <a class="btn btn-secondary" href="{{ url('/login') }}">Already have an account?</a>
                </div>
            </form>
        </div>
    </div>
@endsection