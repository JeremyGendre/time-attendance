<?php


namespace App\Service\Utils;


use DateInterval;
use DateTimeInterface;
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

    const DAYS_LABELS = [
        self::MONDAY => 'Lundi',
        self::TUESDAY => 'Mardi',
        self::WEDNESDAY => 'Mercredi',
        self::THURSDAY => 'Jeudi',
        self::FRIDAY => 'Vendredi',
        self::SATURDAY => 'Samedi',
        self::SUNDAY => 'Dimanche',
    ];

    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        if(!$timezone) $timezone = new DateTimeZone('Europe/Paris');
        parent::__construct($time, $timezone);
    }

    /**
     * @param DateTimeInterface $dateTime
     * @return string
     */
    public static function getDayLabel(DateTimeInterface $dateTime): string
    {
        return self::DAYS_LABELS[intval($dateTime->format('N'))];
    }

    /**
     * @return DateTimeInterface
     * @throws Exception
     */
    public static function getMondayOfCurrentWeek(): DateTimeInterface
    {
        return self::getMondayOfWeekFromDate(new DateTime());
    }

    /**
     * @param DateTimeInterface $dateTime
     * @return DateTimeInterface
     * @throws Exception
     */
    public static function getMondayOfWeekFromDate(DateTimeInterface $dateTime): DateTimeInterface
    {
        $now = (clone $dateTime);
        $now->setTime(0,0);
        $difference = intval($now->format('N')) - self::MONDAY;
        return $now->sub(new DateInterval('P'. $difference .'D'));
    }

    /**
     * @param DateTimeInterface $dateTime
     * @return DateTimeInterface
     * @throws Exception
     */
    public static function getSundayOfWeekFromDate(DateTimeInterface $dateTime): DateTimeInterface
    {
        $now = (clone $dateTime);
        $now->setTime(0,0);
        $difference = self::SUNDAY - intval($now->format('N'));
        return $now->add(new DateInterval('P'. abs($difference) .'D'));
    }
}
