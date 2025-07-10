<?php

namespace App\Http\Controllers\Api\V1\MentorTutor;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\Package;
use App\Models\Ref_Program;
use App\Models\TempUser;
use App\Models\TempUserRoles;
use App\Models\Timesheet;
use App\Services\Timesheet\TimesheetDataService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function comp_subjects(TempUser $tempUser, ?Curriculum $curriculum = null)
    {
        # because there were changes to the creation of timesheet
        # like: subjects now fetched from timesheet database instead of CRM
        # so I'll put the change here

        # after changes
        // $subjects = [
        //     'Chemistry',
        //     'Biology',
        //     'SAT English',
        //     'SAT Math & English',
        //     'SAT Math',
        //     'TOEFL',
        //     'IELTS',
        //     'IB Writing',
        //     'Mathematics',
        //     'Environmental Sciences & Society (ESS)',
        //     'Physics',
        //     'Economics',
        //     'Computer Science',
        //     'Programming',
        //     'Life Science',
        //     'English',
        //     'Business Management'
        // ];
        // $subject_collections = collect($subjects)->sort()->values()->all();
        // return response()->json($subject_collections);


        # preferably return subject owned by tutor/mentor him/herself
        $data = TempUserRoles::where('temp_user_id', $tempUser->id)->
            when($curriculum, function ($query) use ($curriculum) {
                $query->where('curriculum_id', $curriculum->id);
            })->
            whereRaw('now() BETWEEN start_date AND end_date')->
            active()->
            orderBy('tutor_subject', 'asc')->
            select(['id', 'tutor_subject'])->get();
        return response()->json($data);
    }

    public function former_comp_subjects($mentorTutorsUuid): JsonResponse
    {
        # before changes

        $subjects = TempUserRoles::tutor()->whereHas('temp_user', function ($query) use ($mentorTutorsUuid) {
            $query->where('uuid', $mentorTutorsUuid);
        })->get();

        $mappedSubjects = $subjects->map(function ($data) {
            return [
                'id' => $data->id,
                'role' => $data->role,
                'subject' => $data->tutor_subject,
            ];
        });

        return response()->json($mappedSubjects);
    }

    public function comp_students(
        $mentorTutorUuid,
        TimesheetDataService $timesheetDataService,
    ): JsonResponse {
        $responses = $timesheetDataService->fetchTimesheetsByHandler($mentorTutorUuid);

        return response()->json($responses);
    }
}
