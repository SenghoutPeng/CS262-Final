<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// http://localhost:8000/api/test
Route::post('/test', function () {
    return response()->json(['msg' => 'API Route Working'], 200);
});

// http://localhost:8000/api/signup
Route::post('/signup', [AuthApiController::class, 'signup']);

// http://localhost:8000/api/signup-org
Route::post('/signup-org', [AuthApiController::class, 'signupOrg']);

// http://localhost:8000/api/login
Route::post('/login', [AuthApiController::class,'login']);

// http://localhost:8000/api/logout
Route::post('/logout', [AuthApiController::class,'logout']);

// http://localhost:8000/api/change-password
Route::post('/change-password', [AuthApiController::class,'changePassword']);

// http://localhost:8000/api/admin/login
Route::post('/adminLog', [AdminAuthController::class, 'loginAdmin']);

// user dashbaord api
Route::controller(AuthApiController::class)->group(function () {
    Route::get('/getAllUser', 'getAllUser');
    Route::get('/Balanceuser', 'getBalanceUser');
    Route::get('/getUser', 'getUser');
});

Route::get('/token', function (Request $request) {
    $token = $request->session()->token();
 
    $token = csrf_token();
 
    return $token;
});