<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showSignUp()
    {
        return view('auth.signup');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showChangePassword()
    {
        return view('auth.change');
    }

    public function signup(Request $request)
    {


       $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:user',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($validated);

        Auth::login($user);

        return redirect('/');

    }


    public function login(Request $request){
       $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect("/");
        }
        else{
            return back()->with([
                'status' => 'Errors',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login-form');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);


        if ($request->current_password === $request->password) {
            return back()->withErrors(['password' => 'New password cannot be the same as your current password.']);
        }

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('status', 'Password updated successfully.');
    }

}
