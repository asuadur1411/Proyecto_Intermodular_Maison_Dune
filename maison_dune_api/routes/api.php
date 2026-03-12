<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Rutas públicas de contacto
Route::post('/messages', [ContactController::class, 'store']);

// Rutas protegidas de contacto
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/messages', [ContactController::class, 'index']);
    Route::get('/messages/{id}', [ContactController::class, 'show']);
    Route::delete('/messages/{id}', [ContactController::class, 'destroy']);
});