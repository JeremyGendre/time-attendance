<?php


namespace App\Service\Utils;


use DateInterval;
use DateTimeZone;
use Exception;

/**
 * Class DateTime
 * @package App\Service\Utils
 */
class DateTime extends \DateTime
{
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
    const SUNDAY = 7;

    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        if(!$timezone) $timezone = new DateTimeZone('Europe/Paris');
        parent::__construct($time, $timezone);
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public static function getMondayOfCurrentWeek(): DateTime
    {
        return self::getMondayOfWeekFromDate(new DateTime());
    }

    /**
     * @param DateTime $dateTime
     * @return DateTime
     * @throws Exception
     */
    public static function getMondayOfWeekFromDate(DateTime $dateTime): DateTime
    {
        $now = (clone $dateTime)->setTime(0,0);
        $difference = intval($now->format('N')) - self::MONDAY;
        return $now->sub(new DateInterval('P'. $difference .'D'));
    }

}
