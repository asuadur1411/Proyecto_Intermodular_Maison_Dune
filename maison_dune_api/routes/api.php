<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ReservationController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ── Autenticación ─────────────────────────────────────────────────────────────
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);

    if (!hash_equals((string) $hash, sha1($user->email))) {
        return redirect('http://maison.test/login?error=link_invalido');
    }

    $user->markEmailAsVerified();

    $token = $user->createToken('auth_token')->plainTextToken;
    return redirect("http://maison.test/login?token={$token}");

})->middleware('signed')->name('verification.verify');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});

// ── Mensajes de contacto ──────────────────────────────────────────────────────
Route::post('/messages', [ContactController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/messages', [ContactController::class, 'index']);
    Route::get('/messages/{id}', [ContactController::class, 'show']);
    Route::delete('/messages/{id}', [ContactController::class, 'destroy']);
});

// ── Reservas ──────────────────────────────────────────────────────────────────
Route::post('/reservations', [ReservationController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/my-reservations', [ReservationController::class, 'myReservations']);
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
});