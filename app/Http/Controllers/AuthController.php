<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login page
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle user login request
     */
    public function login(Request $request)
    {
        // Validate login input
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
            ],
        ]);

        // Attempt login with provided credentials
        if (Auth::attempt($credentials)) {

            // Regenerate session to protect against session fixation
            $request->session()->regenerate();

            return redirect('/dashboard')
                ->with(
                    'msg',
                    'Login successful.'
                );
        }

        return back()
            ->withErrors([
                'email' => 'Invalid email or password.',
            ])
            ->onlyInput('email');
    }

    /**
     * Show the registration page
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle new user registration
     */
    public function register(Request $request)
    {
        // Validate registration input
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);

        // Create attendee account
        $user = User::create([
            'name' => $validated['name'],

            'email' => $validated['email'],

            // Password is hashed before being stored
            'password' => Hash::make(
                $validated['password']
            ),
        ]);

        // Automatically login after successful registration
        Auth::login($user);

        // Regenerate session after login for security
        $request->session()->regenerate();

        return redirect('/dashboard')
            ->with(
                'msg',
                'Account created successfully.'
            );
    }

    /**
     * Logout current user and clear session data
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate current session
        $request->session()->invalidate();

        // Generate new CSRF token
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with(
                'msg',
                'You have logged out successfully.'
            );
    }
}