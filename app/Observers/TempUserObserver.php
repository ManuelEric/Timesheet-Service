<?php

namespace App\Observers;

use App\Models\TempUser;
use Illuminate\Support\Facades\Log;

class TempUserObserver
{
    /** 
     * Handle the User "authenticate" event.
     */
    public function authenticated(TempUser $tempUser): void
    {
        Log::info($tempUser->full_name . ' has been login.');
    }

    /**
     * Handle the User "logged out" event.
     */
    public function logged_out(TempUser $tempUser): void
    {
        Log::info($tempUser->full_name . ' has been logged out.');
        
        /* save the last activity */
        $tempUser->last_activity = now();
        $tempUser->save();
    }

    /**
     * Handle the TempUser "created" event.
     */
    public function created(TempUser $tempUser): void
    {
        //
    }

    /**
     * Handle the TempUser "updated" event.
     */
    public function updated(TempUser $tempUser): void
    {
        //
    }

    /**
     * Handle the TempUser "deleted" event.
     */
    public function deleted(TempUser $tempUser): void
    {
        //
    }

    /**
     * Handle the TempUser "restored" event.
     */
    public function restored(TempUser $tempUser): void
    {
        //
    }

    /**
     * Handle the TempUser "force deleted" event.
     */
    public function forceDeleted(TempUser $tempUser): void
    {
        //
    }
}
