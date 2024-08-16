<?php

namespace App\Http\Traits;

trait TranslatePackageCategory
{
    public function convert($incomingCategory): string
    {
        switch ($incomingCategory)
        {
            case "mentor":
                $converted = "External Mentors";
                break;

            case "tutor":
                $converted = "Tutoring";
                break;
        }

        return $converted;
    }
}
