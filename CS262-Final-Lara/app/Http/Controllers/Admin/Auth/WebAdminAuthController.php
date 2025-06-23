<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class WebAdminAuthController extends Controller
{

    public function showSignUp()
    {
        return view('admin.auth.signup');
    }

    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function showChangePassword()
    {
        return view('admin.auth.change');
    }

    public function signup(Request $request)
    {

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:admin',
            'password' => 'required|string|min:8|confirmed',

        ]);

        $admin = Admin::create($validated);
        Auth::guard('admin')->login($admin);

        return redirect('/admin');

    }


    public function login(Request $request){
       $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::guard('admin')->attempt($validated)) {
            $request->session()->regenerate();
            return redirect("/admin");
        }
        else{
            return back()->with([
                'status' => 'Errors',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login-form');
    }

    public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required|current_password:admin',
        'password' => 'required|string|min:8|confirmed',
    ]);

    if ($request->current_password === $request->password) {
        return back()->withErrors(['message' => 'New password cannot be the same as your current password.']);
    }
    $admin = Auth::guard('admin')->user();


    $admin->update([
        'password' => Hash::make($request->password),
    ]);

    return back()->with('status', 'Password updated successfully.');
}


}
