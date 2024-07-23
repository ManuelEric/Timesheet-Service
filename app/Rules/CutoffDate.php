<?php

namespace App\Rules;

use App\Models\Cutoff;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class CutoffDate implements ValidationRule
{
    protected $start_date;
    protected $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = Carbon::parse($start_date)->format('Y-m-d');
        $this->end_date = Carbon::parse($end_date)->format('Y-m-d');
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /* get month name from end date and use it to find if the month and year already exists in the database */
        $monthYear = Carbon::parse($value)->format('F Y');
        if ( Cutoff::where('month', $monthYear)->exists() && Cutoff::inBetween($this->start_date, $this->end_date)->exists() )
            $fail('Payment for the specified period has already been processed.');
    }
}
