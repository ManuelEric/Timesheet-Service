<?php

namespace App\Observers;

use App\Models\Cutoff;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

class CutOffObserver implements ShouldHandleEventsAfterCommit
{
    protected $user_loggedIn;

    public function __construct()
    {
        $this->user_loggedIn = auth('sanctum')->user()->full_name;
    }

    /**
     * Handle the Cutoff "created" event.
     */
    public function created(Cutoff $cutoff): void
    {
        Log::info('Cut-off has been created by ' . $this->user_loggedIn);
    }

    /**
     * Handle the Cutoff "updated" event.
     */
    public function updated(Cutoff $cutoff): void
    {
        //
    }

    /**
     * Handle the Cutoff "deleted" event.
     */
    public function deleted(Cutoff $cutoff): void
    {
        //
    }

    /**
     * Handle the Cutoff "restored" event.
     */
    public function restored(Cutoff $cutoff): void
    {
        //
    }

    /**
     * Handle the Cutoff "force deleted" event.
     */
    public function forceDeleted(Cutoff $cutoff): void
    {
        //
    }
}
