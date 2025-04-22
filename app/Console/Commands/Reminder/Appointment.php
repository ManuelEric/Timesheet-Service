<?php

namespace App\Console\Commands\Reminder;

use App\Http\Traits\EmailReminderVariables;
use App\Mail\ReminderAppointment;
use App\Models\Activity;
use App\Services\Timesheet\TimesheetDataService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Appointment extends Command
{
    use EmailReminderVariables;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rem:appointment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is designed to send a reminder for each activity one day before it starts.';

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
        /* retrieve all activities one day before they start */
        $activities = Activity::ActivityNotRunningYet()->dayBeforeStart(1)->hasNotBeenReminded()->get();
        $total_data = count($activities);

        /* progress bar */
        $progress = $this->output->createProgressBar($total_data);
        $progress->start();

        /* report variables */
        $total_mail_sent = 0;

        foreach ($activities as $activity) {

            [$tutormentor_email, $viewData] = $this->createVariablesUsingActivity($activity);
            $this->sendTheReminder($tutormentor_email, $viewData);

            /* count the total mail that successfully sent */
            $total_mail_sent++;
            $progress->advance();
        }

        /* console report */
        $this->newLine();
        $this->info("{$total_mail_sent} Mail of reminder appointment has been stored into a job queue.");

        /* finish the progress */
        if ($total_data > 0)
            $progress->finish();

        return COMMAND::SUCCESS;
    }

    private function sendTheReminder(string $tutormentor_email, array $viewData)
    {
        Mail::to($tutormentor_email)->queue(new ReminderAppointment($viewData));
    }
}
