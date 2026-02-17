<?php

use App\Http\Controllers\Api\EntityController;
use App\Http\Controllers\Api\LeaderboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FanController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PredictionController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClubController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\UserController;

// Route::middleware('auth:sanctum')->prefix('v1')->group(function () {


// Route::get('/profile', function (Request $request) {
//     return $request->user();
// });

// });





Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);


    Route::post('/auth/logout', [AuthController::class, 'logout']);


    Route::middleware(['api', 'auth:sanctum'])->group(function () {

        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::get('/users/{user}/posts', [UserController::class, 'posts']);
        Route::get('/users/{user}/club', [UserController::class, 'club']);
        Route::get('/users/{user}/badges', [UserController::class, 'badge']);


        Route::get('/me', [UserController::class, 'me']);
        Route::get('/me/activity', [UserController::class, 'me']);
        Route::get('/me/predictions', [UserController::class, 'me']);
        Route::get('/me/rewards', [UserController::class, 'me']);
        Route::get('/me/badges', [UserController::class, 'me']);

        Route::get('/communities', [CommunityController::class, 'index']);
        Route::get('/communities/{community}', [CommunityController::class, 'show']);
        Route::get('/communities/{community}/feed', [CommunityController::class, 'feed']);
        Route::get('/communities/{community}/members', [CommunityController::class, 'members']);
        Route::get('/communities/{community}/leaderboard', [CommunityController::class, 'leaderboard']);
        Route::get('/communities/{community}/stats', [CommunityController::class, 'stats']);
        



        Route::get('/clubs', [ClubController::class, 'index']);
        Route::get('/clubs/{club}', [ClubController::class, 'show']);
        Route::get('/clubs/{club}/feed', [ClubController::class, 'feed']);
        Route::get('/clubs/{club}/fans', [ClubController::class, 'fans']);
        Route::get('/clubs/{club}/leaderboard', [ClubController::class, 'leaderboard']);
        Route::get('/clubs/{club}/stats', [ClubController::class, 'stats']);


        Route::get('/entities/{type}/{id}', [EntityController::class, 'resolveEntity']);
        Route::get('/entities/{type}/{id}/feed', [EntityController::class, 'show']);
        Route::get('/entities/{type}/{id}/leaderboard', [EntityController::class, 'feed']);
        Route::get('/entities/{type}/{id}/members', [EntityController::class, 'members']);
        Route::get('/clubs/{club}/leaderboard', [EntityController::class, 'leaderboard']);








        Route::get('/leaderboards/global', [LeaderboardController::class, 'index']);
        Route::get('/leaderboards/clubs/{club}', [LeaderboardController::class, 'leaderboards_club']);
        Route::get('/leaderboards/communities/{community}', [LeaderboardController::class, 'leaderboards_communities']);
        Route::get('/leaderboards/match/{match}', [LeaderboardController::class, 'leaderboard_match']);


















        Route::get('/post', [PostController::class, 'index']);
        Route::get('/post/{id}', [PostController::class, 'show']);
        Route::get('/post/stats', [PostController::class, 'show']);
        Route::get('/fan/dashboard', [FanController::class, 'dashboard']);
        Route::get('/fan/season-stats', [FanController::class, 'seasonStats']);

        Route::post('/matches/{match}/predict', [PredictionController::class, 'store']);
    });
});
