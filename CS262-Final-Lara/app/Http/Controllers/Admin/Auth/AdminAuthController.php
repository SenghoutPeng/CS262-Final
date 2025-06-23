<?php

namespace App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AdminAuthController extends Controller
{




    public function signup(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $admin = Admin::create($validated);

        $token = $admin->createToken('api-token')->plainTextToken;

        activity()
            ->causedBy($admin)
            ->withProperties([
                'email' => $admin->email,
            ])
            ->log('Admin signed up');

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

 $auth = Admin::where('email',$request->email)->first();
    if (!$auth || !Auth::guard('admin')->attempt($validated)) {
        return response()->json([
            'errors' => [
                'credentials' => ['Invalid credentials']
            ]
        ], 401);
    }
    $admin = Auth::guard('admin')->user();
    // Create new token
    $token = $auth->createToken('mytoken')->plainTextToken;


    activity()
    ->causedBy($admin)
    ->withProperties([
        'email' => $admin->email,
    ])
    ->log('Admin Logged in');

    return response()->json([
        'message' => 'Logged in successfully',
        'admin' => $admin,
        'token' => $token
    ], 200);
}




public function logout(Request $request)
{

    $admin = $request->user();

    if (!$admin) {
        return response()->json(['message' => 'Not authenticated'], 401);
    }

    $token = $admin->currentAccessToken();

    if ($token) {
        $token->delete();

        activity()
        ->causedBy($admin)
        ->withProperties([
            'email' => $admin->email,
        ])
        ->log('Admin signed up');

        return response()->json(['message' => 'Logged out successfully']);
    }

    return response()->json(['message' => 'No active token found'], 400);
}

    public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'password' => 'required|min:8|confirmed',
    ]);


    $admin = Auth::guard('admin-api')->user();

    // Verify current password
    if (!Hash::check($request->current_password, $admin->password)) {
        return response()->json(['message' => 'Incorrect current password'], 401);
    }

    // Check if new password is different
    if ($request->current_password === $request->password) {
        return response()->json(['message' => 'New password must be different'], 400);
    }

    activity()
            ->causedBy($admin)
            ->withProperties([
                'email' => $admin->email,
            ])
            ->log( 'Admin changed password');
    // Update password
    $admin->update([
        'password' => Hash::make($request->password),
    ]);

    return response()->json(['message' => 'Password updated successfully'], 200);
}

public function adminProfile()
    {
            $admin_db = DB::select("select * from admin");

            return view('admin.admin-profile', ['v_data' => $admin_db]);

    }
}

