<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('lottery.results.manage');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials['email'] = strtolower(trim($credentials['email']));
        $credentials['password'] = trim($credentials['password']);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('lottery.results.manage'));
        }

        return back()
            ->withInput(['email' => $credentials['email']])
            ->withErrors(['email' => 'Invalid email or password.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('lottery.results');
    }

    public function showAccount()
    {
        return view('auth.account', [
            'user' => Auth::user(),
            'users' => User::orderBy('name')->get(['id', 'name', 'email']),
        ]);
    }

    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'required|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!Auth::guard('web')->validate([
            'email' => $user->email,
            'password' => $validated['current_password'],
        ])) {
            return back()
                ->withInput($request->only('name', 'email'))
                ->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->name = trim($validated['name']);
        $user->email = strtolower(trim($validated['email']));

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return back()->with('success', 'Account updated successfully.');
    }

    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'new_name' => 'required|string|max:255',
            'new_email' => 'required|email|max:255|unique:users,email',
            'new_password' => 'required|string|min:6|confirmed',
        ], [], [
            'new_name' => 'name',
            'new_email' => 'email',
            'new_password' => 'password',
        ]);

        User::create([
            'name' => trim($validated['new_name']),
            'email' => strtolower(trim($validated['new_email'])),
            'password' => $validated['new_password'],
        ]);

        return back()->with('success', 'User created successfully.');
    }

    public function deleteUser($id)
    {
        $userToDelete = User::findOrFail($id);

        if ((int) $userToDelete->id === (int) Auth::id()) {
            return back()->withErrors(['email' => 'You cannot remove your own account.']);
        }

        $name = $userToDelete->name;
        $userToDelete->delete();

        return back()->with('success', "User \"{$name}\" removed successfully.");
    }
}
