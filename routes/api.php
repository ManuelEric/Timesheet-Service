<?php

use App\Http\Controllers\Api\V1\Authentication\CheckEmailController as V1CheckEmailController;
use App\Http\Controllers\Api\V1\Authentication\LoginController as V1LoginController;
use App\Http\Controllers\Api\V1\Authentication\LogoutController as V1LogoutController;
use App\Http\Controllers\Api\V1\Authentication\ForgotPasswordController as V1ForgotPasswordController;
use App\Http\Controllers\Api\V1\Authentication\ResetPasswordController as V1ResetPasswordController;
use App\Http\Controllers\Api\V1\Authentication\CreatePasswordController as V1CreatePasswordController;
use App\Http\Controllers\Api\V1\MentorTutors\ListController as V1MentorTutorsListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Authentication */
Route::prefix('auth')->group(function () {

    Route::POST('email/checking', [V1CheckEmailController::class, 'execute']);
    Route::POST('token', [V1LoginController::class, 'authenticateAdmin']);
    Route::POST('forgot-password', [V1ForgotPasswordController::class, 'sendResetLink']);
    Route::POST('reset-password', [V1ResetPasswordController::class, 'execute']);
    Route::POST('create-password', [V1CreatePasswordController::class, 'execute']);

    Route::middleware(['auth:sanctum'])->group(function() {
        /* Logout */
        Route::GET('terminate', [V1LogoutController::class, 'execute']);
    });
});

/* Mentor & Tutors */
Route::prefix('user')->group(function () {
    Route::middleware(['auth:sanctum', 'abilities:mentortutors-menu'])->group(function () {
        /* List Mentor & Tutors */
        Route::GET('mentor-tutors', [V1MentorTutorsListController::class, 'index']);
    });
});
    
Route::POST('identity/generate-token', [V1LoginController::class, 'authenticateNonAdmin']);
