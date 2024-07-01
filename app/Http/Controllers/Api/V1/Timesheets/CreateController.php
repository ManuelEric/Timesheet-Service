<?php

namespace App\Http\Controllers\Api\V1\Timesheets;

use App\Actions\Timesheet\CreateTimesheetAction;
use App\Actions\Timesheet\RegisterMentorTutorAction as RegisterMentorTutorTimesheetAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Timesheet\StoreRequest as TimesheetStoreRequest;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{
    public function store(
        TimesheetStoreRequest $request,
        RegisterMentorTutorTimesheetAction $registerMentorTutorTimesheetAction,
        CreateTimesheetAction $createTimesheetAction,
        ): JsonResponse
    {
        $validated = $request->safe()->only([
            'ref_id',
            'mentortutor_email',
            'package_id',
            'detail_package',
            'pic_id',
            'notes',
        ]); 

        /* defines the validated variables */
        $validatedRefPrograms = $validated['ref_id'];
        $validatedEmail = $validated['mentortutor_email'];
        $validatedPics = $validated['pic_id'];
        $validatedPackageId = $validated['package_id'];
        $validatedDetailPackage = $validated['detail_package'];
        $validatedNotes = $validated['notes'];

        $newPackageDetails = compact('validatedPackageId', 'validatedDetailPackage');

        $createdMentorTutorId = $registerMentorTutorTimesheetAction->execute($validatedEmail);
        $createTimesheetAction->execute($validatedRefPrograms, $newPackageDetails, $validatedNotes, $validatedPics, $createdMentorTutorId);
    
        return response()->json([
            'message' => "Timesheet has been created successfully."
        ]);
    }
}
