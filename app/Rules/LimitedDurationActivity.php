<?php

namespace App\Rules;

use App\Models\Timesheet;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class LimitedDurationActivity implements ValidationRule
{
    protected $method;
    protected $timesheetId;
    protected $activityId;
    protected $start_date;
    protected $end_date;

    public function __construct($method, $timesheetId, $activityId, $incomingDate)
    {
        $this->method = $method;
        $this->timesheetId = $timesheetId;
        $this->activityId = $activityId;
        $this->start_date = $incomingDate['start'];
        $this->end_date = $incomingDate['end'];
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /* fetch the duration and sum the total time spent */
        $timesheet = Timesheet::find($this->timesheetId);
        $duration = (float) $timesheet->duration; // total minutes of package
        $total_hours_spent = $this->method == 'PUT' ? $timesheet->activities()->whereNot('id', $this->activityId)->sum('time_spent') : $timesheet->activities()->sum('time_spent');

        /* check the diff between start and end date
            put 0 if there isn't end_date or the user doesn't input the end_date
            so the expected_time_spent only sum the existing time_spent from existing activities */
        $diff_in_minutes = $this->end_date != null ? $this->start_date->diffInMinutes($this->end_date) : 0;

        /* the time spent would be */
        $total_time_spent = $total_hours_spent + $diff_in_minutes;

        if ( $duration < $total_time_spent )
        {
            if ( $diff_in_minutes == 0 )
                $fail("The specified duration exceeds the maximum limit. Please adjust accordingly.");
            else
                $fail("Cannot store activity anymore because the time spent has exceeds the maximum limit.");
        }

    }
}
