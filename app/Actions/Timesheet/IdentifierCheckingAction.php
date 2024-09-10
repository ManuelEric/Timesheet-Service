<?php

namespace App\Actions\Timesheet;

use App\Models\Timesheet;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class IdentifierCheckingAction
{
    public function execute(int $timesheetId)
    {
        $timesheet = Timesheet::with(
            [
                'ref_program', 
                'package', 
                'admin', 
                'handle_by' => function ($query) {
                    $query->wherePivot('active', 1);
                }
            ]
        )->find($timesheetId);
        
        if ( !$timesheet ) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Invalid code provided.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }

        return $timesheet;
    }
}
