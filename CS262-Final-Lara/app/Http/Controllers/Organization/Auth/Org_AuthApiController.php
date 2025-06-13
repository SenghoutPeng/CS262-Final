<?php

namespace App\Http\Controllers\Organization\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Organization;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class Org_AuthApiController extends Controller
{
    //<?php


    public function signup(Request $request)
    {
       $validated = $request->validate([
            'org_name' => 'required|string|max:255',
            'email' => 'required|email|unique:organization',
            'password' => 'required|string|min:8|confirmed',
            'org_type'=> 'required',
            'contact_name'=> 'required',
            'contact_phone'=> 'required',
            'contact_email'=> 'required',
        ]);

        $organization = Organization::create($validated);
        $token = $organization->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Account created successfully',
            'token' => $token,
            'organization' => $organization,
        ], 201);



    }

public function login(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email|exists:organization',
        'password' => 'required|min:8'
    ]);

 $organization = Organization::where('email',$request->email)->first();
    if (!$organization || !Auth::guard('organization')->attempt($validated)) {
        return response()->json([
            'errors' => [
                'credentials' => ['Invalid credentials']
            ]
        ], 401);
    }

    // Create new token
    $token = $organization->createToken('mytoken')->plainTextToken;

    return response()->json([
        'message' => 'Logged in successfully',
        'organization' => $organization,
        'token' => $token
    ], 200);
}




    public function logout(Request $request)
    {
        Auth::guard('organization')->logout();

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

        if ($request->current_password === $request->password) {
            return response()->json(['message' => 'Password has failed to updated.']);
        }

        $organization = $request->guard('organization')->user();
        $organization->password = Hash::make($request->password);
        $organization->save();

        return response()->json(['message' => 'Password updated successfully.']);
    }

    public function createEvent(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'ticket_price' => 'required',
            'banner' => 'required'
        ]);
    }



}

