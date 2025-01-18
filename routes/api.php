<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MediaController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Protect routes using token-based authentication middleware
Route::middleware(['auth:sanctum','verified'])->group(function () {
    // Logout/Register
    Route::get('/logout',[AuthController::class, 'logout']);
    Route::post('/user/register',[AuthController::class,'registerUser']);
    // supporters
    Route::get('/supporters/show',[MediaController::class,'sShow']);
    Route::post('/supporters/store',[MediaController::class,'sStore']);
    Route::post('/supporters/{id}/update',[MediaController::class,'sUpdate']);
    Route::delete('/supporters/{id}/delete',[MediaController::class,'sDelete']);
    // Videos
    Route::get('/videos/show',[MediaController::class,'vShow']);
    Route::post('/videos/{id}/update',[MediaController::class,'vUpdate']);
    // Links
    Route::get('/links/show',[MediaController::class,'lShow']);
    Route::post('/links/{id}/update',[MediaController::class,'lUpdate']);

});
Route::post('/login',[AuthController::class,'login'])->middleware('throttle:5,1');
Route::get('/emailverify',[AuthController::class, 'emailverify']);
// Route::get('/sanctum/csrf-cookie', [AuthController::class, 'show']);



// Verification notice (for API, you might just send a response indicating verification is required)
// Route::get('/email/verify', function () {
//     return response()->json(['message' => 'Email verification required.'], 403);
// })->middleware('auth:sanctum')->name('verification.notice');

// Verification handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'Email verified successfully.']);
})->middleware(['auth:sanctum'])->name('verification.verify');

// Resend verification link
// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
//     return response()->json(['message' => 'Verification link sent!']);
// })->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
