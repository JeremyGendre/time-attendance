<?php


namespace App\Controller;

use App\Repository\TickingRepository;
use App\Service\Utils\DateTime;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

/**
 * @Route("/extra-ticking")
 * Class ExtraTickingController
 * @package App\Controller
 */
class ExtraTickingController extends BaseAbstractController
{
    /**
     * @Route("/today", name="get_extra_ticking_of_the_day", methods={"GET"})
     * @param TickingRepository $tickingRepository
     * @return JsonResponse
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function getTodayExtraTicking(TickingRepository $tickingRepository):JsonResponse
    {
        $todayTicking = $tickingRepository->findOneBy(['user' => $this->getUser(), 'tickingDay' => new DateTime()]);
        $extraTickings = $todayTicking ? $todayTicking->getExtraTickings() : [];
        return new JsonResponse([
            'extraTickings' => $this->getSerializer()->normalizeMany($extraTickings,null,[
                'groups' => 'main',
                DateTimeNormalizer::FORMAT_KEY => 'H:i'
            ])
        ]);
    }
}
