<?php

namespace App\Observers;

use App\Models\Activity;
use App\Services\Mentoring\MentoringServices;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ActivityObserver implements ShouldHandleEventsAfterCommit
{
    protected $userName;
    protected $mentoring_services;

    public function __construct(MentoringServices $mentoring_services)
    {
        $user = auth('sanctum')->user();
        $this->userName = $user->full_name;
        $this->mentoring_services = $mentoring_services;
    }

    /**
     * Handle the Activity "created" event.
     */
    public function created(Activity $activity): void
    {
        switch ($activity->activity) {
            case "Additional Fee":
                Log::notice('An additional fee has been added to the Timesheet ID: ' . $activity->timesheet_id);
                break;

            case "Bonus":
                Log::notice('A bonus has been added to the Timesheet ID: ' . $activity->timesheet_id);
                break;

            default:
                Log::notice('Activity of Timesheet ID: ' . $activity->timesheet_id . ' has been created.');
        }

        /**
         * check if the activity is from ref_program which has a engagement_type_id
         */
        if ($ref_Program = $activity->timesheet->ref_program->whereNotNull('engagement_type_id')->whereNull('cancelled_at')->where('require', 'Mentor')->first()) {
            $mentee_id = $ref_Program->student_uuid;
            $phase_detail_id = $ref_Program->engagement_type_id; //! the primary of engagement type should be the same as primary of phase_detail_id
            $mentor_id = $activity->timesheet->subject->temp_user->uuid;
            $activity_description = $activity->description;
            $meeting_link = $activity->meeting_link;
            $this->mentoring_services->storeMentoringLog($ref_Program->id, $mentee_id, $phase_detail_id, $mentor_id, $activity_description, $meeting_link, $activity->toArray());
        }
    }

    /**
     * Handle the Activity "updated" event.
     */
    public function updated(Activity $activity): void
    {
        $activityId = $activity->id;

        /**
         * Listening to 'updated cutoff_ref_id'
         */
        if ($activity->wasChanged('cutoff_ref_id')) {
            $newValue_of_cutoffStatus = $activity->cutoff_status;
            $newValue_of_cutoffrefId = $activity->cutoff_ref_id;

            # not yet meaning unpaid
            if ($newValue_of_cutoffStatus == 'not yet' && $newValue_of_cutoffrefId == NULL) #1
            {
                Log::notice($this->userName . ' has unassigned the activity no. ' . $activityId);
            }
            # completed meaning paid
            else if ($newValue_of_cutoffStatus == 'completed' && $newValue_of_cutoffrefId != NULL) #2
            {
                Log::notice($this->userName . ' has stored into cut-off.');
            }
            return;
        }

        /**
         * Listening to 'updated end_date
         */
        if ($activity->wasChanged('end_date')) {
            $endTime = $activity->end_date != NULL ? Carbon::parse($activity->end_date)->format('d M Y H:i') : 'NULL';
            Log::notice($this->userName . ' has just updated the end date to ' . $endTime . ' of activity no. ' . $activityId);
            return;
        }

        /**
         * Listening to 'updated status'
         */
        if ($activity->wasChanged('status')) {
            if ($activity->status == 1)
                Log::notice($this->userName . ' has just completed the activity no. ' . $activityId);
            else
                Log::notice($this->userName . ' has just undone the completed activity no. ' . $activityId);
            return;
        }

        Log::notice($this->userName . ' has just update the activity.');
    }

    /**
     * Handle the Activity "deleted" event.
     */
    public function deleted(Activity $activity): void
    {

        /**
         * check if the activity is from ref_program which has a engagement_type_id
         */
        if ($ref_Program = $activity->timesheet->ref_program->whereNotNull('engagement_type_id')->whereNull('cancelled_at')->where('require', 'Mentor')->first())
            $this->mentoring_services->deleteMentoringLog($ref_Program->id);


        $activityName = $activity->activity;
        Log::notice($this->userName . ' just deleted the activity ' . $activityName);
    }

    /**
     * Handle the Activity "restored" event.
     */
    public function restored(Activity $activity): void
    {
        //
    }

    /**
     * Handle the Activity "force deleted" event.
     */
    public function forceDeleted(Activity $activity): void
    {
        //
    }
}
