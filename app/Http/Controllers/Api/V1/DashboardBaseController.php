<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Programs\ComponentController as V1ProgramsComponentController;
use App\Http\Controllers\Controller;
use App\Http\Traits\MonthCollection;
use App\Services\SummaryService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class DashboardBaseController extends Controller
{
    use MonthCollection;

    public function index(
        string $month,
        SummaryService $summaryService
        )
    {
        
        $summary_of = [
            'program' => $summaryService->summaryMonthlyPrograms($month),
            'timesheet' => $summaryService->summaryMonthlyTimesheets($month),
            'activity' => $summaryService->summaryMonthlyActivities($month)
        ];
        
        return response()->json($summary_of, JsonResponse::HTTP_OK);
    }
}
