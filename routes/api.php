<?php

use App\Http\Controllers\Api\V1\Authentication\CheckEmailController as V1CheckEmailController;
use App\Http\Controllers\Api\V1\Authentication\LoginController as V1LoginController;
use App\Http\Controllers\Api\V1\Authentication\LogoutController as V1LogoutController;
use App\Http\Controllers\Api\V1\Authentication\ForgotPasswordController as V1ForgotPasswordController;
use App\Http\Controllers\Api\V1\Authentication\ResetPasswordController as V1ResetPasswordController;
use App\Http\Controllers\Api\V1\Authentication\CreatePasswordController as V1CreatePasswordController;
use App\Http\Controllers\Api\V1\MentorTutor\MainController as V1MentorTutorController;
use App\Http\Controllers\Api\V1\MentorTutor\ComponentController as V1MentorTutorComponentController;
use App\Http\Controllers\Api\V1\Programs\ListController as V1ProgramsListController;
use App\Http\Controllers\Api\V1\Programs\ComponentController as V1ProgramsComponentController;
use App\Http\Controllers\Api\V1\Timesheet\MainController as V1TimesheetController;
use App\Http\Controllers\Api\V1\Timesheet\AlternativeController as V1TimesheetAlternativeController;
use App\Http\Controllers\Api\V1\Timesheet\ComponentController as V1TimesheetComponentController;
use App\Http\Controllers\Api\V1\Activity\MainController as V1ActivitiesController;
use App\Http\Controllers\Api\V1\Activity\ComponentController as V1ActivitiesComponentController;
use App\Http\Controllers\Api\V1\LogController;
use App\Http\Controllers\Api\V1\Packages\ListController as V1PackagesListController;
use App\Http\Controllers\Api\V1\User\ListController as V1UserListController;
use App\Http\Controllers\Api\V1\Payment\PaymentController as V1PaymentController;
use App\Http\Controllers\Api\V1\Payment\CutoffController as V1CutoffController;
use App\Http\Controllers\Api\V1\Payment\FeeController as V1FeeController;
use App\Http\Controllers\Api\V1\Payment\BonusController as V1BonusController;
use App\Http\Controllers\Api\V1\Payment\ExistingCutoffController as V1ExistingCutoffController;
use App\Http\Controllers\Api\V1\ChangePasswordController as V1ChangePasswordController;
use App\Http\Controllers\Api\V1\DashboardBaseController as V1DashboardBaseController;
use App\Http\Controllers\Api\V1\Curriculums\ListController as V1CurriculumListController;
use App\Http\Controllers\Api\V1\Request\EngagementTypeController as V1EngagementTypeController;
use App\Http\Controllers\Api\V1\Request\MainController as V1RequestController;
use App\Http\Controllers\Api\V1\Mentee\MainController as V1MenteeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Programs\ExternalController as V1ProgramEXTERNALController;

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
Route::middleware(['throttle:120,1'])->group(function () {

    Route::prefix('timesheet')->group(function () {
        Route::GET('{timesheet}/export', [V1TimesheetController::class, 'export']);
    });

    Route::middleware('auth:sanctum')->get('/summarize/{month}', [V1DashboardBaseController::class, 'index']);


    /* Authentication */
    Route::prefix('auth')->group(function () {
        # login timesheet by uuid (Currently use for mentor)
        Route::get('u/{uuid}', [V1LoginController::class, 'authenticateByUuid']);

        Route::POST('email/checking', [V1CheckEmailController::class, 'execute']);
        Route::POST('token', [V1LoginController::class, 'authenticateAdmin']);
        Route::POST('forgot-password', [V1ForgotPasswordController::class, 'sendResetLink']);
        Route::POST('reset-password', [V1ResetPasswordController::class, 'execute']);
        Route::POST('create-password', [V1CreatePasswordController::class, 'execute']);

        Route::middleware(['auth:sanctum'])->group(function () {
            /* Logout */
            Route::GET('terminate', [V1LogoutController::class, 'execute']);
            
            /* for tutor mentor only that able to change password */
            Route::PATCH('change-password', [V1ChangePasswordController::class, 'patch']);
        });
    });

    /* Mentor & Tutors */
    Route::prefix('user')->group(function () {
        Route::middleware(['auth:sanctum', 'ability:mentortutors-menu,program-menu'])->group(function () {
            /* List Mentor & Tutors */
            Route::GET('mentor-tutors', [V1MentorTutorController::class, 'index']);
            Route::PUT('mentor-tutors/{mentortutor_uuid}', [V1MentorTutorController::class, 'update']);
            
            /**
             * The Components.
             */

            /* List PICs */
            Route::prefix('component')->middleware(['abilities:program-menu'])->group(function () {
                Route::GET('list', [V1UserListController::class, 'component']);
            });
            /* List subject by Mentor / Tutor */
            Route::GET('mentor-tutors/{mentortutor_uuid}/subjects', [V1MentorTutorComponentController::class, 'comp_subjects']);
            /* List students mentored / tutored by Mentor / Tutor */
            Route::GET('mentor-tutors/{mentortutor_uuid}/students', [V1MentorTutorComponentController::class, 'comp_students']);
        });
    });

    /* Request */
    Route::prefix('request')->group(function () {
        Route::middleware(['auth:sanctum', 'abilities:request-menu'])->group(function () {
            /* Store Request */
            Route::POST('create', [V1RequestController::class, 'store']);
            /* List of Requests */
            Route::GET('/', [V1RequestController::class, 'index']);
            /* Update Request */
            Route::PATCH('{ref_program}/update', [V1RequestController::class, 'update']);
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
                Route::GET('list', [V1ProgramsComponentController::class, 'list']);
                Route::GET('summary/{month}', [V1ProgramsComponentController::class, 'summaryMonthlyPrograms'])->withoutMiddleware(['abilities:program-menu']);
            });
        });
    });

    /* Mentee */
    Route::middleware(['auth:sanctum', 'abilities:request-menu', 'throttle:30,1'])->group(function  () {

        /**
         * The Components
         */
        Route::GET('mentees', [V1MenteeController::class, 'index']);
    });

    /* Timesheet */
    Route::prefix('timesheet')->group(function () {
        Route::middleware(['auth:sanctum', 'abilities:timesheet-menu'])->group(function () {
            /* List Timesheet */
            Route::GET('list', [V1TimesheetController::class, 'index']);
            /* Store Timesheet */
            Route::POST('create', [V1TimesheetController::class, 'store'])->name('timesheet.tutor.store');
            /* Store Timesheet from subject specialist */
            Route::POST('create/skip-request', [V1TimesheetAlternativeController::class, 'store'])->name('timesheet.mentor.store');
            /* Detail Timesheet */
            Route::GET('{timesheet}/detail', [V1TimesheetController::class, 'show']);
            /* Update Timesheet */
            Route::PUT('{timesheet}/update', [V1TimesheetController::class, 'update']);
            /* Destroy Timesheet */
            Route::DELETE('{timesheet}/delete', [V1TimesheetController::class, 'destroy']);
            /* Void Timesheet */
            Route::PATCH('{timesheet}/void', [V1TimesheetController::class, 'patch']);
            /* Export Timesheet */
            Route::GET('{timesheet}/export', [V1TimesheetController::class, 'export'])->withoutMiddleware(['auth:sanctum', 'abilities:timesheet-menu']);

            /**
             * The Components
             */
            Route::prefix('component')->group(function () {
                /* timesheet */
                Route::GET('list', [V1TimesheetComponentController::class, 'list']);
                Route::GET('summary/{month}', [V1TimesheetComponentController::class, 'summaryMonthlyTimesheet']);
                
                /* activity */
                Route::GET('activity/{month}', [V1ActivitiesComponentController::class, 'monthlyActivities']);
                Route::GET('activity/summary/{month}', [V1ActivitiesComponentController::class, 'summaryMonthlyActivities']);
            });

            /* List Activities of the Timesheet */
            Route::GET('{timesheet}/activities', [V1ActivitiesController::class, 'index']);
            /* Show the Activity */
            Route::GET('{timesheet}/activity/{activity}', [V1ActivitiesController::class, 'show']);
            /* Store Activity */
            Route::POST('{timesheet}/activity', [V1ActivitiesController::class, 'store']);
            /* Update Activity */
            Route::PUT('{timesheet}/activity/{activity}', [V1ActivitiesController::class, 'update']);
            /* Patch Activity */
            Route::PATCH('{timesheet}/activity/{activity}', [V1ActivitiesController::class, 'patch']);
            /* Destroy the activity */
            Route::DELETE('{timesheet}/activity/{activity}', [V1ActivitiesController::class, 'destroy']);
        });
    });

    /* pre cut-off */
    Route::prefix('payment')->group(function () {
        Route::middleware(['auth:sanctum', 'abilities:payment-menu'])->group(function () {
            /* List of unpaid activities */
            Route::GET('unpaid', [V1PaymentController::class, 'index']);
            /* List of paid activities */
            Route::GET('paid', [V1PaymentController::class, 'index']);
            /* Add additional fee into the timesheet */
            Route::POST('additional-fee/create', [V1FeeController::class, 'store']);
            /* Add bonus into the timesheet */
            Route::POST('bonus/create', [V1BonusController::class, 'store']);

            Route::prefix('cut-off')->group(function() {
                /* Create cut-off */
                Route::POST('create', [V1CutoffController::class, 'store']);
                /* Add to an existing cut-off */
                Route::POST('add', [V1ExistingCutoffController::class, 'store']);
                /* Remove the activity from the specified cut-off */
                Route::PATCH('unassign', [V1CutoffController::class, 'unassign']);
                /* Export cut-off */
                Route::GET('export/{timesheet}/{cutoff_start}/{cutoff_end}', [V1CutoffController::class, 'export'])->withoutMiddleware(['auth:sanctum', 'abilities:payment-menu']);
                /* Export multiple sheets at the same time */
                Route::GET('export/{cutoff_start}/{cutoff_end}', [V1CutoffController::class, 'export_multiple'])->withoutMiddleware(['auth:sanctum', 'abilities:payment-menu']);

            });
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

    /* Curriculum */
    Route::prefix('curriculum')->group(function () {
        Route::middleware(['auth:sanctum', 'abilities:timesheet-menu'])->group(function () {
            /**
             * The Components
             */
            Route::prefix('component')->group(function () {
                Route::GET('list', [V1CurriculumListController::class, 'component']);
            });
        });
    });

    Route::POST('identity/generate-token', [V1LoginController::class, 'authenticateNonAdmin']);

    /* Fee */
    Route::middleware(['auth:sanctum', 'abilities:program-menu'])->group(function () {
        /**
         * The Components
         */
        Route::prefix('component')->group(function () {
            Route::GET('fee/{tutor_id}/{subject_name}/{curriculum_id}', [V1FeeController::class, 'component']);
        });
    });

    /* Engagement Type */
    Route::prefix('engagement-type')->group(function () {
        Route::middleware(['auth:sanctum', 'abilities:request-menu'])->group(function () {
            /**
             * The Components
             */
            Route::prefix('component')->group(function () {
                Route::GET('list', [V1EngagementTypeController::class, 'component']);
            });
        });
    });


    /* log everytime user visit any pages */
    Route::middleware('auth:sanctum')->get('visit/{page_name}/{detail?}', [LogController::class, 'index']);


    /**
     * used out of auth sanctum
     * since this is going to be a private API
    */
    Route::get('program/{clientprog_id}/detail', [V1ProgramEXTERNALController::class, 'index']);

});
