<?php

namespace App\Actions\Payment;

use App\Actions\Activity\CreateActivityAction;
use App\Enum\PaymentType;
use App\Http\Traits\HiddenCostStatus;
use App\Models\Timesheet;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class HiddenCostAction
{
    use HiddenCostStatus;

    protected $createActivityAction;

    public function __construct(CreateActivityAction $createActivityAction)
    {
        $this->createActivityAction = $createActivityAction;
    }

    public function execute(string $type, int $timesheetId, string $date, float $amount)
    {
        if ( !PaymentType::isValid($type) )
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Invalid payment type'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        [$activityName, $activityDescription, $columnForFee] = $this->getHiddenCostDescription($type);
        /* get all of the activities that selected package id have been bounded with the timesheet */
        $details = [
            'activity' => $activityName,
            'description' => $activityDescription,
            'start_date' => $date,
            'end_date' => $date,
            'meeting_link' => NULL,
            $columnForFee => $amount,
        ];
        $timesheet = Timesheet::find($timesheetId);
        $this->createActivityAction->execute($timesheet, $details);
    }
}
