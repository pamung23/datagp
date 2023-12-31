<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // Attempt login using either email or username
        if (
            Auth::attempt(['email' => $request->username, 'password' => $request->password])
            || Auth::attempt(['username' => $request->username, 'password' => $request->password])
        ) {
            // Authentication passed...
            $user = Auth::user();
            User::where('id', $user->id)->update(['last_login' => now()]);
            // Redirect based on user level
            $allowedLevels = ['Admin', 'Balai', 'Wilayah Cianjur', 'Wilayah Sukabumi', 'Wilayah Bogor'];

            if (in_array($user->level, $allowedLevels)) {
                return redirect()->intended(route('dashboard'));
            } else {
                // Default case
                return redirect()->intended(route('dashboard'));
            }
        }

        // Check if the username or email exists in the database
        $user = User::where('email', $request->username)
            ->orWhere('username', $request->username)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'User Tidak Di Ketahui.',
            ]);
        }

        // Check if the password is incorrect
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Salah Password.',
            ]);
        }

        // Default case
        return back()->withErrors([
            'username' => 'Authentication failed.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
