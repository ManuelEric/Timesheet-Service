<?php

use App\Http\Controllers\Api\V1\Authentication\CheckEmailController as V1CheckEmailController;
use App\Http\Controllers\Api\V1\Authentication\LoginController as V1LoginController;
use App\Http\Controllers\Api\V1\Authentication\LogoutController as V1LogoutController;
use App\Http\Controllers\Api\V1\Authentication\ForgotPasswordController as V1ForgotPasswordController;
use App\Http\Controllers\Api\V1\Authentication\ResetPasswordController as V1ResetPasswordController;
use App\Http\Controllers\Api\V1\Authentication\CreatePasswordController as V1CreatePasswordController;
use App\Http\Controllers\Api\V1\MentorTutorsController as V1MentorTutorController;
use App\Http\Controllers\Api\V1\Programs\ListController as V1ProgramsListController;
use App\Http\Controllers\Api\V1\TimesheetController as V1TimesheetController;
use App\Http\Controllers\Api\V1\ActivityController as V1ActivitiesController;
use App\Http\Controllers\Api\V1\Packages\ListController as V1PackagesListController;
use App\Http\Controllers\Api\V1\User\ListController as V1UserListController;
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
    Route::middleware(['auth:sanctum', 'abilities:mentortutors-menu,program-menu'])->group(function () {
        /* List Mentor & Tutors */
        Route::GET('mentor-tutors', [V1MentorTutorController::class, 'index']);
        Route::PUT('mentor-tutors/{mentortutor_uuid}', [V1MentorTutorController::class, 'update']);
        /* List subject by Mentor / Tutor */
        Route::GET('mentor-tutors/{mentortutor_uuid}/subjects', [V1MentorTutorController::class, 'component']);

        /**
         * The Components
         */
        Route::prefix('component')->middleware(['abilities:program-menu'])->group(function () {
            Route::GET('list', [V1UserListController::class, 'component']);
        });
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
        /* List Timesheet */
        Route::GET('list', [V1TimesheetController::class, 'index']);
        /* Store Timesheet */
        Route::POST('create', [V1TimesheetController::class, 'store']);
        /* Detail Timesheet */
        Route::GET('{timesheet}/detail', [V1TimesheetController::class, 'show']);
        
        /* List Activities of the Timesheet */
        Route::GET('{timesheet}/activities', [V1ActivitiesController::class, 'index']);
        /* Show the Activity */
        Route::GET('{timesheet}/activity/{activity}', [V1ActivitiesController::class, 'show']);
        /* Store Activity */
        Route::POST('{timesheet}/activity', [V1ActivitiesController::class, 'store']);
        /* Update Activity */
        Route::PUT('{timesheet}/activity/{activity}', [V1ActivitiesController::class, 'update']);
        /* Destroy the activity */
        Route::DELETE('{timesheet}/activity/{activity}', [V1ActivitiesController::class, 'destroy']);
    }); 
});

/* Package */
Route::prefix('package')->group(function () {
    Route::middleware(['auth:sanctum', 'abilities:timesheet-menu'])->group(function () {
        /**
         * The Components
         */
        Route::prefix('component')->group(function () {
            Route::GET('list', [V1PackagesListController::class, 'component']);
        });
    }); 
});
    
Route::POST('identity/generate-token', [V1LoginController::class, 'authenticateNonAdmin']);
