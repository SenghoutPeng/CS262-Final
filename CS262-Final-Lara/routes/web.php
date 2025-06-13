<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Organization\Auth\Org_AuthController;
use App\Http\Controllers\Admin\Auth\Admin_AuthController;
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
Route::get('/organization/signup-form', [Org_AuthController::class,'showSignUp']);

// http://localhost:8000/login-form
Route::get('/organization/login-form', [Org_AuthController::class,'showLogin']);

Route::get('/organization/change-password-form', [Org_AuthController::class,'showChangePassword']);

// http://localhost:8000/signup
Route::post('/organization/signup', [Org_AuthController::class, 'signup']);


// http://localhost:8000/login
Route::post('/organization/login', [Org_AuthController::class,'login']);

// http://localhost:8000/logout
Route::post('/organization/logout', [Org_AuthController::class,'logout']);

// http://localhost:8000/change-password
Route::post('/organization/change-password', [Org_AuthController::class,'changePassword']);


//Authenthication end//
//Authenthication start//

// http://localhost:8000/signup-form
Route::get('/admin/signup-form', [Admin_AuthController::class,'showSignUp']);

// http://localhost:8000/login-form
Route::get('/admin/login-form', [Admin_AuthController::class,'showLogin']);

Route::get('/admin/change-password-form', [Admin_AuthController::class,'showChangePassword']);

// http://localhost:8000/signup
Route::post('/admin/signup', [Admin_AuthController::class, 'signup']);


// http://localhost:8000/login
Route::post('/admin/login', [Admin_AuthController::class,'login']);

// http://localhost:8000/logout
Route::post('/admin/logout', [Admin_AuthController::class,'logout']);

// http://localhost:8000/change-password
Route::post('/admin/change-password', [Admin_AuthController::class,'changePassword']);


//Authenthication end//
