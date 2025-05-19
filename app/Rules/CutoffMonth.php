<?php

namespace App\Rules;

use App\Models\Cutoff;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class CutoffMonth implements ValidationRule
{
    protected $start_date;
    protected $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $requestMonth = Carbon::parse($this->end_date)->format('F Y');
        if ( !Cutoff::where('month', $requestMonth)->inBetween($this->start_date, $this->end_date)->exists() )
            $fail("The cutoff for the month you selected has not been created yet.");
    }
}
