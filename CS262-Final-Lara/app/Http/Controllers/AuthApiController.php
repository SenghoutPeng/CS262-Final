<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Admin;
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

    public function signupOrg(Request $request)
    {
         $validated = $request->validate([
        'org_name' => 'required|string|max:255',
        'email' => 'required|email|unique:organization,email',
        'password' => 'required|string|min:8|confirmed',
        'contact_name' => 'nullable|string|max:255',
        'contact_phone' => 'nullable|string|max:20',
        'contact_email' => 'nullable|email|max:255',
    ]);

    $organization = Organization::create($validated); // Use $organization for clarity
    $token = $organization->createToken('org-api-token')->plainTextToken;

        return response()->json([
        'message' => 'Organization account created successfully',
        'token' => $token,
        'user' => [
            'id' => $organization->org_id,
            'org_name' => $organization->org_name,
            'email' => $organization->email,
        ],
    ], 201);
    }
    
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8'
        ]);
    
        $user = User::where('email',$request->email)->first(); //find user by email

        if (!$user || !Auth::attempt($validated)) { // if user is not found
            return response()->json([
                'errors' => [
                    'credentials' => ['Invalid credentials']
                ]
            ], 401);
        }

        // Create new API token
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
    

    public function getAllUser()
    {
        $count = User::count();
        return response()->json(['totalUsers' => $count]);
    }

    public function getBalanceUser()
    {
        $totalBalance = User::sum('balance'); // assuming the 'balance' column exists in users table

        return response()->json(['TotalBalance' => $totalBalance]);
    }

    public function getUser(){
        $all = User::select('id', 'name', 'email', 'balance', 'status', 'created_at')->get();

        return response()-> json([
            'success' => true,
            'data' => $all
        ]);
    }


}