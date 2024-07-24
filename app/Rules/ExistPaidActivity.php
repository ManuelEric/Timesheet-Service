<?php

namespace App\Rules;

use App\Models\Activity;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistPaidActivity implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $activity = Activity::paid()->where('id', $value)->exists();
        if ( !$activity )
        {
            $fail('One or more of the selected activity IDs is invalid.');
        }
    }
}
