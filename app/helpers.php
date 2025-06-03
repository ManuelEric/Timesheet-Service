<?php

if (! function_exists('minutesToTimeFormat'))
{
    /**
     * Create a new function for the converter date.
     *
     * @param  \DateTimeZone|string|null  $tz
     * @return \Illuminate\Support\Carbon
     */
    function minutesToTimeFormat($minutes)
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;
    
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    function formatToRupiah($value)
    {
        return "Rp ". number_format($value, 0, ',', '.');
    }

    function roundCustom($number) {
        $lower = floor($number / 10) * 10;
        $upper = ceil($number / 10) * 10;
        return ($number - $lower) < ($upper - $number) ? $lower : $upper;
    }
}
