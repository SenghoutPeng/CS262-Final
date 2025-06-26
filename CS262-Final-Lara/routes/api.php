<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Organization\OrganizationController;
use App\Http\Controllers\Organization\Auth\OrganizationAuthController;

// User routes
Route::prefix('/')->group(function () {
    // http://localhost:8000/api/signup
    Route::post('/signup', [AuthApiController::class, 'signup']);
    // http://localhost:8000/api/login
    Route::post('/login', [AuthApiController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        // http://localhost:8000/api/buy-ticket
        Route::post('/buy-ticket', [UserController::class, 'buyTicket']);
        // http://localhost:8000/api/change-password
        Route::post('/change-password', [AuthApiController::class, 'changePassword']);
        // http://localhost:8000/api/rating
        Route::post('/rating', [RatingController::class, 'submitRating']);
        // http://localhost:8000/api/logout
        Route::post('/logout', [AuthApiController::class, 'logout']);
        // http://localhost:8000/api/profile
        Route::get('/profile', [UserController::class, 'profile']);

    });
});

// Organization routes
Route::prefix('organization')->group(function () {
    // http://localhost:8000/api/organization/signup
    Route::post('/signup', [OrganizationAuthController::class, 'signup']);
    // http://localhost:8000/api/organization/login
    Route::post('/login', [OrganizationAuthController::class, 'login']);

    Route::middleware('auth:organization-api')->group(function () {
        // http://localhost:8000/api/organization/check-in
        Route::post('/check-in', [OrganizationController::class, 'checkIn']);
        // http://localhost:8000/api/organization/event-request
        Route::post('/event-request', [EventController::class, 'createEvent']);
        // http://localhost:8000/api/organization/logout
        Route::post('/logout', [OrganizationAuthController::class, 'logout']);
        // http://localhost:8000/api/organization/change-password
        Route::post('/change-password', [OrganizationAuthController::class, 'changePassword']);
        // http://localhost:8000/api/organization/dashboard
        Route::get('/dashboard', [OrganizationController::class, 'getAllBuyers']);
        // http://localhost:8000/api/organization/feedback
        Route::get('/feedback', [RatingController::class, 'feedback']);
        // http://localhost:8000/api/organization/profile
        Route::get('/profile', [OrganizationController::class, 'profile']);
    });
});

// Admin routes
Route::prefix('admin')->group(function () {

     // http://localhost:8000/api/admin/signup
    Route::post('/signup', [AdminAuthController::class, 'signup']);
     // http://localhost:8000/api/admin/login
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:admin-api')->group(function () {

        // http://localhost:8000/api/admin/approve-event
        Route::post('/approve-event', [EventController::class, 'approveEventRequest']);
        // http://localhost:8000/api/admin/log
        Route::post('/logout', [AdminAuthController::class, 'logout']);
        // http://localhost:8000/api/admin/change-password
        Route::post('/change-password', [AdminAuthController::class, 'changePassword']);
        // http://localhost:8000/api/admin/profile
        Route::get('/profile', [AdminController::class, 'profile']);
        // http://localhost:8000/api/admin/users
        Route::get('/users', [AdminController::class, 'getAllUsers']);
        // http://localhost:8000/api/admin/organizations
        Route::get('/organizations', [AdminController::class, 'getAllOrganizations']);
        // http://localhost:8000/api/admin/transactions
        Route::get('/transactions', [AdminController::class, 'transaction']);
        // http://localhost:8000/api/admin/activity-log
        Route::get('/activity-log', [AdminController::class, 'activityLog']);
        // http://localhost:8000/api/admin/dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        // http://localhost:8000/api/admin/event-requests
        Route::get('/event-requests', [EventController::class, 'getAllEventRequests']);
        // http://localhost:8000/api/admin/detail-event-request/{event_id}
        Route::get('/detail-event-request/{event_id}', [EventController::class, 'getOneEventRequest']);

    });
});
