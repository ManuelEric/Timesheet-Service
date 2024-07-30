<?php

namespace App\Http\Traits;

trait PackageType
{
    public function convert(string $packageCategory): array
    {
        switch ( $packageCategory )
        {
            case "External Mentors":
                $type = "mentoring";
                $tutor_or_mentor = "Mentor";
                break;

            case "Tutoring":
                $type = "tutoring";
                $tutor_or_mentor = "Tutor";
                break;
        }

        return [$type, $tutor_or_mentor];
    }
}
