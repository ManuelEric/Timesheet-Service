<?php

namespace App\Rules;

use App\Models\Activity;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistStartDateActivities implements ValidationRule
{
    protected $method;
    protected $timesheetId;
    protected $activityId;

    public function __construct($method, $timesheetId, $activityId = null)
    {
        $this->method = $method;
        $this->timesheetId = $timesheetId;
        $this->activityId = $activityId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $sameDate = Activity::where('timesheet_id', $this->timesheetId)->
            where('start_date', $value)->
            when($this->method == 'PUT', function ($query) {
                $query->except($this->activityId);
            })->
            exists();
        if ( $sameDate )
            $fail('It looks like the date you selected has already occurred. Please choose a different date.');
    }
}
