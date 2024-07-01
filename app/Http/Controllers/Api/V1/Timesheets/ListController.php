<?php

namespace App\Http\Controllers\Api\V1\Timesheets;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /* Incoming Request */
        $search = $request->only(['program_name', 'timesheet_package']);
        
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
                ]
            )->
            onSearch($search)->
            select('timesheets.id', 'package_type', 'detail_package', 'duration', 'notes')->
            get();

        $mappedTimesheets = $timesheets->map(function ($data) {

            $category = $data->ref_program->category;
            $timesheetId = $data->id;
            $packageType = $data->package_type;
            $detailPackage = $data->detail_package;
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

        return response()->json($mappedTimesheets);
    }
}
