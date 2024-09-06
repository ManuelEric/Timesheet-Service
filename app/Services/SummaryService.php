<?php

namespace App\Services;

use App\Http\Traits\MonthCollection;
use App\Models\Activity;
use App\Models\Ref_Program;
use App\Models\Timesheet;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class SummaryService
{
    use MonthCollection;

    public function summaryMonthlyPrograms(string $month): int
    {
        /* validate */
        $this->validateMonth($month);

        $index = array_search($month, $this->month()) + 1;
        $programs = Ref_Program::onSession()->whereMonth('created_at', $index)->count();
        return $programs;
    }

    public function summaryMonthlyTimesheets(string $month): int
    {
        /* validate */
        $this->validateMonth($month);
        
        $index = array_search($month, $this->month()) + 1;
        $timesheet = Timesheet::onSession()->whereMonth('created_at', $index)->count();
        return $timesheet;
    }

    public function summaryMonthlyActivities(string $month): int
    {
        /* validate */
        $this->validateMonth($month);

        $index = array_search($month, $this->month()) + 1;
        $activity = Activity::onSession()->whereMonth('created_at', $index)->count();
        return $activity;
    }

    public function summaryTotalSpentMonthlyActivities(string $month): float
    {
        /* validate */
        $this->validateMonth($month);

        $index = array_search($month, $this->month()) + 1;
        $totalHours = Activity::onSession()->whereMonth('created_at', $index)->sum('time_spent');
        return $totalHours;
    }


    private function validateMonth(string $month)
    {
        if ( !in_array(strtolower($month), $this->month()) )
        {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Invalid month provided.'
                ], JsonResponse::HTTP_BAD_REQUEST)
            );
        }
    }
}
