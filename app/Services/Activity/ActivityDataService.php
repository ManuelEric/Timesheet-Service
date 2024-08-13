<?php

namespace App\Services\Activity;

use App\Http\Traits\TranslateActivityStatus;
use App\Models\Activity;
use App\Models\Cutoff;
use App\Models\Timesheet;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class ActivityDataService
{
    use TranslateActivityStatus;

    public function listActivitiesByTimesheet(Timesheet $timesheet)
    {
        /* fetch activities based on requested timesheet */
        $activities = $timesheet->activities;
        return $activities->map(function ($data) {

            $start_date = Carbon::parse($data->start_date);
            $end_date = $data->end_date ? Carbon::parse($data->end_date) : false;
            $start_time = $start_date->format('H:i');
            $end_time = $end_date ? $end_date->format('H:i') : 0;
            $estimate = $end_date ? $start_date->diffInMinutes($end_date) : 0;

            return $data->toArray() + [
                'start_time' => $start_time,
                'end_time' => $end_time,
                'estimate' => $estimate,
            ];
        });
    }

    public function listTimesheetByCutoffDate(string $start_date, string $end_date)
    {
        /* we're gonna find timesheets using cutoff `from` and `to` */
        $timesheets = Timesheet::with('activities')->whereHas('activities.cutoff_history', function ($query) use ($start_date, $end_date) {
            $query->inBetween($start_date, $end_date);
        })->get();

        
    }
}
