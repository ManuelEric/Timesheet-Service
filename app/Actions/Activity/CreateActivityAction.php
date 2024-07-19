<?php

namespace App\Actions\Activity;

use App\Models\Activity;
use App\Models\Timesheet;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateActivityAction
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function execute(Timesheet $timesheet, array $validated)
    {
        $timesheetId = $timesheet->id;

        /* default variables */
        $fee_perHours = $timesheet->subject->fee_hours;
        $endDate = NULL;
        $additionalFee = $bonusFee = 0;

        /* when the request comes from fee controller */
        if ( array_key_exists('additional_fee', $validated) ) 
        {
            $fee_perHours = 0;
            $endDate = $validated['end_date'];
            $additionalFee = $validated['additional_fee'];
        } 

        /* when the request comes from bonus controller */
        if ( array_key_exists('bonus_fee', $validated) ) 
        {
            $fee_perHours = 0;
            $endDate = $validated['end_date'];
            $bonusFee = $validated['bonus_fee'];
        } 

        DB::beginTransaction();
        try {

            $activityDetails = [
                'timesheet_id' => $timesheetId,
                'activity' => $validated['activity'],
                'description' => $validated['description'],
                'start_date' => $validated['start_date'],
                'end_date' => $endDate,
                'fee_hours' => $fee_perHours,
                'additional_fee' => $additionalFee,
                'bonus_fee' => $bonusFee,
                'time_spent' => 0,
                'meeting_link' => $validated['meeting_link'],
                'status' => 0
            ];
    
            Activity::create($activityDetails);
            DB::commit();
            
        } catch (Exception $err) {
            
            DB::rollBack();
            $errors = 'Failed to create new activity.';
            $this->responseService->storeErrorLog($errors, $err->getMessage(), [
                'file' => $err->getFile(),
                'error_line' => $err->getLine(),
                'value' => $activityDetails
            ]);

            throw new HttpResponseException(
                response()->json([
                    'errors' => $errors
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
            
        }
    }
}
