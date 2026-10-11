<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\Api\DeadlineController;
use App\Http\Controllers\Api\AuthController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/deadlines', [DeadlineController::class, 'index']);
    Route::post('/deadlines', [DeadlineController::class, 'store']);
    Route::put('/deadlines/{id}', [DeadlineController::class, 'update']);
Route::delete('/deadlines/{id}', [DeadlineController::class, 'destroy']);
});
