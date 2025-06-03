<?php

namespace App\Http\Controllers\Api\V1\Timesheet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timesheet\AlternativeStoreRequest as TimesheetAlternativeStoreRequest;
use App\Actions\Timesheet\SelectOrRegisterMentorTutorAction as SelectOrRegisterMentorTutorTimesheetAction;
use App\Models\Ref_Program;
use App\Models\TempUserRoles;
use App\Services\Program\RefProgramServices;
use App\Services\Timesheet\CreateTimesheetService;
use Illuminate\Support\Carbon;

class AlternativeController extends Controller
{
    /**
     * function below is different from mainController::store
     * because there are two ways to store timesheet
     * 1 from tutor and another 1 is from mentor
     * 
     * and for this mentor, the form is a bit different than tutor's form
     * so to make it easy to maintain, I decided to make in different controller.
     * 
     */
    public function store(
        TimesheetAlternativeStoreRequest $request,
        RefProgramServices $refProgramServices,
        SelectOrRegisterMentorTutorTimesheetAction $selectOrRegisterMentorTutorTimesheetAction,
        CreateTimesheetService $createTimesheetService,
        )
    {
        /* insert into ref program */
        $validatedRefProgram = $request->safe()->only([
            'clientprog_id',
            'invoice_id',
            'student_uuid',
            'student_name',
            'student_school',
            'student_grade',
            'program_name',
            'engagement_type',
            'notes',
        ]);

        $storedRequest = $refProgramServices->createOne($validatedRefProgram);

        /* declare the validated variables for timesheet mentor */
        $validated = $request->safe()->only([
            'engagement_type',
            'mentortutor_email',
            'inhouse_id',
            'package_id',
            'duration',
            'pic_id',
            'notes',
            'subject_id', # used when subject fetched from the server
            'individual_fee',
            'tax',
        ]);

        $validatedRefPrograms = [$storedRequest->id]; // filled with newly stored ref program above
        $validatedEngagementType = $validated['engagement_type'];
        $validatedEmail = $validated['mentortutor_email'];
        $validatedInhouse = $validated['inhouse_id'];
        $validatedPics = $validated['pic_id'];
        $validatedPackageId = $validated['package_id'];
        $validatedDuration = $validated['duration'];
        $validatedNotes = $validated['notes'];
        $validatedSubject = $validated['subject_id'];
        $validatedSubjectName = null;
        $validatedFeeIndividual = $validated['individual_fee'] ?? 0;
        $validatedTax = $validated['tax'] ?? 0;
        $validatedCurriculumId = null;

        $newPackageDetails = compact('validatedPackageId', 'validatedDuration');

        $mentorTutorId = $selectOrRegisterMentorTutorTimesheetAction->handle($validatedEmail);

        $tempUserRoles = TempUserRoles::firstOrCreate([
            'temp_user_id' => $mentorTutorId,
            'role' => 'External Mentor',
        ], [
            'year' => Carbon::now()->format('Y'),
            'head' => 1,
            'grade' => '[9-12]',
            'fee_individual' => $validatedFeeIndividual,
            'tax' => $validatedTax
        ]);
        

        
        //! here's some notes that need to be checked later [IMPORTANT!]
        # for now, to get tempUserRoles, we only check by year, temp_user_id, and subject name
        # but there might be some issues when system using head and grade
        # so if the system are using head and grade to get the subject, please update data below
        # make sure to update not only the fee_individual but also the other parameters
        # same goes with the data above, you should not hardcoded the head and grade
        $tempUserRoles->fee_individual = $validatedFeeIndividual;
        $tempUserRoles->tax = $validatedTax;
        $tempUserRoles->save();


        $validatedSubject = $tempUserRoles->id;
        /************************* changes ***********************/

        $createdTimesheet = $createTimesheetService->storeTimesheet($validatedRefPrograms, $newPackageDetails, $validatedNotes, $validatedInhouse, $validatedPics, $mentorTutorId, $validatedSubject);
    
        return response()->json([
            'message' => "Timesheet has been created successfully.",
            'data' => [
                'timesheet_id' => $createdTimesheet->id,
                'student_name' => $createdTimesheet->list_of_student_name, // could be more than 1 student 
            ]
        ]);
    }
}
