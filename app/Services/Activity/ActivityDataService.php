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
            $is_disabled = $data->cutoff_history ? true : false;

            return [
                'id' => $data->id,
                'timesheet_id' => $data->timesheet_id,
                'activity' => $data->activity,
                'description' => $data->description,
                'start_date' => $data->start_date,
                'end_date' => $data->end_date,
                'fee_hours' => $data->fee_hours,
                'additional_fee' => $data->additional_fee,
                'bonus_fee' => $data->bonus_fee,
                'time_spent' => $data->time_spent,
                'meeting_link' => $data->meeting_link,
                'status' => $data->status,
                'cutoff_status' => $data->cutoff_status,
                'cutoff_ref_id' => $data->cutoff_ref_id,
                'date' => $start_date->format('Y-m-d'),
                'start_time' => $start_time,
                'end_time' => $end_time,
                'estimate' => $estimate,
                'disabled_changes' => $is_disabled
            ];
        });
    }
}
