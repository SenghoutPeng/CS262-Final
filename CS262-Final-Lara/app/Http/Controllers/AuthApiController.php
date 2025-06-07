<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthApiController extends Controller
{
    //<?php


    public function signup(Request $request)
    {
       $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
       
        $user = User::create($validated);

        Auth::login($user);

        return response()->json(['message' => 'Account Created Successfully'],200);

    }

    public function login(Request $request){
       $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return response()->json(['message' => 'Logged in successfully'],200);
        }
        else{
            return response()->json(['message' => 'Logging in is not successfully done'],422);
        }
       

    }
    
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully']);
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
            
            return response()->json([
                'error' => 'Current password is incorrect.'
            ], 422);
          
        }
        if ($request->current_password === $request->new_password) {
            return response()->json([
                'error' => 'New password cannot be the same as the current password.'
            ], 422);
        }
        
            $user =  User::find($auth->id);
            $user->password = $request->password;
            $user->save();
            return response()->json([
                'message' => 'Password updated successfully.'
            ],200);
 
    }
}


