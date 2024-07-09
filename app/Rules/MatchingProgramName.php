<?php

namespace App\Rules;

use App\Models\Ref_Program;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchingProgramName implements ValidationRule
{
    protected $bottle;

    public function __construct()
    {
        $this->bottle = array();
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        # first, we need to pushing the $value to the empty bottle 
        # so we know that the first value of the empty bottle will be the key to indicates the difference. 
        array_push($this->bottle, $value);


        # we're going to query Ref_Program using submitted Ids
        # then in order to know if the program name is same as another id, we're going to use group by
        # so that if the query returned more than one row, we know that the program name is different between one and another.
        $count_ref_programs = Ref_Program::whereIn('id', $this->bottle)->groupBy('program_name')->count();
        if ( count($this->bottle) > 1 && $count_ref_programs == 1 )
            $fail('The :attribute must have one same program.');
    }
}
