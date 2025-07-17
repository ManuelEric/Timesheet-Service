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
        
        return $activities->sortBy('asc')->map(function ($data) {

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
                'tax' => $data->tax,
                'fee_hours' => $data->fee_hours,
                'additional_fee' => $data->additional_fee,
                'bonus_fee' => $data->bonus_fee,
                'time_spent' => $data->time_spent,
                'meeting_link' => $data->meeting_link,
                'status' => $data->status == 1 ? true : false,
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

    public function summarizeActivity(Cutoff $cutoff)
    {
        return Activity::query()->
            join('timesheets', 'timesheets.id', '=', 'timesheet_activities.timesheet_id')->
            join('timesheet_packages', 'timesheet_packages.id', '=', 'timesheets.package_id')->
            join('temp_user_roles', 'temp_user_roles.id', '=', 'timesheets.subject_id')->
            join('temp_users', 'temp_users.id', '=', 'temp_user_roles.temp_user_id')->
            where('cutoff_ref_id', $cutoff->id)->
            selectRaw('
                GROUP_CONCAT(DISTINCT 
                        (CASE
                            WHEN timesheet_packages.type_of = "ALL" THEN "Tutoring"
                            ELSE timesheet_packages.type_of 
                        END) 
                    ORDER BY timesheet_packages.type_of ASC SEPARATOR ", ") 
                AS package_name,
                temp_users.full_name,
                temp_users.account_name,
                temp_users.account_no,
                temp_users.bank_name,
                temp_users.swift_code, 
                SUM( (timesheet_activities.time_spent/60) * timesheet_activities.fee_hours ) as subtotal_fee_gross,
                SUM( (timesheet_activities.time_spent/60) * timesheet_activities.fee_hours ) * 0.025 as tax,
                SUM( (timesheet_activities.time_spent/60) * timesheet_activities.fee_hours ) - SUM( (timesheet_activities.time_spent/60) * timesheet_activities.fee_hours ) * 0.025 as subtotal_fee_nett,
                ROUND(SUM( (timesheet_activities.time_spent/60) * timesheet_activities.fee_hours ) - SUM( (timesheet_activities.time_spent/60) * timesheet_activities.fee_hours ) * 0.025, -1) as rounding,
                SUM(timesheet_activities.additional_fee + timesheet_activities.bonus_fee) as subtotal_additional_or_bonus_fee
            ')->
            groupBy('temp_users.id')->
            get();
    }
}
