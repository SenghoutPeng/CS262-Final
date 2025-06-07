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
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Account created successfully',
            'token' => $token,
            'user' => $user,
        ], 201);

      

    }

public function login(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:8'
    ]);
 
 $user = User::where('email',$request->email)->first();
    if (!$user || !Auth::attempt($validated)) {
        return response()->json([
            'errors' => [
                'credentials' => ['Invalid credentials']
            ]
        ], 401);
    }



    // Create new token
    $token = $user->createToken('mytoken')->plainTextToken;

    return response()->json([
        'message' => 'Logged in successfully',
        'user' => $user,
        'token' => $token
    ], 200);
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
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $user = $request->user();
    
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 422);
        }
    
        if ($request->current_password === $request->password) {
            return response()->json(['error' => 'New password cannot be the same as current password'], 422);
        }
    
        $user->password = Hash::make($request->password);
        $user->save();
    
        return response()->json(['message' => 'Password updated successfully']);
    }
    
}