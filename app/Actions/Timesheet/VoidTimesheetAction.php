<?php

namespace App\Actions\Timesheet;

use App\Models\LogRef_Program;
use App\Models\Timesheet;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class VoidTimesheetAction
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }
    
    public function execute(Timesheet $timesheet)
    {
        DB::beginTransaction();
        try {
            # change the current timesheet to void
            $timesheet->void = true;
            $timesheet->save();
    
    
            # ref_programs is some programs that holds the timesheet information
            $ref_programs = $timesheet->ref_program;
            foreach ($ref_programs as $ref_program)
            {
                LogRef_Program::create([
                    'ref_program_id' => $ref_program->id,
                    'timesheet_id' => $timesheet->id,
                ]);
            }
    
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $errorMessage = "There was an error while unassigned the timesheet from ref programs.";
            $this->responseService->storeErrorLog($errorMessage, $e->getMessage(), ['file' => $e->getFile(), 'error_line' => $e->getLine()]);
            return response()->json([
                'errors' => $errorMessage
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
