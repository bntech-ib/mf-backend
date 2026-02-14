<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;  
use App\Http\Controllers\Api\FanController; 
use App\Http\Controllers\Api\PredictionController;
use App\Http\Controllers\Api\AuthController;


// Route::middleware('auth:sanctum')->prefix('v1')->group(function () {


// Route::get('/profile', function (Request $request) {
//     return $request->user();
// });

// });

 

 Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('api')->group(function () {

        Route::get('/fan/dashboard', [FanController::class, 'dashboard']);
        Route::get('/fan/season-stats', [FanController::class, 'seasonStats']);

        Route::post('/matches/{match}/predict', [PredictionController::class, 'store']);
    });

});
