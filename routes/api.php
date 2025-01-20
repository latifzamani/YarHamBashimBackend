<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProjectController;
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

Route::get('/links/show',[MediaController::class,'lShow']);
Route::get('/supporters/show',[MediaController::class,'sShow']);
Route::get('/videos/show',[MediaController::class,'vShow']);
Route::get('/events/show',[InfoController::class,'eShow']);
Route::get('/events/{id}/show',[InfoController::class,'eidShow']);
Route::get('/members/show',[InfoController::class,'mShow']);
Route::get('/chart/show',[InfoController::class,'cShow']);
Route::get('/projects/show',[ProjectController::class,'pShow']);
Route::get('/projects/{id}/show',[ProjectController::class,'pidShow']);
Route::get('/projectImages/show',[ProjectController::class,'imageShow']);
Route::get('/projectImages/{id}/show',[ProjectController::class,'imageidShow']);
Route::post('/sendEmail',[ProjectController::class, 'sendEmail']);

Route::get('/logout',[AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware(['auth:sanctum','verified'])->group(function () {
    // Logout/Register
    Route::post('/user/register',[AuthController::class,'registerUser']);
    // supporters
    Route::post('/supporters/store',[MediaController::class,'sStore']);
    Route::post('/supporters/{id}/update',[MediaController::class,'sUpdate']);
    Route::delete('/supporters/{id}/delete',[MediaController::class,'sDelete']);
    // Videos
    Route::post('/videos/{id}/update',[MediaController::class,'vUpdate']);
    // Links
    Route::post('/links/{id}/update',[MediaController::class,'lUpdate']);
    // Team Members
    Route::post('/members/store',[InfoController::class,'mStore']);
    Route::post('/members/{id}/update',[InfoController::class,'mUpdate']);
    Route::delete('/members/{id}/delete',[InfoController::class,'mDelete']);
    //Events
    Route::post('/events/store',[InfoController::class,'eStore']);
    Route::post('/events/{id}/update',[InfoController::class,'eUpdate']);
    Route::delete('/events/{id}/delete',[InfoController::class,'eDelete']);
    //Chart
    Route::post('/chart/store',[InfoController::class,'cStore']);
    Route::post('/chart/{id}/update',[InfoController::class,'cUpdate']);
    Route::delete('/chart/{id}/delete',[InfoController::class,'cDelete']);
    //Projects
    Route::post('/projects/store',[ProjectController::class,'pStore']);
    Route::post('/projects/{id}/update',[ProjectController::class,'pUpdate']);
    Route::delete('/projects/{id}/delete',[ProjectController::class,'pDelete']);
    // projectimages
    Route::post('/projectImages/store',[ProjectController::class,'imageStore']);
    Route::post('/projectImages/{id}/update',[ProjectController::class,'imageUpdate']);
    Route::delete('/projectImages/{id}/delete',[ProjectController::class,'imageDelete']);

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
