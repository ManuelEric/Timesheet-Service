<?php

namespace App\Rules;

use App\Models\Package;
use App\Models\TempUser;
use App\Models\TempUserRoles;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CompatiblePackage implements ValidationRule
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
        $package = Package::find($value);
        if ( !preg_match("/{$this->user_role}/i", $package->category) )
            $fail("The selected package is incompatible with the user role.");
    }
}
