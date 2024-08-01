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

    public function listActivities(Timesheet $timesheet, ?string $date = '')
    {
        /* fetch the entire activities */
        $activities = $timesheet->activities;

        
        /* when the argument date is filled */
        if ( $date )
        {
            $cutoff = Cutoff::withinTheCutoffDateRange($date)->first();
            $cutoffId = $cutoff->id;

            $activities = $activities->where('cutoff_ref_id', $cutoffId);
        }


        $mappedActivities = $activities->map(function ($data) {

            $start_date = Carbon::parse($data->start_date);
            $end_date = $data->end_date ? Carbon::parse($data->end_date) : false;
            $start_time = $start_date->format('H:i');
            $end_time = $end_date ? $end_date->format('H:i') : 0;
            $estimate = $end_date ? $start_date->diffInMinutes($end_date) : 0;
            $status = $data->status ? true : false;

            return $data->toArray() + [
                'start_time' => $start_time,
                'end_time' => $end_time,
                'estimate' => $estimate,
                'status' => $status,
            ];
        });

        return $mappedActivities;
    }
}
