<?php

namespace App\Rules;

use App\Models\TempUser;
use App\Models\TempUserRoles;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExistSubjectPerTutormentor implements ValidationRule
{
    protected $mentortutor_email;

    public function __construct($mentortutor_email)
    {
        $this->mentortutor_email = $mentortutor_email;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ( $value )
        {
            $tempUser = TempUser::where('email', $this->mentortutor_email)->first();

            if ( !TempUserRoles::where('id', $value)->where('temp_user_id', $tempUser->id)->isActive()->exists() )
                $fail('The subject given is not valid.');
        }
    }
}
