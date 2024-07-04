<?php

namespace App\Observers;

use App\Models\Pivot\HandleBy;

class HandleByObserver
{
    /**
     * Handle the HandleBy "created" event.
     */
    public function created(HandleBy $handleBy): void
    {
        $newlyStoredId = $handleBy->id;
        $tempUserId = $handleBy->temp_user_id;
        $timesheetId = $handleBy->timesheet_id;
        HandleBy::where('timesheet_id', $timesheetId)->whereNot('temp_user_id', $tempUserId)->update(['active' => false]);
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
