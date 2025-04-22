<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        
        /* prune your application's expired tokens */
        $schedule->command('sanctum:prune-expired --hours=24')->daily();

        /* delete all the reset password token */
        $schedule->command('auth:clear-resets')->everyFifteenMinutes();

        /* synchronize academic program from CRMs */
        $schedule->command('sync:academic-program')->dailyAt('06:00')->withoutOverlapping();
        $schedule->command('sync:tutor-mentor')->everyThreeHours()->withoutOverlapping(); # adjust the throttling frequency at the CRM routes
        $schedule->command('sync:free-trial-program')->everyFifteenMinutes()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
