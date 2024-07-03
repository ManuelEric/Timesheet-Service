<?php

use App\Http\Controllers\Api\V1\Authentication\CheckEmailController as V1CheckEmailController;
use App\Http\Controllers\Api\V1\Authentication\LoginController as V1LoginController;
use App\Http\Controllers\Api\V1\Authentication\LogoutController as V1LogoutController;
use App\Http\Controllers\Api\V1\Authentication\ForgotPasswordController as V1ForgotPasswordController;
use App\Http\Controllers\Api\V1\Authentication\ResetPasswordController as V1ResetPasswordController;
use App\Http\Controllers\Api\V1\Authentication\CreatePasswordController as V1CreatePasswordController;
use App\Http\Controllers\Api\V1\MentorTutors\ListController as V1MentorTutorsListController;
use App\Http\Controllers\Api\V1\Programs\ListController as V1ProgramsListController;
use App\Http\Controllers\Api\V1\Timesheets\CreateController as V1TimesheetsCreateController;
use App\Http\Controllers\Api\V1\Timesheets\ListController as V1TimesheetsListController;
use App\Http\Controllers\Api\V1\Timesheets\DetailController as V1TimesheetsDetailController;
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

/* API Documentation */ 
Route::get('api-documentation', function() {
    return view('API-documentation');
});


/* Authentication */
Route::prefix('auth')->group(function () {

    Route::POST('email/checking', [V1CheckEmailController::class, 'execute']);
    Route::POST('token', [V1LoginController::class, 'authenticateAdmin']);
    Route::POST('forgot-password', [V1ForgotPasswordController::class, 'sendResetLink']);
    Route::POST('reset-password', [V1ResetPasswordController::class, 'execute']);
    Route::POST('create-password', [V1CreatePasswordController::class, 'execute']);

    Route::middleware(['auth:sanctum'])->group(function () {
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

/* Programs */
Route::prefix('program')->group(function () {
    Route::middleware(['auth:sanctum', 'abilities:program-menu'])->group(function () {
        /* list Programs */
        Route::GET('list', [V1ProgramsListController::class, 'index']);


        /**
         * The Components
         */
        Route::prefix('component')->group(function () {
            Route::GET('list', [V1ProgramsListController::class, 'component']);
        });
    });
});

/* Timesheet */
Route::prefix('timesheet')->group(function () {
    Route::middleware(['auth:sanctum', 'abilities:timesheet-menu'])->group(function () {
        /* Detail Timesheet */
        Route::GET('{id}/detail', [V1TimesheetsDetailController::class, 'show']);
        /* List Activities of the Timesheet */
        // Route::GET('{id}/activities', []);
        /* List Timesheet */
        Route::GET('list', [V1TimesheetsListController::class, 'index']);
        /* Store Timesheet */
        Route::POST('create', [V1TimesheetsCreateController::class, 'store']);
    }); 
});
    
Route::POST('identity/generate-token', [V1LoginController::class, 'authenticateNonAdmin']);
