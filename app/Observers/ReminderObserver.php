<?php

namespace App\Observers;

use App\Models\Reminder;
use Illuminate\Support\Facades\Log;

class ReminderObserver
{
    /**
     * Handle the Reminder "created" event.
     */
    public function created(Reminder $reminder): void
    {
        if ($reminder->type === "appointment")
            Log::notice("Log reminder of appointment (activity: {$reminder->activity_id}) has been created.");
        else
            Log::notice("Log reminder of quota-left (timesheet: {$reminder->timesheet_id}) has been created");
    }

    /**
     * Handle the Reminder "updated" event.
     */
    public function updated(Reminder $reminder): void
    {
        if ($reminder->type === "appointment")
            Log::notice("Log reminder of appointment (activitiy: {$reminder->activity_id}) has been updated.");
        else
            Log::notice("Log Reminder of quota-left (timesheet: {$reminder->activity_id}) has been updated.");
    }

    /**
     * Handle the Reminder "deleted" event.
     */
    public function deleted(Reminder $reminder): void
    {
        //
    }

    /**
     * Handle the Reminder "restored" event.
     */
    public function restored(Reminder $reminder): void
    {
        //
    }

    /**
     * Handle the Reminder "force deleted" event.
     */
    public function forceDeleted(Reminder $reminder): void
    {
        //
    }
}
