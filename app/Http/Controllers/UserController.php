<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function blockNormalUsers()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Only admins can manage users.');
        }
    }

    public function index()
    {
        $this->blockNormalUsers();

        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    public function edit($id)
    {
        $this->blockNormalUsers();

        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->blockNormalUsers();

        $user = User::findOrFail($id);

        $request->validate([
    'name' => 'required|string|max:255',
    'email' => [
        'required',
        'email',
        Rule::unique('users')->ignore($user->id),
    ],
]);

        $user->update([
    'name' => $request->name,
    'email' => $request->email,
]);

        return redirect('/users')->with('msg', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $this->blockNormalUsers();

        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect('/users')->with('error', 'You cannot delete your own account while logged in.');
        }

        $user->delete();

        return redirect('/users')->with('msg', 'User deleted successfully.');
    }
}