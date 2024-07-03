<?php

namespace App\Http\Controllers\Api\V1\Timesheets;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function show($timesheetId): JsonResponse
    {
        $timesheet = Timesheet::with('ref_program', 'package', 'admin', 'handle_by')->find($timesheetId);
        if ( !$timesheet ) {
            return response()->json([
                'errors' => 'Invalid code provided.'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

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
}
