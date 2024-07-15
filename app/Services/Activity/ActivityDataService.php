<?php

namespace App\Services\Activity;

use App\Http\Traits\TranslateActivityStatus;
use App\Models\Timesheet;
use Illuminate\Support\Carbon;

class ActivityDataService
{
    use TranslateActivityStatus;

    public function listActivities(Timesheet $timesheet)
    {
        /* fetch the entire activities */
        $activities = $timesheet->activities;
        $mappedActivities = $activities->map(function ($data) {

            $activity = $data->activity;
            $description = $data->description;
            $start_date = Carbon::parse($data->start_date);
            $end_date = $data->end_date ? Carbon::parse($data->end_date) : false;
            $date = $start_date->format('d F Y');
            $start_time = $start_date->format('H:i');
            $end_time = $end_date ? $end_date->format('H:i') : 0;
            $estimate = $end_date ? $start_date->diffInMinutes($end_date) : 0;
            $status = $this->translate($data->status);

            return [
                'id' => $data->id,
                'activity' => $activity,
                'description' => $description,
                'date' => $date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'estimate' => $estimate,
                'status' => $status,
            ];
        });

        return $mappedActivities;
    }
}
