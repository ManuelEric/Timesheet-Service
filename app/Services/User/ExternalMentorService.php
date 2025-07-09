<?php

namespace App\Services\User;

use App\Models\Package;

class ExternalMentorService
{
    public function getEngagementTypeIdForServiceFee(string $package)
    {
        switch ($package) {
            case "Professional Sharing 1-on-1":
            case "Professional Sharing 2-10 Mentees":
            case "Professional Sharing >10 Mentees":
                $engagement_type = 3;
                break;
            case "Competition Mentorship":
                $engagement_type = 5;
                break;
            case "Subject-Specific Project Mentorship":
                $engagement_type = 6;
                break;
            case "Essay Mentoring":
            case "Essay Program Development":
                $engagement_type = null;
                break;
        }

        return $engagement_type;
    }
}
