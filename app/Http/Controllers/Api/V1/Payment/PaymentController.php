<?php

namespace App\Http\Controllers\Api\V1\Payment;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaymentDateConverter;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    use PaymentDateConverter;

    public function index(Request $request)
    {
        $paymentStatus = $request->segment(4); # either unpaid / paid

        /* incoming request */
        $search = $request->only(['program_name', 'package_id', 'keyword']);
        $unpaidActivities = Activity::unpaid()->onSearch($search)->get();
        $mappedActivities = $unpaidActivities->map(function ($data) {
            $activityId = $data->id;
            $timesheetId = $data->timesheet->id;
            $activity = $data->activity;
            $mentorTutorName = $data->timesheet->subject->full_name;
            $startDate = Carbon::parse($data->start_date);
            $endDate = $data->end_date ? Carbon::parse($data->end_date) : null;
            $timeSpent = $data->end_date ? $startDate->diffInMinutes($endDate) : 0;
            $feeHours = $data->fee_hours;
            $cutoffStatus = $data->cutoff_status;

            return [
                'id' => $activityId,
                'timesheet_id' => $timesheetId,
                'activity' => $activity,
                'mentor_tutor' => $mentorTutorName,
                'date' => $this->convert($startDate, $endDate),
                'time_spent' => $timeSpent,
                'fee_hours' => $feeHours,
                'cutoff_status' => $cutoffStatus
            ];
        });

        $mappedActivities = $mappedActivities->paginate(10);

        return response()->json($mappedActivities);
    }
}
