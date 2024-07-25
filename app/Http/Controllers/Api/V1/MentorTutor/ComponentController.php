<?php

namespace App\Http\Controllers\Api\V1\MentorTutor;

use App\Http\Controllers\Controller;
use App\Models\TempUserRoles;
use App\Models\Timesheet;
use App\Services\Timesheet\TimesheetDataService;
use Illuminate\Http\JsonResponse;

class ComponentController extends Controller
{
    public function comp_subjects($mentorTutorsUuid): JsonResponse
    {
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
        ): JsonResponse
    {
        $responses = $timesheetDataService->fetchTimesheetsByHandler($mentorTutorUuid);

        return response()->json($responses);
    }
}
