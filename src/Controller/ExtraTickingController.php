<?php


namespace App\Controller;

use App\Entity\ExtraTicking;
use App\Repository\TickingRepository;
use App\Service\Request\RequestManager;
use App\Service\Ticking\TickingManager;
use App\Service\Utils\DateTime;
use Exception;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
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

    /**
     * @Route("/today", name="create_extra_ticking_for_today", methods={"POST"})
     * @param RequestManager $requestManager
     * @param TickingManager $tickingManager
     * @return JsonResponse
     * @throws ExceptionInterface
     * @throws Exception
     */
    public function createExtraTickingForToday(
        RequestManager $requestManager,
        TickingManager $tickingManager
    ):JsonResponse{
        $start = $requestManager->get('start');
        $end = $requestManager->get('end');
        if(!$start || !$end) throw new BadRequestException("L'heure de départ et de retour sont obligatoires");

        $todayTicking = $tickingManager->getOrCreateTodayTicking();

        $extraTicking = new ExtraTicking();
        $extraTicking->setTicking($todayTicking)
            ->setStartDate(new DateTime($start))
            ->setEndDate(new DateTime($end))
            ->setDescription($requestManager->get('description', ''));

        $manager = $this->getManager();
        $manager->persist($extraTicking);
        $manager->flush();

        return new JsonResponse([
            'extraTicking' => $this->getSerializer()->normalize($extraTicking, null, [
                'groups' => 'main',
                DateTimeNormalizer::FORMAT_KEY => 'H:i'
            ])
        ]);
    }

    /**
     * @Route("/{id}", name="delete_one_extra_ticking", methods={"DELETE"})
     * @param ExtraTicking $extraTicking
     * @return JsonResponse
     */
    public function deleteExtraTicking(ExtraTicking $extraTicking)
    {
        $manager = $this->getManager();
        $manager->remove($extraTicking);
        $manager->flush();

        return $this->basicSuccessResponse();
    }
}
