<?php

namespace App\Observers;

use App\Models\Timesheet;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

class TimesheetObserver implements ShouldHandleEventsAfterCommit
{
    protected $user_loggedIn;

    public function __construct()
    {
        $this->user_loggedIn = auth('sanctum')->user()->full_name;
    }

    /**
     * Handle the Timesheet "created" event.
     */
    public function created(Timesheet $timesheet): void
    {
        Log::info('Timesheet has been created by ' . $this->user_loggedIn);
    }

    /**
     * Handle the Timesheet "updated" event.
     */
    public function updated(Timesheet $timesheet): void
    {
        Log::info('Timesheet has been updated by ' . $this->user_loggedIn);
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
