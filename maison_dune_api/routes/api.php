<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Ruta protegida para las cookies
Route::middleware('auth:sanctum')->get('/user', fn(Request $request) => $request->user());