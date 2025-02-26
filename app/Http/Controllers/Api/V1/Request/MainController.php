<?php

namespace App\Http\Controllers\Api\V1\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request\StoreRequest;
use App\Models\Ref_Program;
use App\Services\Program\RefProgramServices;
use App\Services\Timesheet\TimesheetDataService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $timesheetDataService;

    public function __construct(TimesheetDataService $timesheetDataService)
    {
        $this->timesheetDataService = $timesheetDataService;
    }
    
    public function index(Request $request)
    {
        /* incoming request */
        $search = $request->only(['program_name', 'keyword']);
        $ref_success_programs = Ref_Program::mentoring()->onSearch($search)->orderBy('clientprog_id', 'desc')->paginate(10);
        return response()->json($ref_success_programs);
    }

    public function store(
        StoreRequest $request,
        RefProgramServices $refProgramServices
        )
    {
        $validated = $request->safe()->only([
            'clientprog_id',
            'invoice_id',
            'student_uuid',
            'student_name',
            'student_school',
            'student_grade',
            'program_name',
            'engagement_type',
            'notes',
        ]);

        $new = $refProgramServices->createOne($validated);
        return response()->json([
            'message' => 'Request has created successfully.',
            'data' => $new
        ]);
    }
}
