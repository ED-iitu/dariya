<?php


namespace App\Helpers;


class DateHelper
{
    static function validateDate($date, $format = 'd.m.Y'){
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    static function changeDateFormat($date, $to_format, $format = 'd.m.Y')
    {
        $d = \DateTime::createFromFormat($format, $date);
        return ($d) ? $d->format($to_format) : $date;
    }
}