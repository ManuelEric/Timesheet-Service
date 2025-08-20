<?php

namespace App\Http\Traits;

use App\Models\Package;

trait StudentClub
{
    /**
     * Summary of convertToProfessionalSharingPackageId
     * @param mixed $engagement_type_id
     * @param int $package_id
     * @return string
     * 
     * this will be used only for converting student club to professional sharing
     * and only to get fee from professional sharing
     * because student club and professional sharing shared same fee
     */
    public function convertToProfessionalSharingPackageId(int $engagement_type_id, int $package_id): array
    {
        // Convert Engagement Type ID
        // 2 is for Student Club
        // 3 is for Professional Sharing
        $engagement_type_id = $engagement_type_id == 2 ? 3 : $engagement_type_id;

        // Convert student club package IDs to professional sharing package IDs
        switch ($package_id) {
            case 44: // Student Club 1 on 1 
                $package_id = Package::where('type_of', 'Professional Sharing 1-on-1')->first()->id;
                break;
            case 45: // Student Club 2 - 10
                $package_id = Package::where('type_of', 'Professional Sharing 2-10 Mentees')->first()->id;
                break;
            case 46: // Student Club > 10
                $package_id = Package::where('type_of', 'Professional Sharing >10 Mentees')->first()->id;
                break;
            default:
                $package_id; // Return the original if no match found
        }

        return [$engagement_type_id, $package_id];
    }
}
