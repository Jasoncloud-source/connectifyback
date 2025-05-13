<?php

use App\Http\Controllers\AuthController;
//use App\Http\Controllers\API\CommunityController;
//use App\Http\Controllers\API\EventController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;

Route::post('/contact', [ContactController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::post('/complete-onboarding', [ProfileController::class, 'completeOnboarding']);
});
Route::get('/communities/popular', [CommunityController::class, 'getPopularCommunities']);
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe']);

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
     // Messages
    Route::get('/communities/{community}/messages', [MessageController::class, 'index']);
   Route::post('/communities/{community}/messages', [MessageController::class, 'store']);
});  
    // // Communities
    // Route::get('/communities', [CommunityController::class, 'index']);
    // Route::post('/communities', [CommunityController::class, 'store']);
    // Route::get('/communities/{community}', [CommunityController::class, 'show']);
    // Route::put('/communities/{community}', [CommunityController::class, 'update']);
    // Route::delete('/communities/{community}', [CommunityController::class, 'destroy']);
    // Route::post('/communities/{community}/join', [CommunityController::class, 'join']);
    // Route::post('/communities/{community}/leave', [CommunityController::class, 'leave']);
    // Route::get('/communities/{community}/members', [CommunityController::class, 'members']);
    
    // Events
    // Route::get('/events', [EventController::class, 'index']);
    // Route::post('/events', [EventController::class, 'store']);
    // Route::get('/events/{event}', [EventController::class, 'show']);
    // Route::put('/events/{event}', [EventController::class, 'update']);
    // Route::delete('/events/{event}', [EventController::class, 'destroy']);
    
 