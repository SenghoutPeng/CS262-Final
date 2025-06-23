<?php

namespace App\Http\Controllers\Organization\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class WebOrganizationAuthController extends Controller
{

    public function showSignUp()
    {
        return view('organization.auth.signup');
    }

    public function showLogin()
    {
        return view('organization.auth.login');
    }

    public function showChangePassword()
    {
        return view('organization.auth.change');
    }

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

        Auth::guard('organization')->login($organization);

        return redirect('/organization');

    }


    public function login(Request $request){
       $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::guard('organization')->attempt($validated)) {
            $request->session()->regenerate();
            return redirect("/organization");
        }
        else{
            return back()->with([
                'status' => 'Errors',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('organization')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/organization/login-form');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password:',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($request->current_password === $request->password) {
            return response()->json(['message' => 'Password has failed to updated.']);
        }

        $organization = Auth::guard('organization')->user();
        $organization->password = Hash::make($request->password);
        $organization->save();

        return back()->with('status', 'Password updated successfully.');
    }
}
