<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Pivot\HandleBy;
use App\Models\Pivot\Pic;
use App\Models\Ref_Program;
use App\Models\Timesheet;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

class TimesheetObserver
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
     * Handle the Timesheet "deleting" event.
     */
    public function deleting(Timesheet $timesheet): void
    {
        $timesheetId = $timesheet->id;

        /* detach related timesheet from ref_programs */
        Ref_Program::where('timesheet_id', $timesheetId)->update(['timesheet_id' => NULL]);

        /* delete the timesheet handling records by mentor/tutor */ 
        HandleBy::where('timesheet_id', $timesheetId)->delete();

        /* delete the timesheet pic-ing records by admin */ 
        Pic::where('timesheet_id', $timesheetId)->delete();

        /* delete related activities */
        $timesheet->activities()->delete();
    }

    /**
     * Handle the Timesheet "deleted" event.
     */
    public function deleted(Timesheet $timesheet): void
    {
        Log::info("Timesheet has been deleted by {$this->user_loggedIn}", $timesheet->toArray());
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
