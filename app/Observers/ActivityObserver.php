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
        /**
         * Listening to 'updated cutoff_ref_id'
         */
        if ( $activity->wasChanged('cutoff_ref_id') ) 
        {
            $newValue_of_cutoffStatus = $activity->cutoff_status;
            $newValue_of_cutoffrefId = $activity->cutoff_ref_id;

            if ( $newValue_of_cutoffStatus == 'unpaid' && $newValue_of_cutoffrefId == NULL ) #1
            {
                $activityId = $activity->id;
                Log::info($this->userName . ' has unassigned the activity no. ' . $activityId );
                
            } 
            else if ( $newValue_of_cutoffStatus == 'paid' && $newValue_of_cutoffrefId != NULL ) #2
            {
                Log::info($this->userName . ' has stored into cut-off.');
            }
            return;
        }

        $activityName = $activity->activity;
        $endTime = Carbon::parse($activity->end_date)->format('d M Y H:i');
        Log::info($this->userName . ' just completed the activity *' . $activityName . '* at ' . $endTime);
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
