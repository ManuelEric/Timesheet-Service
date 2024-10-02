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
}
