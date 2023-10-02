<?php
namespace App\Utils;

use DateTime;

class ValidateDate {
    public static function run($date, $format = 'Y-m-d') {
        $dateTime = DateTime::createFromFormat($format, $date);
        return $dateTime && $dateTime->format($format) === $date;
    }
}
