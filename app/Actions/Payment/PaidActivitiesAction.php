<?php

namespace App\Actions\Payment;

use App\Http\Traits\PaymentDateConverter;
use App\Http\Traits\SelectFeeByActivity;
use App\Models\Activity;
use Illuminate\Support\Carbon;

class PaidActivitiesAction
{
    use SelectFeeByActivity;
    use PaymentDateConverter;
    
    public function execute(array $search = [])
    {   
        $unpaidActivities = Activity::paid()->onSearch($search)->get();
        $mappedActivities = $unpaidActivities->map(function ($data) {
            $activityId = $data->id;
            $timesheetId = $data->timesheet->id;
            $activity = $data->activity;
            $package = $data->timesheet->package;
            $mentorTutorName = $data->timesheet->subject->temp_user->full_name;
            $startDate = Carbon::parse($data->start_date);
            $endDate = $data->end_date ? Carbon::parse($data->end_date) : null;
            $timeSpent = $data->end_date ? in_array(strtolower($activity), ['additional fee', 'bonus fee']) ? 60 : $startDate->diffInMinutes($endDate) : 0;
            $feeHours = $this->selectFee($activity, $data);
            $cutoffStatus = $data->cutoff_status;
            $cutoffDate = Carbon::parse($data->cutoff_history->created_at)->format('d F Y H:i');
            $students = implode(", ", $data->timesheet->ref_program->pluck('student_name')->toArray());

            return [
                'id' => $activityId,
                'timesheet_id' => $timesheetId,
                'activity' => $activity,
                'package' => [
                    'name' => $package->package,
                    'type' => $package->type_of,
                    'category' => $package->category,
                ],
                'students' => $students,
                'mentor_tutor' => $mentorTutorName,
                'date' => $this->convert($startDate, $endDate),
                'time_spent' => $timeSpent,
                'fee_hours' => $feeHours,
                'cutoff_status' => $cutoffStatus,
                'cutoff_date' => $cutoffDate,
                'subtotal' => ($timeSpent / 60) * $feeHours,
            ];
        });

        return $mappedActivities;
    }
}
