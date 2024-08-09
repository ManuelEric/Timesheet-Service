<?php

namespace App\Rules;

use App\Models\Package;
use App\Models\Ref_Program;
use App\Models\TempUser;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class SameGrade implements ValidationRule
{
    protected $rule_grade;
    protected $package_category;

    public function __construct($mentortutor_email, $subject_id, $package_id)
    {
        $package = Package::find($package_id);
        $this->package_category = $packageCategory = $package->category;
        
        if ( $packageCategory == "Tutoring" )
        {
            $tutor = TempUser::where('email', $mentortutor_email)->first();
            $selectedTutor = $tutor->roles()->where('id', $subject_id)->where('year', Carbon::now()->format('Y'))->first();

            # $selectedTutor->grade; # should be [11-12]
            # modify the tutor grade
            $tutorGrade_afterReplace = str_replace(['[', ']'], '', $selectedTutor->grade);
            $explodeTutorGrade = explode("-", $tutorGrade_afterReplace);

            $firstValue_ofGrade = $explodeTutorGrade[0];

            $bottle = [];
            while ($firstValue_ofGrade <= $explodeTutorGrade[1])
            {
                array_push($bottle, $firstValue_ofGrade);
                $firstValue_ofGrade++;
            }

            $this->rule_grade = implode("|", $bottle); # should be 10|11|12 
        }

    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ( $this->package_category == "Tutoring" )
        {
            $refs = Ref_Program::find($value);
            $student_grade = $refs->student_grade;
            if ( !preg_match("/^({$this->rule_grade})$/i", $student_grade) )
                $fail("Some students grades are not authorized for grouping.");
            
        }
        
        
        
    }
}
