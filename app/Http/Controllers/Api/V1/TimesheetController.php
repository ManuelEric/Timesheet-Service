<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Timesheet\CreateTimesheetAction;
use App\Actions\Timesheet\IdentifierCheckingAction as IdentifyTimesheetIdAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Timesheet\StoreRequest as TimesheetStoreRequest;
use App\Actions\Timesheet\SelectOrRegisterMentorTutorAction as SelectOrRegisterMentorTutorTimesheetAction;
use App\Actions\Timesheet\UpdateTimesheetAction;
use App\Exports\TimesheetExport;
use App\Http\Traits\GenerateTimesheetFileName;
use App\Models\TempUser;
use App\Models\Timesheet;
use App\Services\Activity\ActivityDataService;
use App\Services\Timesheet\TimesheetDataService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TimesheetController extends Controller
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
        $results = $this->timesheetDataService->listTimesheet($search);
        return response()->json($results);
    }

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

    /**
     * The components.
     */
    public function component(
        Request $request,
        TimesheetDataService $timesheetDataService,
        ): JsonResponse
    {
        $search = $request->only(['cutoff_start', 'cutoff_end']);
        $timesheets = Timesheet::has('ref_program')->filterCutoff($search)->get();
        $mappedComponents = $timesheets->map(function ($data) use ($timesheetDataService)
        {
            /* initialize variables */
            $detailTimesheet = $timesheetDataService->detailTimesheet($data);
            unset($detailTimesheet['editableColumns']);

            /* manipulate variables */
            $clients = count($detailTimesheet['clientProfile']) > 1 ? implode(', ', array_column($detailTimesheet['clientProfile'], 'client_name')) : $detailTimesheet['clientProfile'][0]['client_name'];
            $programName = $detailTimesheet['packageDetails']['program_name'];
            $packageType = $detailTimesheet['packageDetails']['package_type'];
            $packageName = $detailTimesheet['packageDetails']['package_name'];

            return [
                'id' => $data->id,
                'clients' => $clients,
                'program_name' => $programName,
                'package_type' => $packageType,
                'package_name' => $packageName,
            ];
        }); 

    
        return response()->json($mappedComponents);
    }
}
