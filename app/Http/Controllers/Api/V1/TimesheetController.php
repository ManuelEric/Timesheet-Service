<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Timesheet\CreateTimesheetAction;
use App\Actions\Timesheet\IdentifierCheckingAction as IdentifyTimesheetIdAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Timesheet\StoreRequest as TimesheetStoreRequest;
use App\Actions\Timesheet\SelectOrRegisterMentorTutorAction as SelectOrRegisterMentorTutorTimesheetAction;
use App\Models\Timesheet;
use App\Services\Timesheet\MappingTimesheetDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TimesheetController extends Controller
{
    protected $mappingTimesheetService;

    public function __construct(MappingTimesheetDataService $mappingTimesheetService)
    {
        $this->mappingTimesheetService = $mappingTimesheetService;
    }

    public function index(Request $request): JsonResponse
    {
        /* Incoming Request */
        $search = $request->only(['program_name', 'package_id', 'keyword']);
        $results = $this->mappingTimesheetService->listTimesheet($search);
        return response()->json($results);
    }

    public function show(
        IdentifyTimesheetIdAction $identifyTimesheetIdAction, 
        $timesheetId
        ): JsonResponse
    {
        $timesheet = $identifyTimesheetIdAction->execute($timesheetId);
        $result = $this->mappingTimesheetService->detailTimesheet($timesheet);
        return response()->json($result);
    }

    public function store(
        TimesheetStoreRequest $request,
        SelectOrRegisterMentorTutorTimesheetAction $selectOrRegisterMentorTutorTimesheetAction,
        CreateTimesheetAction $createTimesheetAction,
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
            'subject_id',
        ]); 

        /* defines the validated variables */
        $validatedRefPrograms = $validated['ref_id'];
        $validatedEmail = $validated['mentortutor_email'];
        $validatedInhouse = $validated['inhouse_id'];
        $validatedPics = $validated['pic_id'];
        $validatedPackageId = $validated['package_id'];
        $validatedDuration = $validated['duration'];
        $validatedNotes = $validated['notes'];
        $validatedSubject = $validated['subject_id'];

        $newPackageDetails = compact('validatedPackageId', 'validatedDuration');

        $mentorTutorId = $selectOrRegisterMentorTutorTimesheetAction->handle($validatedEmail);
        $createTimesheetAction->execute($validatedRefPrograms, $newPackageDetails, $validatedNotes, $validatedInhouse, $validatedPics, $mentorTutorId, $validatedSubject);
    
        return response()->json([
            'message' => "Timesheet has been created successfully."
        ]);
    }

    public function update(
        $timesheetId,
        Request $request,
        IdentifyTimesheetIdAction $identifyTimesheetIdAction
        )
    {
        $timesheet = $identifyTimesheetIdAction->execute($timesheetId);

        
        //! ketika save update-an terbaru
        //! system perlu nge trigger
        //! $timesheet->handle_by->stored() 
    }
}
