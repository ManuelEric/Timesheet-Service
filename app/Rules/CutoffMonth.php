<?php

namespace App\Rules;

use App\Models\Cutoff;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class CutoffMonth implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $requestMonth = Carbon::parse($value)->format('F Y');
        if ( !Cutoff::where('month', $requestMonth)->withinTheCutoffDateRange($value)->exists() )
            $fail("The cutoff for the month you selected has not been created yet.");
    }
}
