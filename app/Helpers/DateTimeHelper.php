<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 1/30/18
 * Time: 4:37 PM
 */

namespace App\Helpers;


use Carbon\Carbon;

class DateTimeHelper
{
    const DEFAULT_DATE_TIME_FORMAT = 'd-m-Y H:m:s';
    const DEFAULT_DATE_FORMAT = 'd.m.Y';
    const DEFAULT_TIME_FORMAT = 'H:i';
    public static function getDateTime($date, $format = null)
    {
        if (! $format)
            $format  = self::DEFAULT_DATE_TIME_FORMAT;

        $carbon = new Carbon($date);
        return $carbon->format($format);
    }

    public static function getDate($dateTime, $format = null)
    {
        if (! $format)
            $format = self::DEFAULT_DATE_FORMAT;

        return Carbon::parse($dateTime)->format($format);
    }
    public static function getTime($dateTime, $format = null)
    {
        if (! $format)
            $format = self::DEFAULT_TIME_FORMAT;

        $timestamp = Carbon::createFromFormat('Y-m-d H:m:s', $dateTime)->format($format);
        return $timestamp;
    }
    public static function createDateTime($date, $time, $format = null)
    {
        if (! $format)
            $format =  self::DEFAULT_DATE_FORMAT .' '. self::DEFAULT_TIME_FORMAT;

        return Carbon::createFromFormat($format,"$date $time")->toDateTimeString();
    }
    public static function createDate($date ,$fromFormat = null)
    {
        if (! $fromFormat)
            $fromFormat = self::DEFAULT_DATE_FORMAT;
        return Carbon::createFromFormat($fromFormat,$date)->endOfDay()->toDateTimeString();
    }
    public static function getLongDateTimeFormat($timestamp) //must be carbon object
    {
        $formattedDateTime =  $timestamp->format('l\\, F j\\, Y \\a\\t h:i:s A'); // Tuesday, January 28, 2020 at 12:02:28 PM
        $formattedDateTime .= ' '. $timestamp->timezone->getName(); //add timezone
        return $formattedDateTime;
    }

    public static function getShortDateTimeFormat($timestamp, $timezone = false) //must be carbon object
    {
        $formattedDateTime =  self::getShortDay($timestamp).', '. $timestamp->format('j F, h:i A'); //Tue, 28 January, 12:26:22 PM
        if ($timezone)
            $formattedDateTime .= ' '. $timestamp->timezone->getName(); //add timezone

        return $formattedDateTime;
    }

    public static function getShortDay($timestamp) //must be carbon object
    {
        return $timestamp->shortEnglishDayOfWeek; // 3 letter Day i.e Tue
    }
    public static function getShortMonth($timestamp) //must be carbon object
    {
        return $timestamp->shortEnglishMonth; //    3 letter Month i.e Jan
    }

    public static function getShortDateTimesArray($timestamp) //must be carbon object
    {
        $data = [];
        $data['month'] = self::getShortMonth($timestamp);
        $data['day'] = self::getShortDay($timestamp);
        $data['dateTime'] = self::getShortDateTimeFormat($timestamp);
        return $data;
    }

}
