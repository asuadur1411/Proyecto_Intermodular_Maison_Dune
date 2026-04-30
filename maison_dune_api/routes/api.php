<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatbotController;
use App\Http\Controllers\Api\ClosureController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\RoomReviewController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\WaitlistController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:5,1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);

    if (!hash_equals((string) $hash, sha1($user->email))) {
        return redirect(config('app.frontend_url', config('app.url')) . '/login?error=link_invalido');
    }

    $user->markEmailAsVerified();

    $token = $user->createToken('auth_token')->plainTextToken;
    return redirect(config('app.frontend_url', config('app.url')) . "/login?token={$token}&name=" . urlencode($user->name));

})->middleware('signed')->name('verification.verify');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/user', [AuthController::class, 'deleteAccount']);
});

Route::post('/messages', [ContactController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/messages', [ContactController::class, 'index']);
    Route::get('/messages/{id}', [ContactController::class, 'show']);
    Route::delete('/messages/{id}', [ContactController::class, 'destroy']);
});

Route::get('/tables/availability', [TableController::class, 'availability']);
Route::get('/tables/booked-hours', [TableController::class, 'bookedHours']);
Route::middleware(['auth:sanctum', 'admin'])->get('/tables/status-now', [TableController::class, 'statusNow']);

Route::get('/closures/active', [ClosureController::class, 'active']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/closures', [ClosureController::class, 'index']);
    Route::post('/closures', [ClosureController::class, 'store']);
    Route::delete('/closures/{id}', [ClosureController::class, 'destroy']);
});

Route::post('/chatbot', [ChatbotController::class, 'handle']);
Route::middleware('auth:sanctum')->post('/chatbot/auth', [ChatbotController::class, 'handle']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::get('/my-reservations', [ReservationController::class, 'myReservations']);
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
    Route::post('/event-reservations', [ReservationController::class, 'eventStore']);
    Route::post('/room-reservations', [ReservationController::class, 'roomStore']);
});

Route::get('/events/{slug}/availability', [ReservationController::class, 'eventAvailability']);
Route::get('/rooms/{slug}/availability', [ReservationController::class, 'roomAvailability']);
Route::get('/rooms/{slug}/reviews', [RoomReviewController::class, 'index']);
Route::middleware('auth:sanctum')->post('/rooms/{slug}/reviews', [RoomReviewController::class, 'store']);
Route::middleware('auth:sanctum')->delete('/rooms/{slug}/reviews/{id}', [RoomReviewController::class, 'destroy']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/reservations/lookup', [ReservationController::class, 'lookupByCode']);
    Route::post('/reservations/{id}/checkin', [ReservationController::class, 'checkIn']);
    Route::post('/reservations/cancel-by-slug', [ReservationController::class, 'cancelBySlug']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/waitlist', [WaitlistController::class, 'store']);
    Route::get('/my-waitlist', [WaitlistController::class, 'myWaitlist']);
    Route::delete('/waitlist/{id}', [WaitlistController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('stats')->group(function () {
    Route::get('/overview', [StatsController::class, 'overview']);
    Route::get('/reservations-by-day', [StatsController::class, 'reservationsByDay']);
    Route::get('/guests-by-day', [StatsController::class, 'guestsByDay']);
    Route::get('/peak-hours', [StatsController::class, 'peakHours']);
    Route::get('/user-growth', [StatsController::class, 'userGrowth']);
    Route::get('/table-saturation', [StatsController::class, 'tableSaturation']);
});