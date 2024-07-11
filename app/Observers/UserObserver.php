<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Log;

class UserObserver implements ShouldHandleEventsAfterCommit
{
    /** 
     * Handle the User "authenticate" event.
     */
    public function authenticated(User $user): void
    {
        Log::info($user->full_name . ' has been login.');
    }

    /**
     * Handle the User "logged out" event.
     */
    public function logged_out(User $user): void
    {
        Log::info($user->full_name . ' has been logged out.');
        
        /* save the last activity */
        $user->last_activity = now();
        $user->save();
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Log::info($user->full_name . ' has been created.');
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
