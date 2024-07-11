<?php

namespace App\Actions\Timesheet;

use App\Models\Timesheet;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UpdateTimesheetAction
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }
    
    public function execute(
        Timesheet $existingTimesheet, 
        array $storePackageDetails, 
        ?string $notes, 
        string $inhouseId, 
        array $picIds, 
        string $mentortutorId, 
        int $subjectId)
    {
        /* define submitted package variables */
        $packageId = $storePackageDetails['validatedPackageId'];
        $duration = $storePackageDetails['validatedDuration'];

        /* merge variables into array that going to be stored into timesheet */
        $timesheetNewDetails = [
            'inhouse_id' => $inhouseId,
            'package_id' => $packageId,
            'duration' => $duration,
            'notes' => $notes,
            'subject_id' => $subjectId,
        ];
        
        DB::beginTransaction();
        try {

            $existingTimesheet->update($timesheetNewDetails);
            $existingTimesheet->handle_by()->attach($mentortutorId, ['active' => true]);
            $existingTimesheet->admin()->sync($picIds);

            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();
            $errorMessage = "There was an error while updating a timesheet.";
            $this->responseService->storeErrorLog($errorMessage, $e->getMessage(), ['file' => $e->getFile(), 'error_line' => $e->getLine()]);
            throw new HttpResponseException(
                response()->json([
                    'errors' => $errorMessage
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }
    }
} 
