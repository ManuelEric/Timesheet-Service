<?php

namespace App\Http\Traits;

use Illuminate\Support\Collection;

trait SelectFeeByActivity
{
    public function selectFee(string $activityName, Object $feeCollections)
    {
        switch (strtolower($activityName))
        {
            // activityName will be Additional Fee 
            case "additional fee": 
                $selectedFee = $feeCollections->additional_fee;
                break;

            // activityName will be Bonus Fee
            case "bonus fee":
                $selectedFee = $feeCollections->bonus_fee;
                break;

            default:
                $selectedFee = $feeCollections->fee_hours;
        }

        return $selectedFee;
    }
}
