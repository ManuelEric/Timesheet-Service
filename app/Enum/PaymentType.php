<?php

namespace App\Enum;

class PaymentType
{
    const ADDITIONAL_FEE = 'additional-fee';
    const BONUS_FEE = 'bonus-fee';

    public static function isValid($value)
    {
        return in_array($value, self::values());
    }

    public static function values(): array
    {
        return [
            self::ADDITIONAL_FEE,
            self::BONUS_FEE
        ];
    }

}
