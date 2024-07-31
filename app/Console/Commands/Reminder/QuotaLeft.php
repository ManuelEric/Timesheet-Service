<?php

namespace App\Console\Commands\Reminder;

use App\Http\Traits\EmailReminderVariables;
use App\Mail\ReminderQuota;
use App\Models\Timesheet;
use App\Services\Timesheet\TimesheetDataService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class QuotaLeft extends Command
{
    use EmailReminderVariables;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rem:quota-left';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is designed to send a reminder for each timesheet that almost reached the total duration.';

    protected $timesheetDataService;

    public function __construct(TimesheetDataService $timesheetDataService)
    {
        parent::__construct();
        $this->timesheetDataService = $timesheetDataService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $almostExpires_timesheets = Timesheet::expiresInHours(1)->hasNotBeenReminded()->get();
        $total_data = count($almostExpires_timesheets);

        /* progress bar */
        $progress = $this->output->createProgressBar($total_data);
        $progress->start();

        /* report variables */
        $total_mail_sent = 0;

        foreach ( $almostExpires_timesheets as $almostExpires_timesheets )
        {
            [$tutormentor_email, $viewData] = $this->createVariablesUsingTimesheet($almostExpires_timesheets);
            $this->sendTheReminder($tutormentor_email, $viewData);

            /* count the total mail that successfully sent */
            $total_mail_sent++;
            $progress->advance();
        }

        /* console report */
        $this->newLine();
        $this->info("{$total_mail_sent} Mail of reminder quota has been stored into a job queue.");

        /* finish the progress */
        if ( $total_data > 0 )
            $progress->finish();

        return COMMAND::SUCCESS;
        
    }

    private function sendTheReminder(string $tutormentor_email, array $viewData)
    {
        Mail::to($tutormentor_email)->queue(new ReminderQuota($viewData));
    }
}
