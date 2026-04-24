<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SpeakerController extends Controller
{
    private function isAdmin()
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    private function currentSpeakerProfile()
    {
        return Speaker::where('user_id', auth()->id())->first();
    }

    private function canEditSpeaker(Speaker $speaker)
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $speaker->user_id === auth()->id();
    }

    public function index()
    {
        $speakers = Speaker::with('category')->latest()->get();

        return view('speakers.index', compact('speakers'));
    }

    public function create()
    {
        if (!$this->isAdmin()) {
            abort(403, 'Only admins can add speakers.');
        }

        $categories = Category::all();

        return view('speakers.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Only admins can create speakers.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'nullable',
        ]);

        $data = $request->only([
            'name',
            'email',
            'topic',
            'bio',
            'category_id',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('speakers', 'public');
        }

        Speaker::create($data);

        return redirect('/speakers')->with('success', 'Speaker created successfully.');
    }

    public function show(Speaker $speaker)
    {
        return view('speakers.show', compact('speaker'));
    }

    public function edit(Speaker $speaker)
    {
        if (!$this->canEditSpeaker($speaker)) {
            abort(403, 'You can only edit your own speaker profile.');
        }

        $categories = Category::all();

        return view('speakers.edit', compact('speaker', 'categories'));
    }

    public function update(Request $request, Speaker $speaker)
    {
        if (!$this->canEditSpeaker($speaker)) {
            abort(403, 'You can only update your own speaker profile.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'nullable',
        ]);

        $data = $request->only([
            'name',
            'email',
            'topic',
            'bio',
            'category_id',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('speakers', 'public');
        }

        $speaker->update($data);

        return redirect('/speakers/' . $speaker->id)->with('success', 'Speaker profile updated successfully.');
    }

    public function destroy(Speaker $speaker)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Only admins can delete speakers.');
        }

        $speaker->delete();

        return redirect('/speakers')->with('success', 'Speaker deleted successfully.');
    }

    public function createAccount(Speaker $speaker)
    {
        if (!$this->isAdmin()) {
            abort(403, 'Only admins can create speaker accounts.');
        }

        if (!$speaker->email) {
            return redirect('/speakers/' . $speaker->id)
                ->with('error', 'This speaker needs an email before an account can be created.');
        }

        if ($speaker->user_id) {
            return redirect('/speakers/' . $speaker->id)
                ->with('error', 'This speaker already has an account.');
        }

        $existingUser = User::where('email', $speaker->email)->first();

        if ($existingUser) {
            $speaker->update([
                'user_id' => $existingUser->id,
            ]);

            return redirect('/speakers/' . $speaker->id)
                ->with('success', 'Existing user account linked to this speaker.');
        }

        $temporaryPassword = '123456';

        $user = User::create([
            'name' => $speaker->name,
            'email' => $speaker->email,
            'password' => Hash::make($temporaryPassword),
            'is_admin' => false,
        ]);

        $speaker->update([
            'user_id' => $user->id,
        ]);

        return redirect('/speakers/' . $speaker->id)
            ->with('success', 'Speaker account created. Temporary password: ' . $temporaryPassword);
    }
}