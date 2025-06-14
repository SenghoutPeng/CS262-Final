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
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:user',
            'password' => 'required|min:8|confirmed',
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
        'email' => 'required|email|exists:user,email',
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
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',

        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Incorrect current password'], 401);
        }

        if ($request->current_password === $request->password) {
            return response()->json(['message' => 'New password must be different'], 400);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Password updated successfully'], 200);
    }

}

