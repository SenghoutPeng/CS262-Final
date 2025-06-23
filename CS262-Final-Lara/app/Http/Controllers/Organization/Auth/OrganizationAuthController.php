<?php

namespace App\Http\Controllers\Organization\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Organization;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class OrganizationAuthController extends Controller
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

        activity()
            ->causedBy($organization)
            ->withProperties([
                'email' => $organization->email,
            ])
            ->log('organization signed up');

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

    activity()
    ->causedBy($organization)
    ->withProperties([
        'email' => $organization->email,
    ])
    ->log('organization logged in');

    return response()->json([
        'message' => 'Logged in successfully',
        'organization' => $organization,
        'token' => $token
    ], 200);
}




public function logout(Request $request)
{

    $organization = $request->user();

    if (!$organization) {
        return response()->json(['message' => 'Not authenticated'], 401);
    }


    $token = $organization->currentAccessToken();

    if ($token) {
        $token->delete();

        activity()
        ->causedBy($organization)
        ->withProperties([
            'email' => $organization->email,
        ])
        ->log('organization logged out');

        return response()->json(['message' => 'Logged out successfully']);
    }

    return response()->json(['message' => 'No active token found'], 400);
}

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $organization = Auth::guard('organization-api')->user();

        if (!Hash::check($request->current_password, $organization->password)) {
            return response()->json([
                'message' => 'The current password is incorrect.',
                'errors' => ['current_password' => ['The current password is incorrect.']]
            ], 422);
        }

        if ($request->current_password === $request->password) {
            return response()->json(['message' => 'The new password cannot be the same as the current password.'], 422);
        }


        $organization->password = Hash::make($request->password);
        $organization->save();

        activity()
        ->causedBy($organization)
        ->withProperties([
            'email' => $organization->email,
        ])
        ->log('organization changed password');
        return response()->json(['message' => 'Password updated successfully.']);
    }


}

