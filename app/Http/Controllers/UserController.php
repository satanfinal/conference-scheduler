<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Restrict normal users from accessing admin pages
     */
    private function blockNormalUsers(): void
    {
        if (!auth()->user()->is_admin) {

            abort(
                403,
                'Only admins can manage users.'
            );
        }
    }

    /**
     * Shared validation rules for user forms
     */
    private function validationRules(User $user): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',

                Rule::unique('users')
                    ->ignore($user->id),
            ],
        ];
    }

    /**
     * Display all registered users
     */
    public function index()
    {
        // Authorization check
        $this->blockNormalUsers();

        $users = User::latest()
            ->paginate(10);

        return view(
            'users.index',
            compact('users')
        );
    }

    /**
     * Show edit user form
     */
    public function edit(User $user)
    {
        // Authorization check
        $this->blockNormalUsers();

        return view(
            'users.edit',
            compact('user')
        );
    }

    /**
     * Update user information
     */
    public function update(
        Request $request,
        User $user
    ) {
        // Authorization check
        $this->blockNormalUsers();

        // Validate incoming request
        $validated = $request->validate(
            $this->validationRules($user)
        );

        // Update user account
        $user->update([

            'name' => $validated['name'],

            'email' => $validated['email'],
        ]);

        return redirect('/users')
            ->with(
                'msg',
                'User updated successfully.'
            );
    }

    /**
     * Delete selected user
     */
    public function destroy(User $user)
    {
        // Authorization check
        $this->blockNormalUsers();

        // Prevent admin from deleting own account
        if ($user->id === auth()->id()) {

            return redirect('/users')
                ->with(
                    'error',
                    'You cannot delete your own account while logged in.'
                );
        }

        $user->delete();

        return redirect('/users')
            ->with(
                'msg',
                'User deleted successfully.'
            );
    }
}