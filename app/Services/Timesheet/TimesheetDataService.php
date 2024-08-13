<?php

namespace App\Services\Timesheet;

use App\Http\Traits\HttpCall;
use App\Models\Timesheet;
use App\Services\Token\TokenService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class TimesheetDataService
{
    use HttpCall;

    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function listTimesheet(array $search = [])
    {
        $timesheets = Timesheet::query()->
            with(
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
                    'inhouse_pic' => function ($query) {
                        $query->select('uuid', 'full_name');
                    },
                ]
            )->
            onSearch($search)->
            select('timesheets.id', 'inhouse_id', 'package_id', 'duration', 'notes')->
            get();

        $mappedTimesheets = $timesheets->map(function ($data) {

            # because timesheets consists of multiple ref programs
            # we need to extract and define whether the client was b2c or b2b
            $clients = array();
            $refProgram = $data->ref_program;
            if (count($refProgram) > 1) {
                foreach ($refProgram as $ref) {
                    $category = $ref->category;
                    $studentName = $ref->student_name;
                    $studentSchool = $ref->student_school;
                    $client = $category == "b2c" ? $studentName : $studentSchool;

                    array_push($clients, $client);
                }
            } else {
                $category = $refProgram->first()->category;
                $studentName = $refProgram->first()->student_name;
                $studentSchool = $refProgram->first()->student_school;
                $clients = $category == "b2c" ? $studentName : $studentSchool;
            }

            $timesheetId = $data->id;
            $packageType = $data->package->type_of;
            $detailPackage = $data->package->package;
            $duration = $data->duration;
            $notes = $data->notes;
            $programName = $refProgram->first()->program_name;
            $tutorMentorName = $data->handle_by->first()->full_name;
            $adminName = $data->admin->first()->full_name;
            $total_timespent = $data->activities()->unpaid()->sum('time_spent');

            return [
                'id' => $timesheetId,
                'package_type' => $packageType,
                'detail_package' => $detailPackage,
                'duration' => $duration,
                'notes' => $notes,
                'program_name' => $programName,
                'tutor_mentor' => $tutorMentorName,
                'admin' => $adminName,
                'spent' => $total_timespent,
                'group' => count($refProgram) > 1 ? true : false,
                'clients' => $clients
            ];
        });

        return $mappedTimesheets->paginate(10);
    }

    public function detailTimesheet(Timesheet $timesheet)
    {
        $refProgram = $timesheet->ref_program;
        # because timesheets consists of multiple ref programs
        # we need to extract and define whether the client was b2c or b2b

        $clients = array();
        if (count($refProgram) > 1) {
            foreach ($refProgram as $ref) {
                $category = $ref->category;
                $studentUUID = $ref->student_uuid;
                $studentName = $ref->student_name;
                $studentSchool = $ref->student_school;
                $client = $category == "b2c" ? $studentName : $studentSchool;

                if ($category == "b2c") {
                    /* fetch the client profile information from CRM */
                    [$statusCode, $crm_clientInfo] = $this->make_call('get', env('CRM_DOMAIN') . 'client/information/' . $studentUUID);

                    array_push($clients, [
                        'category' => $category,
                        'client_name' => $studentName,
                        'client_mail' => $crm_clientInfo['mail'],
                        'client_school' => $studentSchool,
                        'client_grade' => $crm_clientInfo['grade'],
                    ]);
                    continue;
                }

                if ($category == "b2b") {
                    array_push($clients, [
                        'category' => $category,
                        'client_school' => $studentSchool
                    ]);
                    continue;
                }
            }
        } else {
            $category = $refProgram->first()->category;
            $studentUUID = $refProgram->first()->student_uuid;
            $studentName = $refProgram->first()->student_name;
            $studentSchool = $refProgram->first()->student_school;

            if ($category == "b2c") {
                /* fetch the client profile information from CRM */
                [$statusCode, $crm_clientInfo] = $this->make_call('get', env('CRM_DOMAIN') . 'client/information/' . $studentUUID);

                array_push($clients, [
                    'category' => $category,
                    'client_name' => $studentName,
                    'client_mail' => $crm_clientInfo['mail'],
                    'client_school' => $studentSchool,
                    'client_grade' => $crm_clientInfo['grade'],
                ]);
            }
        }


        /* fetch the package details */
        $programName = $refProgram->first()->program_name;
        $package = $timesheet->package;
        $packageId = $timesheet->package_id;
        $packageCategory = $timesheet->package->category;
        $packageType = $timesheet->package->type_of;
        $packageName = $timesheet->package->package;
        $detailPackage = $timesheet->detail_package;
        $duration = $timesheet->duration;
        $timeSpent = $timesheet->activities()->sum('time_spent');
        $notes = $timesheet->notes;


        /* fetch the person in charge */
        $admin = $timesheet->admin;
        $adminId = $admin->pluck('id')->toArray();
        $adminName = implode(", ", $admin->pluck('full_name')->toArray());
        $tutorMentor = $timesheet->handle_by->first();
        $tutorMentorUuid = $tutorMentor->uuid;
        $tutorMentorEmail = $tutorMentor->email;
        $tutorMentorName = $tutorMentor->full_name;
        $inhouseUuid = $timesheet->inhouse_pic->uuid;
        $inhouseName = $timesheet->inhouse_pic->full_name;
        $last_updated = $timesheet->updated_at;
        $clientProfile = $clients;
        $packageDetails = [
            'program_name' => $programName,
            'package_id' => $packageId,
            'package_category' => $packageCategory,
            'package_type' => $packageType,
            'package_name' => $packageName,
            'pic_name' => $adminName,
            'tutormentor_name' => $tutorMentorName,
            'inhouse_name' => $inhouseName,
            'last_updated' => $last_updated,
            'duration_in_minutes' => $duration,
            'time_spent_in_minutes' => $timeSpent,
        ];


        /* fetch the data to support editable columns */
        $subjectId = $timesheet->subject_id;
        $editableColumns = [
            'pic_id' => $adminId,
            'tutormentor_id' => $tutorMentorUuid,
            'tutormentor_email' => $tutorMentorEmail,
            'duration' => $duration,
            'notes' => $notes,
            'subject_id' => $subjectId,
            'inhouse_id' => $inhouseUuid
        ];

        return compact('clientProfile', 'packageDetails', 'editableColumns');
    }

    public function fetchTimesheetsByHandler(string $search) /* handle by who */
    {
        $timesheets = Timesheet::with([
            'ref_program' => function ($query) {
                $query->select('category', 'student_name', 'student_school', 'program_name', 'timesheet_id');
            },
        ])->
        handleBy($search)->
        select('timesheets.id', 'inhouse_id', 'package_id', 'duration', 'notes')->
        get();

        $mappedTimesheets = $timesheets->map(function ($data) {
            # because timesheets consists of multiple ref programs
            # we need to extract and define whether the client was b2c or b2b
            $clients = array();
            $refProgram = $data->ref_program;
            if ( count($refProgram) > 1 )
            {
                foreach ( $refProgram as $ref )
                {
                    $category = $ref->category;
                    $studentName = $ref->student_name;
                    $studentSchool = $ref->student_school;
                    $client = $category == "b2c" ? $studentName : $studentSchool;

                    array_push($clients, $client);
                }
            } else {
                $category = $refProgram->first()->category;
                $studentName = $refProgram->first()->student_name;
                $studentSchool = $refProgram->first()->student_school;
                $clients = $category == "b2c" ? $studentName : $studentSchool;
            }

            $timesheetId = $data->id;
            $packageType = $data->package->type_of;
            $detailPackage = $data->package->package;
            $notes = $data->notes;
            $programName = $refProgram->first()->program_name;

            return [
                'id' => $timesheetId,
                'package_type' => $packageType,
                'detail_package' => $detailPackage,
                'notes' => $notes, 
                'program_name' => $programName,
                'group' => count($refProgram) > 1 ? true : false,
                'clients' => $clients,
            ];
        });
        
        return $mappedTimesheets;
    }
}
