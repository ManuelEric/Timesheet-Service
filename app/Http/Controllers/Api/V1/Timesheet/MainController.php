<?php

namespace App\Http\Controllers\Api\V1\Timesheet;

use App\Http\Controllers\Controller;
use App\Models\Ref_Program;
use Illuminate\Http\Request;
use App\Actions\Timesheet\IdentifierCheckingAction as IdentifyTimesheetIdAction;
use App\Http\Requests\Timesheet\StoreRequest as TimesheetStoreRequest;
use App\Actions\Timesheet\SelectOrRegisterMentorTutorAction as SelectOrRegisterMentorTutorTimesheetAction;
use App\Actions\Timesheet\UpdateTimesheetAction;
use App\Actions\Timesheet\VoidTimesheetAction;
use App\Exports\TimesheetExport;
use App\Http\Traits\GenerateTimesheetFileName;
use App\Models\TempUser;
use App\Models\TempUserRoles;
use App\Models\Timesheet;
use App\Services\Activity\ActivityDataService;
use App\Services\Timesheet\CreateTimesheetService;
use App\Services\Timesheet\TimesheetDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MainController extends Controller
{
    use GenerateTimesheetFileName;
    protected $timesheetDataService;

    public function __construct(TimesheetDataService $timesheetDataService)
    {
        $this->timesheetDataService = $timesheetDataService;
    }

    public function index(Request $request): JsonResponse
    {
        /* Incoming Request */
        $search = $request->only(['program_name', 'package_id', 'keyword']);

        /* to determine whether timesheet tutor or timesheet mentor */
        $is_subject_specialist = $request->is_subject_specialist;

        $results = $this->timesheetDataService->listTimesheet($search, $is_subject_specialist);
        return response()->json($results);
    }

    # parameter needed 
    # timesheet id, program id, new tutor, reason 
    public function show(
        $timesheetId,
        IdentifyTimesheetIdAction $identifyTimesheetIdAction, 
        ): JsonResponse
    {
        $timesheet = $identifyTimesheetIdAction->execute($timesheetId);
        $result = $this->timesheetDataService->detailTimesheet($timesheet);
        return response()->json($result);
    }

    public function store(
        TimesheetStoreRequest $request,
        SelectOrRegisterMentorTutorTimesheetAction $selectOrRegisterMentorTutorTimesheetAction,
        CreateTimesheetService $createTimesheetService,
        ): JsonResponse
    {
        $validated = $request->safe()->only([
            'ref_id',
            'mentortutor_email',
            'inhouse_id',
            'package_id',
            'duration',
            'pic_id',
            'notes',
            'subject_id', # used when subject fetched from the server
            'subject_name', # used when subject fetched from own db
            'individual_fee',
        ]);

        /* defines the validated variables */
        $validatedRefPrograms = $validated['ref_id'];
        $validatedEmail = $validated['mentortutor_email'];
        $validatedInhouse = $validated['inhouse_id'];
        $validatedPics = $validated['pic_id'];
        $validatedPackageId = $validated['package_id'];
        $validatedDuration = $validated['duration'];
        $validatedNotes = $validated['notes'];
        // $validatedSubject = $validated['subject_id'];
        $validatedSubjectName = $validated['subject_name'] ?? null;
        $validatedFeeIndividual = $validated['individual_fee'] ?? 0;
        $validatedTax = $validated['tax'] ?? 0;

        $newPackageDetails = compact('validatedPackageId', 'validatedDuration');

        $mentorTutorId = $selectOrRegisterMentorTutorTimesheetAction->handle($validatedEmail);

        $refProgram = Ref_Program::whereIn('id', $validatedRefPrograms)->first();
        
        if ( $refProgram && $refProgram->require === 'Tutor' )
        {
            /************************* changes ***********************/
            # before the data stored into timesheet
            # need to check if tutor has already subject on temp_user_roles
            # if tutor doesn't have subject, then create a new one
            $tempUserRoles = TempUserRoles::firstOrCreate([
                'year' => Carbon::format('Y'),
                'temp_user_id' => $mentorTutorId,
                'tutor_subject' => $validatedSubjectName,
            ], [
                'role' => 'Tutor',
                'head' => 1,
                'grade' => '[9-12]',
                'fee_individual' => $validatedFeeIndividual,
                'tax' => $validatedTax
            ]);
            
        } elseif ($refProgram && $refProgram->require === 'Mentor') { # require mentor
            $tempUserRoles = TempUserRoles::firstOrCreate([
                'temp_user_id' => $mentorTutorId,
                'role' => 'External Mentor'
            ], [
                'year' => Carbon::format('Y'),
                'head' => 1,
                'grade' => '[9-12]',
                'fee_individual' => $validatedFeeIndividual,
                'tax' => $validatedTax
            ]);
        }

        
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

        $createTimesheetService->storeTimesheet($validatedRefPrograms, $newPackageDetails, $validatedNotes, $validatedInhouse, $validatedPics, $mentorTutorId, $validatedSubject);
    
        return response()->json([
            'message' => "Timesheet has been created successfully."
        ]);
    }

    public function update(
        $timesheetId,
        TimesheetStoreRequest $request,
        IdentifyTimesheetIdAction $identifyTimesheetIdAction,
        UpdateTimesheetAction $updateTimesheetAction,
        ): JsonResponse
    {
        $timesheet = $identifyTimesheetIdAction->execute($timesheetId);

        $validated = $request->safe()->only([
            'ref_id',
            'mentortutor_email',
            'inhouse_id',
            'package_id',
            'duration',
            'pic_id',
            'notes',
            'subject_id',
        ]); 

        /* defines the validated variables */
        $validatedEmail = $validated['mentortutor_email'];
        $validatedInhouse = $validated['inhouse_id'];
        $validatedPics = $validated['pic_id'];
        $validatedPackageId = $validated['package_id'];
        $validatedDuration = $validated['duration'];
        $validatedNotes = $validated['notes'];
        $validatedSubject = $validated['subject_id'];

        $newPackageDetails = compact('validatedPackageId', 'validatedDuration');

        $mentorTutorId = TempUser::where('email', $validatedEmail)->first()->id;
        $updateTimesheetAction->execute($timesheet, $newPackageDetails, $validatedNotes, $validatedInhouse, $validatedPics, $mentorTutorId, $validatedSubject);

        return response()->json([
            'message' => 'Timesheet has been updated successfully.'
        ]);
    }

    public function destroy(
        $timesheetId,
        IdentifyTimesheetIdAction $identifyTimesheetIdAction,
        ): JsonResponse
    {
        DB::beginTransaction();    
        $timesheet = $identifyTimesheetIdAction->execute($timesheetId);
        
        if ( $timesheet->delete() )
            DB::commit();
            

        return response()->json([
            'message' => 'Timesheet has been deleted successfully.'
        ]);

    }

    public function patch (
        $timesheetId,
        TimesheetStoreRequest $request,
        IdentifyTimesheetIdAction $identifyTimesheetIdAction,
        VoidTimesheetAction $voidTimesheetAction,
        CreateTimesheetService $createTimesheetService,
        SelectOrRegisterMentorTutorTimesheetAction $selectOrRegisterMentorTutorTimesheetAction,
    ): JsonResponse
    {
        $timesheet = $identifyTimesheetIdAction->execute($timesheetId);
        $validated = $request->safe()->only([
            'mentortutor_email',
            'subject_id',
        ]);

        /* defines the validated variables */
        $validatedRefPrograms = $timesheet->ref_program()->pluck('id')->toArray();
        $validatedEmail = $validated['mentortutor_email'];
        $validatedInhouse = $timesheet->inhouse_id;
        $validatedPics = $timesheet->admin()->pluck('users.id')->toArray();
        $validatedPackageId = $timesheet->package_id;
        $validatedDuration = $timesheet->time_left;
        $validatedNotes = $timesheet->notes;
        $validatedSubject = $validated['subject_id'];

        $newPackageDetails = compact('validatedPackageId', 'validatedDuration');
        $mentorTutorId = $selectOrRegisterMentorTutorTimesheetAction->handle($validatedEmail);
        $newTimesheetId = $createTimesheetService->replaceTimesheet($validatedRefPrograms, $newPackageDetails, $validatedNotes, $validatedInhouse, $validatedPics, $mentorTutorId, $validatedSubject);


        # put the log into log_ref_programs
        $voidTimesheetAction->execute($timesheet);

        return response()->json([
            'message' => 'The timesheet has been successfully transferred.',
            'data' => [
                'timesheet_id' => $newTimesheetId
            ]
        ], JsonResponse::HTTP_OK);

    }

    public function export(
        $timesheetId, 
        IdentifyTimesheetIdAction $identifyTimesheetIdAction,
        TimesheetDataService $timesheetDataService,
        ActivityDataService $activityDataService,
        )
    {
        $timesheet = $identifyTimesheetIdAction->execute($timesheetId);
        $detailTimesheet = $timesheetDataService->detailTimesheet($timesheet);
        $timesheetActivities = $activityDataService->listActivitiesByTimesheet($timesheet);

        // $filename = $this->generateFileName($mappedTimesheetData);
        $filename = 'Timesheet_' . date('YmdHis') . '.xlsx';

        return Excel::download(new TimesheetExport($detailTimesheet, $timesheetActivities), $filename);
    }
}
