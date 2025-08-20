<?php

namespace App\Http\Controllers\Api\V1\Programs;

use App\Http\Controllers\Controller;
use App\Models\Ref_Program;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExternalController extends Controller
{
    public function index(Request $request)
    {
        $clientprog_id = $request->route('clientprog_id');
        $ref_program = Ref_Program::where('clientprog_id', $clientprog_id)->first();
        
        if ( !isset($ref_program->timesheet) )
        {
            return response()->json([
                'message' => 'Timesheet not found'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $package_details = [
            'name' => $ref_program->timesheet->package->package,
            'unit' => 'minutes',
            'duration' => $ref_program->timesheet->duration,
            'spent' => DB::table('timesheets')->selectRaw('sum_activity_time_based_on_timesheet(?) as total_spent', [$ref_program->timesheet->id])->first()->total_spent ?? 0,
            'notes' => $ref_program->timesheet->notes,
            'subject' => $ref_program->timesheet->subject->tutor_subject,
            'tutor_name' => $ref_program->timesheet->subject->temp_user->full_name
        ];

        return response()->json([
            'message' => 'Timesheet detail found',
            'data' => $package_details,
        ], JsonResponse::HTTP_OK);
    }
}
