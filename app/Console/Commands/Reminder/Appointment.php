<?php

namespace App\Console\Commands\Reminder;

use App\Jobs\PartOf\ReminderAppointment as PartOfReminderAppointment;
use App\Mail\ReminderAppointment;
use App\Models\Activity;
use App\Services\Timesheet\TimesheetDataService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class Appointment extends Command
{
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

    /**
     * Execute the console command.
     */
    public function handle(TimesheetDataService $timesheetDataService)
    {
        /* retrieve all activities one day before they start */
        $activities = Activity::unpaid()->dayBeforeStart(1)->hasNotBeenReminded()->get();
        $progress = $this->output->createProgressBar(count($activities));
        $progress->start();
        $total_mail_sent = 0;
        foreach ( $activities as $activity )
        {
            $activityId = $activity->id;
            $timesheet = $activity->timesheet;
            $detail = $timesheetDataService->detailTimesheet($timesheet);

            /* extract the details */
            $clients = $detail['clientProfile'];
            $packageDetails = $detail['packageDetails'];
            $packageDetails['category'] = $timesheet->package->category;
            $editableColumns = $detail['editableColumns'];
            $tutormentor_email = $editableColumns['tutormentor_email'];
            $additionalInfo = [
                'clients' => $detail['clientProfile'],
                'timesheet' => $timesheet,
                'package' => $packageDetails,
            ];

            /* extract the activity */
            $activityId = $activity->id;
            $activityStartDate = Carbon::parse($activity->start_date);
            $activityEndDate = Carbon::parse($activity->end_date);
            $meetingLink = $activity->meeting_link;
            $activityDetails = [
                'id' => $activityId,
                'date' => $activityStartDate->format('d F Y'),
                'start_time' => $activityStartDate->format('H:i'),
                'end_time' => $activityEndDate->format('H:i'),
                'link' => $meetingLink
            ];

            $viewData = compact('additionalInfo', 'activityDetails');
            Mail::to($tutormentor_email)->queue(new ReminderAppointment($viewData));
            
            $total_mail_sent++;
            $progress->advance();
        }
        $this->newLine();
        $this->info("{$total_mail_sent} Mail has been stored into a job queue.");

        $progress->finish();
        return COMMAND::SUCCESS;
    }
}
