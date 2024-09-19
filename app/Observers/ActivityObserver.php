<?php

namespace App\Observers;

use App\Models\Activity;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ActivityObserver implements ShouldHandleEventsAfterCommit
{
    protected $userName;

    public function __construct()
    {
        $user = auth('sanctum')->user();
        $this->userName = $user->full_name;
    }

    /**
     * Handle the Activity "created" event.
     */
    public function created(Activity $activity): void
    {
        switch ($activity->activity) 
        {
            case "Additional Fee":
                Log::info('An additional fee has been added to the Timesheet ID: ' . $activity->timesheet_id);
                break;

            case "Bonus":
                Log::info('A bonus has been added to the Timesheet ID: ' . $activity->timesheet_id);
                break;

            default:
                Log::info('Activity of Timesheet ID: ' . $activity->timesheet_id . ' has been created.');
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
        if ( $activity->wasChanged('cutoff_ref_id') ) 
        {
            $newValue_of_cutoffStatus = $activity->cutoff_status;
            $newValue_of_cutoffrefId = $activity->cutoff_ref_id;

            # not yet meaning unpaid
            if ( $newValue_of_cutoffStatus == 'not yet' && $newValue_of_cutoffrefId == NULL ) #1
            {
                Log::info($this->userName . ' has unassigned the activity no. ' . $activityId );
                
            } 
            # completed meaning paid
            else if ( $newValue_of_cutoffStatus == 'completed' && $newValue_of_cutoffrefId != NULL ) #2
            {
                Log::info($this->userName . ' has stored into cut-off.');
            }
            return;
        }

        /**
         * Listening to 'updated end_date
         */
        if ( $activity->wasChanged('end_date') )
        {
            $endTime = $activity->end_date != NULL ? Carbon::parse($activity->end_date)->format('d M Y H:i') : 'NULL';
            Log::info($this->userName . ' has just updated the end date to ' . $endTime . ' of activity no. ' . $activityId);
        }

        /**
         * Listening to 'updated status'
         */
        if ( $activity->wasChanged('status') )
        {
            if ( $activity->status == 1 )
                Log::info($this->userName . ' has just completed the activity no. ' . $activityId);
            else
                Log::info($this->userName . ' has just undone the completed activity no. ' . $activityId);
        }

        Log::info($this->userName . ' has just update the activity.');

    }

    /**
     * Handle the Activity "deleted" event.
     */
    public function deleted(Activity $activity): void
    {
        $activityName = $activity->activity;
        Log::info($this->userName . ' just deleted the activity ' . $activityName);
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
