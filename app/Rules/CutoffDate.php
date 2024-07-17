<?php

namespace App\Rules;

use App\Models\Cutoff;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class CutoffDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /* get month name from end date and use it to find if the month and year already exists in the database */
        $monthYear = Carbon::parse($value)->format('F Y');
        if (Cutoff::where('month', $monthYear)->exists())
            $fail('Payment for the specified period has already been processed.');
    }
}
