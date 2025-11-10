<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Google OAuth Routes
|--------------------------------------------------------------------------
*/
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Require Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Authenticated User Info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Projects CRUD
    Route::post('/projects', [ProjectController::class, 'store']);       // ✅ Create
    Route::put('/projects/{id}', [ProjectController::class, 'update']);  // ✅ Update
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']); // ✅ Delete

    // Proposals CRUD
    Route::post('/proposals', [ProposalController::class, 'store']);
    Route::put('/proposals/{id}', [ProposalController::class, 'update']);
    Route::delete('/proposals/{id}', [ProposalController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Public Routes (No Token Required)
|--------------------------------------------------------------------------
*/
Route::get('/projects', [ProjectController::class, 'index']);      // ✅ View all
Route::get('/projects/{id}', [ProjectController::class, 'show']);  // ✅ View single

Route::get('/proposals', [ProposalController::class, 'index']);    // ✅ View all
Route::get('/users', [UserController::class, 'index']);            // ✅ View all
