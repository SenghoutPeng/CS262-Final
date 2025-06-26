<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Organization\OrganizationController;
use App\Http\Controllers\Organization\Auth\OrganizationAuthController;

use function PHPSTORM_META\map;

Route::put('/users/{id}', function (Request $request, $id) {
    $post = User::findOrFail($id);
    $post->update($request->only('username','email'));

    return response()->json(['message' => 'User updated successfully']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// User routes
Route::prefix('/')->group(function () {
    Route::post('/signup', [AuthApiController::class, 'signup']);
    Route::post('/login', [AuthApiController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/buy-ticket', [UserController::class, 'buyTicket']);
        Route::post('/change-password', [AuthApiController::class, 'changePassword']);
        Route::post('/logout', [AuthApiController::class, 'logout']);
        Route::get('/profile', [UserController::class, 'userProfile']);
    });
});

// Organization routes
Route::prefix('organization')->group(function () {
    Route::post('/signup', [OrganizationAuthController::class, 'signup']);
    Route::post('/login', [OrganizationAuthController::class, 'login']);

    Route::middleware('auth:organization-api')->group(function () {
        Route::post('/check-in', [OrganizationController::class, 'checkIn']);
        Route::post('/event-request', [OrganizationController::class, 'createEvent']);
        Route::post('/logout', [OrganizationAuthController::class, 'logout']);
        Route::post('/change-password', [OrganizationAuthController::class, 'changePassword']);
        Route::get('/buyers', [OrganizationController::class, 'showBuyer']);
        Route::get('/profile', [OrganizationController::class, 'profile']);
    });
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::post('/signup', [AdminAuthController::class, 'signup']);
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:admin-api')->group(function () {

        
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        
        Route::post('/change-password', [AdminAuthController::class, 'changePassword']);
        Route::get('/profile', [AdminController::class, 'adminProfile']);
        //Route::get('/users', [AdminController::class, 'allUser']);
        //Route::get('/organizations', [AdminController::class, 'allOrganization']);
        //Route::get('/event-requests', [AdminController::class, 'allOrganization']);


        
        
    });
    Route::get('/transaction', [AdminController::class, 'transaction']);
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::post('/decision', [AdminController::class, 'decisionOnEventRequest']);
    Route::get('/detail-event-request/{event_id}', [AdminController::class, 'viewEventRequest']);
    Route::get('/activity-log', [AdminController::class, 'showActivity']);
    Route::get('/users', [AdminController::class, 'allUser']);
    Route::get('/organizations', [AdminController::class, 'allOrganization']);
    //Route::get('/event-requests', [AdminController::class, 'allOrganization']);
    Route::get('/all-event-requests', [AdminController::class, 'allEventRequest']);
});
