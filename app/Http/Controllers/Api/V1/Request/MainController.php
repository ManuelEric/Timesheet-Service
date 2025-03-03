<?php

namespace App\Http\Controllers\Api\V1\Request;

use App\Actions\Request\CancelRequestAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request\StoreRequest;
use App\Http\Requests\Request\UpdateRequest;
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
        $ref_admissions_programs = Ref_Program::with([
                'engagement_type' => function ($query) {
                    $query->select('id', 'name');
                }
            ])->mentoring()->onSearch($search)->orderBy('clientprog_id', 'desc')->get();
        
        $mapped_ref_admissions_programs = $ref_admissions_programs->map(function ($item) {
            return [
                'id' => $item->id,
                'category' => $item->category,
                'clientprog_id' => $item->clientprog_id,
                'schprog_id' => $item->schprog_id,
                'invoice_id' => $item->invoice_id,
                'student_uuid' => $item->student_uuid,
                'student_name' => $item->student_name,
                'student_school' => $item->student_school,
                'student_grade' => $item->student_grade,
                'program_name' => $item->program_name,
                'free_trial' => $item->free_trial,
                'require' => $item->require,
                'timesheet_id' => $item->timesheet_id,
                'engagement_type' => $item->engagement_type->name,
                'notes' => $item->notes
            ];
        }); 
        return response()->json($mapped_ref_admissions_programs->paginate());
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

    public function update(
        Ref_Program $ref_program, 
        UpdateRequest $request,
        CancelRequestAction $cancelRequestAction
        )
    {
        $validated = $request->safe()->only(['cancellation_reason']);
        $updated_request = $cancelRequestAction->execute($ref_program, $validated['cancellation_reason']);
        return response()->json([
            'message' => 'Request has updated successfully.',
            'data' => $updated_request
        ]);
    }
}
