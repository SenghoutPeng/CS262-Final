<?php

namespace App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class Admin_AuthApiController extends Controller
{
    //<?php


    public function signup(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:admin',
            'password' => 'required|string|min:8|confirmed',

        ]);


        $admin = Admin::create($validated);
        $token = $admin->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Account created successfully',
            'token' => $token,
            'admin' => $admin,
        ], 201);



    }

public function login(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email|exists:admin',
        'password' => 'required|min:8'
    ]);

 $admin = Admin::where('email',$request->email)->first();
    if (!$admin || !Auth::guard('admin')->attempt($validated)) {
        return response()->json([
            'errors' => [
                'credentials' => ['Invalid credentials']
            ]
        ], 401);
    }

    // Create new token
    $token = $admin->createToken('mytoken')->plainTextToken;

    return response()->json([
        'message' => 'Logged in successfully',
        'admin' => $admin,
        'token' => $token
    ], 200);
}




    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully']);
    }

 public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $admin = Auth::guard('admin')->user();

    // Manually check current password against the hash
    if (!Hash::check($request->current_password, $admin->password)) {
        return response()->json([
            'message' => 'The current password is incorrect.',
            'errors' => ['current_password' => ['The current password is incorrect.']]
        ], 422);
    }

    if ($request->current_password === $request->password) {
        return response()->json(['message' => 'The new password cannot be the same as the current password.'], 422);
    }

    $admin->password = Hash::make($request->password);
    $admin->save();

    return response()->json(['message' => 'Password updated successfully.']);
}




}

