<?php

namespace App\Http\Traits;

trait MonthCollection
{
    public function month()
    {
        $months = [];
        for ($m=1; $m<=12; $m++) {
            $months[] = strtolower(date('F', mktime(0,0,0,$m, 1, date('Y'))));
        }

        return $months;
    }
}
