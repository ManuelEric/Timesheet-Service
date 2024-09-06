<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Programs\ComponentController as V1ProgramsComponentController;
use App\Http\Controllers\Controller;
use App\Http\Traits\MonthCollection;
use App\Models\Timesheet;
use App\Services\SummaryService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class DashboardBaseController extends Controller
{
    use MonthCollection;

    public function index(
        string $requestedMonthYear, # going to be like '2024-09'
        SummaryService $summaryService
        )
    {
        
        $summary_of = [
            'program' => $summaryService->summaryMonthlyPrograms($requestedMonthYear),
            'timesheet' => $summaryService->summaryMonthlyTimesheets($requestedMonthYear),
            'activity' => $summaryService->summaryMonthlyActivities($requestedMonthYear),
        ];

        /* additional information only for non-admin */
        if ( !auth('sanctum')->user()->is_admin )
        {
            $additional = [ 'total_hours' => $summaryService->summaryTotalSpentMonthlyActivities($requestedMonthYear) ];
            $summary_of = array_merge($summary_of, $additional);
        }
        
        return response()->json($summary_of, JsonResponse::HTTP_OK);
    }
}
