<?php

namespace App\Observers;

use App\Models\LogRef_Program;
use Illuminate\Support\Facades\Log;

class LogRef_ProgramObserver
{
    /**
     * Handle the LogRef_Program "created" event.
     */
    public function created(LogRef_Program $logRef_Program): void
    {
        Log::info('Timesheet ID. ' . $logRef_Program->timesheet_id . ' has been unassigned from Program ID : ' . $logRef_Program->program_id);
    }

    /**
     * Handle the LogRef_Program "updated" event.
     */
    public function updated(LogRef_Program $logRef_Program): void
    {
        //
    }

    /**
     * Handle the LogRef_Program "deleted" event.
     */
    public function deleted(LogRef_Program $logRef_Program): void
    {
        //
    }

    /**
     * Handle the LogRef_Program "restored" event.
     */
    public function restored(LogRef_Program $logRef_Program): void
    {
        //
    }

    /**
     * Handle the LogRef_Program "force deleted" event.
     */
    public function forceDeleted(LogRef_Program $logRef_Program): void
    {
        //
    }
}
