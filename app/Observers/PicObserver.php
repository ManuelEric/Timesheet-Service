<?php

namespace App\Observers;

use App\Models\Pivot\Pic;
use App\Models\User;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

class PicObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Pic "created" event.
     */
    public function created(Pic $pic): void
    {
        $timesheetId = $pic->timesheet_id;
        $userId = $pic->user_id;
        $user = User::find($userId);
        $userName = $user->full_name;
        Log::notice("{$userName} has been registered to be PIC for Timesheet No. {$timesheetId}");
    }

    /**
     * Handle the Pic "updated" event.
     */
    public function updated(Pic $pic): void
    {
        //
    }

    /**
     * Handle the Pic "deleted" event.
     */
    public function deleted(Pic $pic): void
    {
        $timesheetId = $pic->timesheet_id;
        $userId = $pic->user_id;
        $user = User::find($userId);
        $userName = $user->full_name;
        Log::notice("{$userName} has been archived from PIC-ing Timesheet No. {$timesheetId}");
    }

    /**
     * Handle the Pic "restored" event.
     */
    public function restored(Pic $pic): void
    {
        //
    }

    /**
     * Handle the Pic "force deleted" event.
     */
    public function forceDeleted(Pic $pic): void
    {
        //
    }
}
