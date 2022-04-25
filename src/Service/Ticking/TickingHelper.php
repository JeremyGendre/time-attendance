<?php


namespace App\Service\Ticking;


use App\Service\Utils\DateTime;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class TickingHelper
{
    /**
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public static function getWeekAndYearFromRequest(Request $request): array
    {
        $now = new DateTime();
        $currentYear = $now->format('Y');

        $requestedYear = $request->query->get('year');
        if(!$requestedYear || !is_numeric($requestedYear) || intval($requestedYear) > intval($currentYear)){
            $requestedYear = $currentYear;
        }

        $currentWeek = $now->format('W');
        $requestedWeek = $request->query->get('week');
        if(!$requestedWeek || !is_numeric($requestedWeek) || (intval($currentWeek) < intval($requestedWeek) && intval($requestedYear) === intval($currentYear))){
            $requestedWeek = $currentWeek;
        }
        return [$requestedWeek, $requestedYear];
    }
}
