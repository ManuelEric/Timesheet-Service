<?php

namespace App\Observers;

use App\Models\Timesheet;
use Illuminate\Support\Facades\Log;

class TimesheetObserver
{
    /**
     * Handle the Timesheet "created" event.
     */
    public function created(Timesheet $timesheet): void
    {
        $user_loggedIn = auth('sanctum')->user()->full_name;
        Log::info('Timesheet has been created by ' . $user_loggedIn);
    }

    /**
     * Handle the Timesheet "updated" event.
     */
    public function updated(Timesheet $timesheet): void
    {
        //
    }

    /**
     * Handle the Timesheet "deleted" event.
     */
    public function deleted(Timesheet $timesheet): void
    {
        //
    }

    /**
     * Handle the Timesheet "restored" event.
     */
    public function restored(Timesheet $timesheet): void
    {
        //
    }

    /**
     * Handle the Timesheet "force deleted" event.
     */
    public function forceDeleted(Timesheet $timesheet): void
    {
        //
    }
}
