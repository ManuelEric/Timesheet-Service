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
        Log::info("Log Reminder of activity: {$reminder->activity_id} has been created.");
    }

    /**
     * Handle the Reminder "updated" event.
     */
    public function updated(Reminder $reminder): void
    {
        //
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
