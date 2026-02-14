<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Illuminate\Http\Client\Response;


// Route::middleware('auth:sanctum')->prefix('v1')->group(function () {


// Route::get('/profile', function (Request $request) {
//     return $request->user();
// });

// });
Route::prefix('v1')->group(function () {


Route::get('/profile', function (Request $request) {
    return Response()->json(['message'=>'system working']);
});

});