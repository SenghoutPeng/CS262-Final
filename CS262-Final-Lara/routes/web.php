<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

//Authenthication start//

// http://localhost:8000/signup-form
Route::get('/signup-form', [AuthController::class,'showSignUp']);

// http://localhost:8000/login-form
Route::get('/login-form', [AuthController::class,'showLogin']);

Route::get('/change-password-form', [AuthController::class,'showChangePassword']);

// http://localhost:8000/signup
Route::post('/signup', [AuthController::class,'signup']);

// http://localhost:8000/login
Route::post('/login', [AuthController::class,'login']);

// http://localhost:8000/logout
Route::post('/logout', [AuthController::class,'logout']);

// http://localhost:8000/change-password
Route::post('/change-password', [AuthController::class,'changePassword']);


//Authenthication end//