<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Organization\Auth\WebOrganizationAuthController;
use App\Http\Controllers\Admin\Auth\WebAdminAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/organization', function () {
    return view('organization.index');
});

Route::get('/admin', function () {
    return view('admin.index');
});

//Authenthication start//

// http://localhost:8000/signup-form
Route::get('/signup-form', [AuthController::class,'showSignUp']);

// http://localhost:8000/login-form
Route::get('/login-form', [AuthController::class,'showLogin']);

Route::get('/change-password-form', [AuthController::class,'showChangePassword']);

// http://localhost:8000/signup
Route::post('/signup', [AuthController::class, 'signup']);
// http://localhost:8000/login
Route::post('/login', [AuthController::class,'login']);

// http://localhost:8000/logout
Route::post('/logout', [AuthController::class,'logout']);

// http://localhost:8000/change-password
Route::post('/change-password', [AuthController::class,'changePassword']);


//Authenthication end//


//Authenthication start//

// http://localhost:8000/signup-form
Route::get('/organization/signup-form', [WebOrganizationAuthController::class,'showSignUp']);

// http://localhost:8000/login-form
Route::get('/organization/login-form', [WebOrganizationAuthController::class,'showLogin']);

Route::get('/organization/change-password-form', [WebOrganizationAuthController::class,'showChangePassword']);

// http://localhost:8000/signup
Route::post('/organization/signup', [WebOrganizationAuthController::class, 'signup']);


// http://localhost:8000/login
Route::post('/organization/login', [WebOrganizationAuthController::class,'login']);

// http://localhost:8000/logout
Route::post('/organization/logout', [WebOrganizationAuthController::class,'logout']);

// http://localhost:8000/change-password
Route::post('/organization/change-password', [WebOrganizationAuthController::class,'changePassword']);


//Authenthication end//
//Authenthication start//

// http://localhost:8000/signup-form
Route::get('/admin/signup-form', [WebAdminAuthController::class,'showSignUp']);

// http://localhost:8000/login-form
Route::get('/admin/login-form', [WebAdminAuthController::class,'showLogin']);

Route::get('/admin/change-password-form', [WebAdminAuthController::class,'showChangePassword']);

// http://localhost:8000/signup
Route::post('/admin/signup', [WebAdminAuthController::class, 'signup']);


// http://localhost:8000/login
Route::post('/admin/login', [WebAdminAuthController::class,'login']);

// http://localhost:8000/logout
Route::post('/admin/logout', [WebAdminAuthController::class,'logout']);

// http://localhost:8000/change-password
Route::post('/admin/change-password', [WebAdminAuthController::class,'changePassword']);


//Authenthication end//
