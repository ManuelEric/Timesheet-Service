<?php

namespace App\Http\Traits;

trait TranslateActivityStatus
{
    public function translate(int $status)
    {
        switch ($status)
        {
            case 0:
                $translate = 'Not Yet';
                break;

            case 1:
                $translate = 'Completed';
                break;
        }

        return $translate;
    }
}
