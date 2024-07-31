<?php

namespace App\Http\Traits;

use Illuminate\Support\Carbon;

trait EmailReminderVariables
{
    public function createVariablesUsingActivity($activity): array
    {
        $activityId = $activity->id;
        $timesheet = $activity->timesheet;

        $detail = $this->timesheetDataService->detailTimesheet($timesheet);

        /* extract the details */
        $clients = $detail['clientProfile'];
        $packageDetails = $detail['packageDetails'];
        $packageDetails['category'] = $timesheet->package->category;
        $editableColumns = $detail['editableColumns'];
        $tutormentor_email = $editableColumns['tutormentor_email'];
        $additionalInfo = [
            'clients' => $detail['clientProfile'],
            'timesheet' => $timesheet,
            'package' => $packageDetails,
        ];

        /* extract the activity */
        $activityId = $activity->id;
        $activityStartDate = Carbon::parse($activity->start_date);
        $activityEndDate = Carbon::parse($activity->end_date);
        $meetingLink = $activity->meeting_link;
        $activityDetails = [
            'id' => $activityId,
            'date' => $activityStartDate->format('d F Y'),
            'start_time' => $activityStartDate->format('H:i'),
            'end_time' => $activityEndDate->format('H:i'),
            'link' => $meetingLink
        ];

        return [
            $tutormentor_email,
            compact('additionalInfo', 'activityDetails')
        ];   
    }

    public function createVariablesUsingTimesheet($timesheet): array
    {
        $detail = $this->timesheetDataService->detailTimesheet($timesheet);

        /* extract the details */
        $clients = $detail['clientProfile'];
        $packageDetails = $detail['packageDetails'];
        $packageDetails['category'] = $timesheet->package->category;
        $editableColumns = $detail['editableColumns'];
        $tutormentor_email = $editableColumns['tutormentor_email'];
        $additionalInfo = [
            'clients' => $detail['clientProfile'],
            'timesheet' => $timesheet,
            'package' => $packageDetails,
        ];

        return [
            $tutormentor_email,
            $additionalInfo
        ];   
    }
}
