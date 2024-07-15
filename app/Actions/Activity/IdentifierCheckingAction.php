<?php

namespace App\Actions\Activity;

use App\Models\Activity;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class IdentifierCheckingAction
{
    public function execute(int $activityId, int $timesheetId)
    {
        $activity = Activity::find($activityId)->makeHidden(['cutoff_ref_id']);
        if ( !$activity || $activity->timesheet_id != $timesheetId)
        {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Invalid code provided.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        return $activity;
    }
}
