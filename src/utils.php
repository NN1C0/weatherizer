<?php

/**
 * Converts a timestamp to the local weekday based on the specified locale.
 *
 * @param int $timestamp The timestamp to convert.
 * @param string $locale The locale to use for determining the weekday. Default is "nl_NL".
 * @return string The local weekday corresponding to the timestamp.
 */

function timestampToLocalWeekday($timestamp, $locale = "nl_NL")
{
    date_default_timezone_set("Europe/Amsterdam");
    return date("D", $timestamp);
}

function timestampToLocalHour($timestamp, $locale = "nl_NL")
{
    date_default_timezone_set("Europe/Amsterdam");
    return date("H", $timestamp);
}

function timestampToLocalTime($timestamp, $locale = "nl_NL")
{
    date_default_timezone_set("Europe/Amsterdam");
    return date("H:i", $timestamp);
}

?>
