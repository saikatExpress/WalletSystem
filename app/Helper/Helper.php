<?php

use Carbon\Carbon;

function defaultDate($date)
{
    $dateString = $date;
    $formattedDate = Carbon::parse($dateString)->format('Y/m/d');

    return $formattedDate;
}

function dateTimeFormat($date)
{
    $dateString    = $date;
    $date          = DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
    $formattedDate = $date->format('d M, y');

    return $formattedDate;
}
