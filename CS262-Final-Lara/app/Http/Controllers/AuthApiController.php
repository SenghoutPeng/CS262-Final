<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthApiController extends Controller
{
    //<?php


    public function signup(Request $request)
    {
       $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create($validated);
        $token = $user->createToken('api-token')->plainTextToken;

        activity()
        ->causedBy($user)
        ->withProperties([
            'email' => $user->email,
        ])
        ->log('user signed up');

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


    $token = $user->createToken('mytoken')->plainTextToken;

    activity()
    ->causedBy($user)
    ->withProperties([
        'email' => $user->email,
    ])
    ->log('user logged in');

    return response()->json([
        'message' => 'Logged in successfully',
        'user' => $user,
        'token' => $token
    ], 200);
}


public function logout(Request $request)
{

    $user = $request->user();

    if (!$user) {
        return response()->json(['message' => 'Not authenticated'], 401);
    }


    $token = $user->currentAccessToken();

    if ($token) {
        $token->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    /*activity()
    ->causedBy($organization)
    ->withProperties([
        'email' => $organization->email,
    ])
    ->log('organization logged out');*/

    return response()->json(['message' => 'No active token found'], 400);
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

        activity()
        ->causedBy($user)
        ->withProperties([
            'email' => $user->email,
        ])
        ->log('user changed password');

        return response()->json(['message' => 'Password updated successfully'], 200);
    }

   
}

