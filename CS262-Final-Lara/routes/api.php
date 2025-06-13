<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\Organization\Auth\Org_AuthApiController;
use App\Http\Controllers\Admin\Auth\Admin_AuthApiController;
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

// http://localhost:8000/api/login
Route::post('/login', [AuthApiController::class,'login']);

// http://localhost:8000/api/logout
Route::post('/logout', [AuthApiController::class,'logout']);

// http://localhost:8000/api/change-password
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/change-password', [AuthApiController::class, 'changePassword']);
});

// http://localhost:8000/api/signup
Route::post('/organization/signup', [Org_AuthApiController::class, 'signup']);

// http://localhost:8000/api/login
Route::post('/organization/login', [Org_AuthApiController::class,'login']);

// http://localhost:8000/api/logout
Route::post('/organization/logout', [Org_AuthApiController::class,'logout']);

// http://localhost:8000/api/change-password
Route::post('/organization/change-password', [Org_AuthApiController::class,'changePassword']);




// http://localhost:8000/api/signup
Route::post('/admin/signup', [Admin_AuthApiController::class, 'signup']);

// http://localhost:8000/api/login
Route::post('/admin/login', [Admin_AuthApiController::class,'login']);

// http://localhost:8000/api/logout
Route::post('/admin/logout', [Admin_AuthApiController::class,'logout']);

// http://localhost:8000/api/change-password
Route::post('/admin/change-password', [Admin_AuthApiController::class,'changePassword']);
