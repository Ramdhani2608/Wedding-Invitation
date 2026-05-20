<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;

Route::get('/v2/config', [GuestController::class, 'config']);

Route::post('/session', function () {
    return response()->json([
        'code' => 200,
        'data' => [
            'token' => 'local',
            'is_confetti_animation' => true,
        ],
    ]);
});

Route::get('/user', function () {
    return response()->json([
        'code' => 200,
        'data' => [
            'name' => 'Local User',
            'email' => 'local@example.com',
        ],
    ]);
});

// Comment API untuk undangan
Route::get('/v2/comment', [GuestController::class, 'index']);
Route::post('/v2/comment', [GuestController::class, 'store']);
Route::put('/v2/comment/{uuid}', [GuestController::class, 'update']);
Route::delete('/v2/comment/{uuid}', [GuestController::class, 'destroy']);

Route::get('/comment', [GuestController::class, 'index']);
Route::post('/comment', [GuestController::class, 'store']);
Route::put('/comment/{uuid}', [GuestController::class, 'update']);
Route::delete('/comment/{uuid}', [GuestController::class, 'destroy']);

Route::get('/guests', [GuestController::class, 'index']);
Route::post('/guests', [GuestController::class, 'store']);
