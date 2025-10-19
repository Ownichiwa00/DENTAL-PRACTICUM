<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use function view;
use function redirect;

class AuthController extends Controller
{
    /**
     * Show the change password form
     *
     * @return View
     */
    public function showChangePassword(): View
    {
        return view('auth.change-password');
    }

    /**
     * Update the authenticated user's password
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/'
            ],
        ], [
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Please login to change your password.']);
        }

        /** @var User $user */
        $user = Auth::user();

        // Verify current password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors([
                'current_password' => 'The current password is incorrect.'
            ]);
        }

        // Update password
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('password.change')
            ->with('success', 'Password updated successfully!');
    }
}
