<?php

namespace App\Http\Traits;

use Illuminate\Support\Carbon;

trait PaymentDateConverter
{
    public function convert(Carbon $start_date, mixed $end_date): string
    {
        $date = $start_date->format('d M Y');
        $start_time = $start_date->format('H.i');
        $end_time = $end_date ? $end_date->format('H.i') : 'unknown';

        $result = "{$date} ({$start_time} - {$end_time})";
        return $result;
    }
}
