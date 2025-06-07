<?php

use App\Http\Controllers\AuthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// http://localhost:8000/api/signup
Route::post('/signup', [AuthApiController::class,'signup']);

// http://localhost:8000/api/login
Route::post('/login', [AuthApiController::class,'login']);

// http://localhost:8000/api/logout
Route::post('/logout', [AuthApiController::class,'logout']);

// http://localhost:8000/api/change-password
Route::post('/change-password', [AuthApiController::class,'changePassword']);