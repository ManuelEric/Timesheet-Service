<?php

namespace App\Rules;

use App\Models\Activity;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistStartDateActivities implements ValidationRule
{
    protected $timesheetId;

    public function __construct($timesheetId)
    {
        $this->timesheetId = $timesheetId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $sameDate = Activity::where('timesheet_id', $this->timesheetId)->where('start_date', $value)->exists();
        if ( $sameDate )
            $fail('It looks like the date you selected has already occurred. Please choose a different date.');
    }
}
