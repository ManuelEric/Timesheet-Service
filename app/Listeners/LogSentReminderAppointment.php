<?php

namespace App\Listeners;

use App\Models\Reminder;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogSentReminderAppointment
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MessageSent $event): void
    {
        $eventData = $event->data;

        /* when the title was not setup by the mail provider */
        if ( !array_key_exists('title', $eventData))
            return;
        
            

        /* if the email sent was the reminder of appointment */
        switch ( $eventData['title'] )
        {
            case 'Reminder Appointment':
                if ( !array_key_exists('activityId', $eventData) )
                {
                    Log::error('[EMAIL:REMINDER APPOINTMENT] Failed to create a log reminder of appointment cause of activity Id doesn\'t exists.', $eventData);
                    return;
                }

                DB::beginTransaction();
                try {

                    $activityId = $eventData['activityId'];
                    $record = Reminder::isAppointmentReminder()->where('activity_id', $activityId)->first();
                    $latest_times = $record->times ?? 0;
                    $new_times = $latest_times + 1;
        
                    Reminder::updateOrCreate([
                        'activity_id' => $activityId,
                        'times' => $new_times,
                        'type' => 'appointment'
                    ]);
                    DB::commit();
                } catch (Exception $e) {
                    Log::error('[EMAIL:REMINDER APPOINTMENT] Failed to create a log reminder of appointment cause of the unprocessable entity.', $eventData);
                    DB::rollBack();
                    return;
                }
                break;

            case 'Reminder Quota':
                if ( !array_key_exists('timesheetId', $eventData) )
                {
                    Log::error('[EMAIL:REMINDER QUOTA] Failed to create a log reminder of quota left cause of timesheet Id doesn\'t exists.', $eventData);
                    return;
                }

                DB::beginTransaction();
                try {

                    $timesheetId = $eventData['timesheetId'];
                    $record = Reminder::isQuotaReminder()->where('timesheet_id', $timesheetId)->first();
                    $latest_times = $record->times ?? 0;
                    $new_times = $latest_times + 1;
        
                    Reminder::updateOrCreate([
                        'timesheet_id' => $timesheetId,
                        'times' => $new_times,
                        'type' => 'quota-left'
                    ]);
                    DB::commit();
                } catch (Exception $e) {
                    Log::error('[EMAIL:REMINDER QUOTA] Failed to create a log reminder of quota-left cause of the unprocessable entity.', $eventData);
                    DB::rollBack();
                    return;
                }
                break;
        }
    }
}
