<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Login Authentication Controller
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $remember = $request->has('remember');

    if (Auth::attempt($credentials, $remember)) {
        return redirect()->route('home'); 
    }

    return back()->withErrors(['message' => 'Invalid credentials!']);
    }

    // Change user password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully!');
    }
    
    // Check authentication and redirect
    public function profile_settings()
    {
        if (Auth::check()) {
            return view('pages.my_profile');
        }
        return view('pages.login');
    }
}
