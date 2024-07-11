<?php

namespace App\Observers;

use App\Models\Pivot\HandleBy;
use App\Models\TempUser;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

class HandleByObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the HandleBy "creating" event.
     */
    public function creating(HandleBy $handleBy): void
    {
        $timesheetId = $handleBy->timesheet_id;
        /* trigger update specifically to update previous mentor/tutor into false status  */
        $replacedMentorTutors = HandleBy::where('timesheet_id', $timesheetId)->get();
        $mts = array();
        foreach ($replacedMentorTutors as $mt)
        {
            $mt->active = false;
            $mt->save();

            $mentorTutorId = $mt->temp_user_id;
            $mentorTutor = TempUser::find($mentorTutorId);
            $mentorTutor_name = $mentorTutor->full_name;
            if ( !in_array($mentorTutor_name, $mts) && $handleBy->temp_user_id !== $mentorTutorId )
                array_push($mts, $mentorTutor_name);
            
        }

        $print_replacedMTs = implode(', ', $mts);
        Log::info("Mentor / Tutor ({$print_replacedMTs}) has been archived from Handling Timesheet No. {$timesheetId}");
    }

    /**
     * Handle the HandleBy "created" event.
     */
    public function created(HandleBy $handleBy): void
    {
        $mentorTutorId = $handleBy->temp_user_id;
        $mentorTutor = TempUser::find($mentorTutorId);
        $mentorTutor_name = $mentorTutor->full_name;
        $timesheetId = $handleBy->timesheet_id;
        Log::info('Timesheet No. ' . $timesheetId . ' has been attached to ' . $mentorTutor_name);
    }

    /**
     * Handle the HandleBy "updated" event.
     */
    public function updated(HandleBy $handleBy): void
    {
        //
    }

    /**
     * Handle the HandleBy "deleted" event.
     */
    public function deleted(HandleBy $handleBy): void
    {
        //
    }

    /**
     * Handle the HandleBy "restored" event.
     */
    public function restored(HandleBy $handleBy): void
    {
        //
    }

    /**
     * Handle the HandleBy "force deleted" event.
     */
    public function forceDeleted(HandleBy $handleBy): void
    {
        //
    }
}
