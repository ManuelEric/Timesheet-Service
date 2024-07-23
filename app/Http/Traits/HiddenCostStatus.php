<?php

namespace App\Http\Traits;

trait HiddenCostStatus
{
    public function getHiddenCostDescription(string $type): array
    {
        switch ($type) {
            case "additional-fee";
                $name = "Additional Fee";
                $description = "The additional fee added for this timesheet";
                $column = 'additional_fee';
            break;

            case "bonus-fee":
                $name = "Bonus Fee";
                $description = "The bonus added for this timesheet";
                $column = 'bonus_fee';
                break;
        }

        return [$name, $description, $column];
    }
}
