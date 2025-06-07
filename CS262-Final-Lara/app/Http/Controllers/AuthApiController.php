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

         $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']), // Add this line
    ]);

        return response()->json(['message' => 'Account Created Successfully'],200);

    }

    public function login(Request $request){
        $feilds = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|'
        ]);

        if (!Auth::attempt($feilds)) {
            return response()->json(['errors' => [
                'user' => ['invalid credentials']
            ]], 401);
        }

        $request->session()->regenerate();

        return response()->json(['message' => 'Logged in successfully', 'user' => Auth::user()]);
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


