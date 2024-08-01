<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StatusActivity implements ValidationRule
{
    protected $end_date;

    public function __construct($end_date)
    {
        $this->end_date = $end_date;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ( $value == 1 && $this->end_date === NULL )
            $fail("The status cannot be updated until an end date is set.");
    }
}
