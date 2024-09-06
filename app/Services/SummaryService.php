<?php

namespace App\Services;

use App\Http\Traits\MonthCollection;
use App\Models\Activity;
use App\Models\Ref_Program;
use App\Models\Timesheet;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class SummaryService
{
    use MonthCollection;

    public function summaryMonthlyPrograms(string $requestedMonthYear): int
    {
        [$year, $month] = $this->fetchMonthAndYear($requestedMonthYear);
        $programs = Ref_Program::onSession()->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
        return $programs;
    }

    public function summaryMonthlyTimesheets(string $requestedMonthYear): int
    {
        [$year, $month] = $this->fetchMonthAndYear($requestedMonthYear);
        $timesheet = Timesheet::onSession()->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
        return $timesheet;
    }

    public function summaryMonthlyActivities(string $requestedMonthYear): int
    {
        [$year, $month] = $this->fetchMonthAndYear($requestedMonthYear);
        $activity = Activity::onSession()->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
        return $activity;
    }

    public function summaryTotalSpentMonthlyActivities(string $requestedMonthYear): float
    {
        [$year, $month] = $this->fetchMonthAndYear($requestedMonthYear);
        $totalHours = Activity::onSession()->whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('time_spent');
        return $totalHours;
    }


    private function fetchMonthAndYear(string $requestedMonthYear)
    {
        $year = Carbon::parse($requestedMonthYear)->format('Y');
        $month = Carbon::parse($requestedMonthYear)->format('m');

        return [$year, $month];
    }
}
