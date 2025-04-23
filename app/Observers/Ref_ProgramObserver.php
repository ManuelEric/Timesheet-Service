<?php

namespace App\Observers;

use App\Models\Ref_Program;
use App\Services\Mentoring\MentoringServices;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

class Ref_ProgramObserver implements ShouldHandleEventsAfterCommit
{

    protected $mentoring_services;

    public function __construct(MentoringServices $mentoring_services)
    {
        $this->mentoring_services = $mentoring_services;
    }
    /**
     * Handle the Ref_Program "created" event.
     */
    public function created(Ref_Program $ref_Program): void
    {
        // if ( $ref_Program->require == "Mentor" )
        // {
        //     $mentee_id = $ref_Program->student_uuid;
        //     $phase_detail_id = $ref_Program->engagement_type_id; //! the primary of engagement type should be the same as primary of phase_detail_id
        //     $this->mentoring_services->storeMentoringLog($ref_Program->id, $mentee_id, $phase_detail_id);
        // }

        Log::info('Invoice ID : ' . $ref_Program->invoice_id . ' has been stored.');
    }

    /**
     * Handle the Ref_Program "updated" event.
     */
    public function updated(Ref_Program $ref_Program): void
    {
        // if ( $ref_Program->require == "Mentor" && $ref_Program->mentoring_log_id && $ref_Program->cancelled_at !== NULL && $ref_Program->cancellation_reason !== NULL )
        //     $this->mentoring_services->deleteMentoringLog($ref_Program->id);
        

        Log::info('Invoice ID : ' . $ref_Program->invoice_id . ' has been updated.');

        if ( $ref_Program->wasChanged('timesheet_id') )
            Log::info('Timesheet for Invoice ID : ' . $ref_Program->invoice_id . ' has been created.');
    }

    /**
     * Handle the Ref_Program "deleted" event.
     */
    public function deleted(Ref_Program $ref_Program): void
    {
        Log::info('Invoice ID : ' . $ref_Program->invoice_id . ' has been removed.');
    }

    /**
     * Handle the Ref_Program "restored" event.
     */
    public function restored(Ref_Program $ref_Program): void
    {
        //
    }

    /**
     * Handle the Ref_Program "force deleted" event.
     */
    public function forceDeleted(Ref_Program $ref_Program): void
    {
        //
    }
}
