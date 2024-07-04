<?php

namespace App\Actions\Activity;

use App\Models\Activity;
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

    public function execute(int $timesheetId, array $validated, array $userInformation, string $role)
    {
        $detailsFee = $userInformation['roles']->where('role_name', $role)->first();
        $fee_perHours = $detailsFee['pivot']['feehours'];

        DB::beginTransaction();
        try {

            $activityDetails = [
                'timesheet_id' => $timesheetId,
                'activity' => $validated['activity'],
                'description' => $validated['description'],
                'start_date' => $validated['start_date'],
                'end_date' => NULL,
                'fee_hours' => $fee_perHours,
                'additional_fee' => 0,
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
