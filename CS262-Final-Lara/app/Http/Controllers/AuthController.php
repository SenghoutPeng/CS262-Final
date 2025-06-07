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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
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
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $auth = Auth::user();

        if(!Hash::check($request->current_password, $auth->password))
        { 
            return back()->with(['current_password'=>'Cureent password is incorrect']);
        }
        if ($request->current_password === $request->new_password) {
            return back()->with("error", "New password cannot be the same as your curent password.");
        }
        
        $user =  User::find($auth->id);
            $user->password = $request->password;
            $user->save();
            return back()->with('status', 'Password updated successfully.');
    }
}
