<?php

namespace App\Http\Controllers\Api\V1\MentorTutor;

use App\Http\Controllers\Controller;
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
    public function comp_subjects()
    {
        # because there were changes to the creation of timesheet
        # like: subjects now fetched from timesheet database instead of CRM
        # so I'll put the change here

        # after changes
        $subjects = [
            'Chemistry',
            'Biology',
            'SAT English',
            'SAT Math & English',
            'SAT Math',
            'TOEFL',
            'IELTS',
            'IB Writing',
            'Mathematics',
            'Environmental Sciences & Society (ESS)',
            'Physics',
            'Economics',
            'Computer Science',
            'Programming',
            'Life Science',
            'English',
            'Business Management'
        ];
        $subject_collections = collect($subjects)->sort()->values()->all();
        return response()->json($subject_collections);
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

    public function comp_fee_mentor(Request $request, TempUser $tempUser)
    {
        $search = $request->only(['ref_program_id', 'engagement_type', 'package']);
        $ref_program = Ref_Program::find($search['ref_program_id']);
        //! perlu dapet nama streamsnya agar bisa get fee sesuai stream

        $package = Package::where('type_of', $search['package'])->first();

        $mentor_fee = TempUserRoles::where('temp_user_id', $tempUser->id)->
            where('ext_mentor_engagement_type', $search['engagement_type'])->
            when( $package, function ($query) use ($package) {
                $query->where('ext_mentor_package', $package->type_of);
            })->active()->first();

        return response()->json([
            'message' => 'Fee Mentor has found.',
            'data' => $mentor_fee
        ]);
    }
}
