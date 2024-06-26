<?php

namespace App\Observers;

use App\Models\Ref_ClientProgram;
use Illuminate\Support\Facades\Log;

class Ref_ClientProgramObserver
{
    /**
     * Handle the Ref_ClientProgram "created" event.
     */
    public function created(Ref_ClientProgram $ref_ClientProgram): void
    {
        Log::info('Invoice ID : ' . $ref_ClientProgram->invoice_id . ' has been stored.');
    }

    /**
     * Handle the Ref_ClientProgram "updated" event.
     */
    public function updated(Ref_ClientProgram $ref_ClientProgram): void
    {
        //
    }

    /**
     * Handle the Ref_ClientProgram "deleted" event.
     */
    public function deleted(Ref_ClientProgram $ref_ClientProgram): void
    {
        //
    }

    /**
     * Handle the Ref_ClientProgram "restored" event.
     */
    public function restored(Ref_ClientProgram $ref_ClientProgram): void
    {
        //
    }

    /**
     * Handle the Ref_ClientProgram "force deleted" event.
     */
    public function forceDeleted(Ref_ClientProgram $ref_ClientProgram): void
    {
        //
    }
}
