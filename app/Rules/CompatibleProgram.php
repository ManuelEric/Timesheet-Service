<?php

namespace App\Rules;

use App\Models\Ref_Program;
use App\Models\TempUserRoles;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CompatibleProgram implements ValidationRule
{
    protected $user_role;

    public function __construct($subject_id)
    {
        $temp_user = TempUserRoles::find($subject_id);
        $this->user_role = $temp_user->role;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $ref = Ref_Program::find($value);
        if ( $ref->require != $this->user_role ) 
            $fail("The selected program is incompatible with the mentor/tutor.");        
    }
}
