<?php


namespace App\Service\Utils;


use DateTimeZone;

/**
 * Class DateTime
 * @package App\Service\Utils
 */
class DateTime extends \DateTime
{
    public function __construct($time = 'now', DateTimeZone $timezone = null)
    {
        if(!$timezone) $timezone = new DateTimeZone('Europe/Paris');
        parent::__construct($time, $timezone);
    }
}
