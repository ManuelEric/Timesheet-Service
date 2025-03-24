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

    public function listTimesheet(array $search = [], $is_subject_specialist = null)
    {
        $timesheets = Timesheet::query()->with(
            [
                'ref_program.engagement_type' => function ($query) {
                    $query->select('id', 'name');
                },
                'ref_program' => function ($query) {
                    $query->select('category', 'student_name', 'student_school', 'program_name', 'timesheet_id', 'require', 'engagement_type_id');
                },
                'second_ref_program' => function ($query) {
                    $query->select('category', 'student_name', 'student_school', 'program_name', 'scnd_timesheet_id', 'require', 'engagement_type_id');
                },
                'transferred' => function ($query) {
                    $query->select('category', 'student_name', 'student_school', 'program_name', 'require');
                },
                'handle_by' => function ($query) {
                    $query->select('temp_users.id', 'full_name');
                },
                'admin' => function ($query) {
                    $query->select('users.id', 'full_name');
                },
                'activities' => function ($query) {
                    $query->select('timesheet_id', 'time_spent');
                },
                'package' => function ($query) {
                    $query->select('id', 'type_of', 'package');
                },
                'inhouse_pic' => function ($query) {
                    $query->select('uuid', 'full_name');
                },
            ]
        )->
        when($is_subject_specialist, function ($query) {
            $query->mentoring();
        }, function ($query) {
            $query->tutoring();
        })->
        onSearch($search)->
        onSession()->
        newest()->
        select('timesheets.id', 'inhouse_id', 'package_id', 'duration', 'notes', 'void', 'created_at')->get();

        $mappedTimesheets = $timesheets->map(function ($data) {

            # because timesheets consists of multiple ref programs
            # we need to extract and define whether the client was b2c or b2b
            $clients = array();
            $refProgram = count($data->ref_program) > 0 ? $data->ref_program : $data->second_ref_program;
            $transferredLog = $data->transferred;

            if ( count($refProgram) > 0 )
            {
                # if timesheet has multiple ref programs
                if (count($refProgram) > 1) {
                    foreach ($refProgram as $ref) {
                        $category = $ref->category;
                        $studentName = $ref->student_name;
                        $studentSchool = $ref->student_school;
                        $client = $category == "b2c" ? $studentName : $studentSchool;
    
                        array_push($clients, $client);
                    }
                # if timesheet has only one ref program
                } else {
                    $category = $refProgram->first()->category;
                    $studentName = $refProgram->first()->student_name;
                    $studentSchool = $refProgram->first()->student_school;
                    $clients = $category == "b2c" ? $studentName : $studentSchool;
                }
                $programName = $refProgram->first()->program_name;
                $engagementType = $refProgram->first()->engagement_type ? $refProgram->first()->engagement_type->name : null;
                $requirements = $refProgram->first()->require;
            }

            # if timesheet has been transferred
            if ( count($transferredLog) > 0)
            {
                if (count($transferredLog) > 1) {
                    foreach ($transferredLog as $ref) {
                        $category = $ref->category;
                        $studentName = $ref->student_name;
                        $studentSchool = $ref->student_school;
                        $client = $category == "b2c" ? $studentName : $studentSchool;
    
                        array_push($clients, $client);
                    }
                } else {
                    $category = $transferredLog->first()->category;
                    $studentName = $transferredLog->first()->student_name;
                    $studentSchool = $transferredLog->first()->student_school;
                    $clients = $category == "b2c" ? $studentName : $studentSchool;
                }
                $programName = $transferredLog->first()->program_name;
                $engagementType = $refProgram->first()->engagement_type ? $refProgram->first()->engagement_type->name : null;
                $requirements = $transferredLog->first()->require;
            }

            $timesheetId = $data->id;
            $packageType = $data->package->type_of;
            $detailPackage = $data->package->package;
            $duration = $data->duration;
            $notes = $data->notes;
            $void = $data->void;
            $tutorMentorName = $data->handle_by->first()->full_name;
            $adminName = $data->admin->first()->full_name;
            $total_timespent = $data->activities()->completed()->sum('time_spent');

            return [
                'id' => $timesheetId,
                'package_type' => $packageType,
                'detail_package' => $detailPackage,
                'duration' => $duration,
                'notes' => $notes,
                'program_name' => $programName,
                'require' => $requirements,
                'tutor_mentor' => $tutorMentorName,
                'admin' => $adminName,
                'spent' => $total_timespent,
                'group' => count($refProgram) > 1 ? true : false,
                'clients' => $clients,
                'void' => $void,
                'engagement_type' => $engagementType,
                'created_at' => $data->created_at,
            ];
        });

        return $mappedTimesheets->sortBy('clients')->values()->paginate();
    }

    public function detailTimesheet(Timesheet $timesheet)
    {
        $refProgram = $timesheet->ref_program;
        $transferredLog = $timesheet->transferred;
        $relatedProgram = count($refProgram) > 0 ? $refProgram : $transferredLog;
        # because timesheets consists of multiple ref programs
        # we need to extract and define whether the client was b2c or b2b

        [$clients, $programName, $freeTrial] = $this->fetchRelatedProgram($relatedProgram);

        /* fetch the package details */
        $package = $timesheet->package;
        $packageId = $timesheet->package_id;
        $packageCategory = $timesheet->package->category;
        $packageType = $timesheet->package->type_of;
        $packageName = $timesheet->package->package;
        $detailPackage = $timesheet->detail_package;
        $duration = $timesheet->duration;
        $timeSpent = $timesheet->activities()->sum('time_spent');
        $notes = $timesheet->notes;
        $void = $timesheet->void;


        /* fetch the person in charge */
        $admin = $timesheet->admin;
        $adminId = $admin->pluck('id')->toArray();
        $adminName = implode(", ", $admin->pluck('full_name')->toArray());
        $tutorMentor = $timesheet->handle_by->first();
        $tutorMentorUuid = $tutorMentor->uuid;
        $tutorMentorEmail = $tutorMentor->email;
        $tutorMentorName = $tutorMentor->full_name;
        $tutorMentorHasNPWP = $tutorMentor->has_npwp;
        $inhouseUuid = $timesheet->inhouse_pic->uuid;
        $inhouseName = $timesheet->inhouse_pic->full_name;
        $last_updated = $timesheet->updated_at;
        $clientProfile = $clients;
        $engagement_type = $refProgram->first()->engagement_type 
            ? $refProgram->first()->engagement_type->name
            : null;
        $tax = $timesheet->subject->tax;
        $packageDetails = [
            'program_name' => $programName,
            'void' => $timesheet->void,
            'package_id' => $packageId,
            'package_category' => $packageCategory,
            'package_type' => $packageType,
            'package_name' => $packageName,
            'free_trial' => $freeTrial,
            'pic_name' => $adminName,
            'tutormentor_name' => $tutorMentorName,
            'tutormentor_has_npwp' => $tutorMentorHasNPWP,
            'tutormentor_tax' => $tax,
            'inhouse_name' => $inhouseName,
            'last_updated' => $last_updated,
            'duration_in_minutes' => $duration,
            'time_spent_in_minutes' => $timeSpent,
            'engagement_type' => $engagement_type,
        ];


        /* fetch the data to support editable columns */
        $subjectId = $timesheet->subject_id;
        
        $editableColumns = [
            'pic_id' => $adminId,
            'tutormentor_id' => $tutorMentorUuid,
            'tutormentor_email' => $tutorMentorEmail,
            'tutormentor_role' => $timesheet->subject->role,
            'duration' => $duration,
            'notes' => $notes,
            'subject_id' => $subjectId,
            'inhouse_id' => $inhouseUuid,
            'curriculum_name' => $timesheet->subject->curriculum ? $timesheet->subject->curriculum->name : null
        ];

        return compact('clientProfile', 'packageDetails', 'editableColumns');
    }

    private function fetchRelatedProgram($relatedProgram): array
    {
        $clients = array();
        if (count($relatedProgram) > 1) {
            foreach ($relatedProgram as $ref) {
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
            $category = $relatedProgram->first()->category;
            $studentUUID = $relatedProgram->first()->student_uuid;
            $studentName = $relatedProgram->first()->student_name;
            $studentSchool = $relatedProgram->first()->student_school;

            if ($category == "b2c") {
                /* fetch the client profile information from CRM */
                [$statusCode, $crm_clientInfo] = $this->make_call('get', env('CRM_DOMAIN') . 'client/information/' . $studentUUID);

                array_push($clients, [
                    'category' => $category,
                    'client_name' => $studentName,
                    'client_mail' => $crm_clientInfo['mail'] ?? null,
                    'client_school' => $studentSchool,
                    'client_grade' => $crm_clientInfo['grade'],
                ]);
            }
        }

        
        $programName = $relatedProgram->first()->program_name;
        $freeTrial = $relatedProgram->first()->free_trial ? true : false;

        return [$clients, $programName, $freeTrial];
    }

    public function fetchTimesheetsByHandler(string $search) /* handle by who */
    {
        $timesheets = Timesheet::with([
            'ref_program' => function ($query) {
                $query->select('category', 'student_name', 'student_school', 'program_name', 'timesheet_id');
            },
        ])->handleBy($search)->select('timesheets.id', 'inhouse_id', 'package_id', 'duration', 'notes')->get();

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

    public function listTimesheetByCutoffDate(string $start_date, string $end_date)
    {
        $search = [
            'cutoff_start' => $start_date,
            'cutoff_end' => $end_date
        ];
        
        /* we're gonna find timesheets using cutoff `from` and `to` */
        $timesheets = Timesheet::with('activities')->filterCutoff($search)->get();
        return $timesheets;
    }
}
