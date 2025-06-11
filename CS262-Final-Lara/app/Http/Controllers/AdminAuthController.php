<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin; // Your Admin model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AdminAuthController extends Controller
{
    /*
    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (!Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['message' => 'Invalid admin credentials'], 401);
        }

        return response()->json(['message' => 'Admin login successful', 'user' => Auth::guard('admin')->user()]);
    }*/

    public function loginAdmin(Request $request)
{
    $credentials = $request->only('username', 'password');

    if (!Auth::guard('admin')->attempt($credentials)) {
        return response()->json(['message' => 'Invalid admin credentials'], 401);
    }

    // Get the authenticated admin ID
    $adminId = Auth::guard('admin')->id();
    
    // Force get the Admin model instance
    $admin = Admin::find($adminId);

    if (!$admin) {
        return response()->json(['message' => 'Admin not found'], 404);
    }

    // Generate Sanctum token
    $token = $admin->createToken('admin-token')->plainTextToken;

    return response()->json([
        'message' => 'Admin login successful',
        'admin' => $admin,
        'token' => $token
    ]);
}

    public function logout(Request $request)
    {
        // Logout the currently authenticated admin
        // Ensure you're targeting the correct guard for token deletion
        $request->user('admin')->tokens()->delete();

        return response()->json(['message' => 'Admin logged out successfully']);
    }
}
