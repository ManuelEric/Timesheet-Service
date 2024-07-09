<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\Timesheet\CreateTimesheetAction;
use App\Actions\Timesheet\IdentifierCheckingAction as IdentifyTimesheetIdAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Timesheet\StoreRequest as TimesheetStoreRequest;
use App\Actions\Timesheet\SelectOrRegisterMentorTutorAction as SelectOrRegisterMentorTutorTimesheetAction;
use App\Models\Timesheet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /* Incoming Request */
        $search = $request->only(['program_name', 'package_id', 'keyword']);
        
        $timesheets = Timesheet::with(
                [
                    'ref_program' => function ($query) {
                        $query->select('category', 'student_name', 'student_school', 'program_name', 'timesheet_id');
                    },
                    'handle_by' => function ($query) {
                        $query->select('temp_users.id', 'full_name');
                    },
                    'admin' => function ($query) {
                        $query->select('users.id', 'full_name');
                    },
                    'activities' => function ($query) {
                        $query->select('time_spent');
                    },
                    'package' => function ($query) {
                        $query->select('id', 'type_of', 'package');
                    },
                ]
            )->
            onSearch($search)->
            select('timesheets.id', 'package_id', 'duration', 'notes')->
            get();

        $mappedTimesheets = $timesheets->map(function ($data) {

            $category = $data->ref_program->category;
            $timesheetId = $data->id;
            $packageType = $data->package->type_of;
            $detailPackage = $data->package->package;
            $duration = $data->duration;
            $notes = $data->notes;
            $studentName = $data->ref_program->student_name;
            $studentSchool = $data->ref_program->student_school;
            $programName = $data->ref_program->program_name;
            $tutorMentorName = $data->handle_by->first()->full_name;
            $adminName = $data->admin->first()->full_name;
            $total_timespent = $data->activities()->sum('time_spent');

            return [
                'id' => $timesheetId,
                'package_type' => $packageType,
                'detail_package' => $detailPackage,
                'duration' => $duration,
                'notes' => $notes, 
                'program_name' => $programName,
                'tutor_mentor' => $tutorMentorName,
                'admin' => $adminName,
                'client' => $category == "b2c" ? $studentName : $studentSchool,
                'spent' => $total_timespent
            ];
        });

        $results = $mappedTimesheets->paginate(10);

        return response()->json($results);
    }

    public function show(
        IdentifyTimesheetIdAction $identifyTimesheetIdAction, 
        $timesheetId
        ): JsonResponse
    {
        $timesheet = $identifyTimesheetIdAction->execute($timesheetId);

        $refProgram = $timesheet->ref_program;

        /* fetch the client profile information */
        $category = $refProgram->category;
        $isB2c = $category == "b2c" ? true : false;
        $clientName = $isB2c ? $refProgram->student_name : NULL; 
        $clientSchool = $refProgram->student_school;
        $clientProfile = [
            'client_name' => $clientName,
            'client_school' => $clientSchool,
        ];

        /* fetch the package details */
        $programName = $refProgram->program_name;
        $package = $timesheet->package;
        $packageType = $timesheet->package_type;
        $detailPackage = $timesheet->detail_package;
        $duration = $timesheet->duration;
        $timeSpent = $timesheet->activities()->sum('time_spent');
        $notes = $timesheet->notes;

        /* fetch the person in charge */
        $admin = $timesheet->admin;
        $adminName = implode(", ", $admin->pluck('full_name')->toArray());
        $tutorMentor = $timesheet->handle_by;
        $tutorMentorName = implode(", ", $timesheet->handle_by->pluck('full_name')->toArray());

        $last_updated = $timesheet->updated_at;
        
        $packageDetails = [
            'program_name' => $programName,
            'package_type' => $packageType,
            'pic' => $adminName,
            'tutor_mentor' => $tutorMentorName,
            'last_updated' => $last_updated,
            'duration_in_hours' => $duration,
            'time_spent_in_hours' => $timeSpent,
        ];

        $result = compact('clientProfile', 'packageDetails');

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
