<?php

function minutesToTimeFormat($minutes)
{
    $hours = floor($minutes / 60);
    $minutes = $minutes % 60;

    return sprintf('%02d:%02d', $hours, $minutes);
}
