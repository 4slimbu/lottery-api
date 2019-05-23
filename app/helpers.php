<?php

if(!function_exists('datetimeStringToUtc')) {
    /**
     * Take the provided datetime string and converts to the app timezone. This is intended for datetime strings which
     * include timezone data, eg. W3C format
     *
     * @param string $datetime
     *
     * @return string
     */
    function datetimeStringToUtc($datetime)
    {
        if (empty($datetime)) {
            return $datetime;
        }

        return Carbon\Carbon::parse($datetime)->timezone('UTC')->toDateTimeString();
    }
}
