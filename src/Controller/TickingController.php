<?php


namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\Request\RequestManager;
use App\Service\Ticking\TickingManager;
use App\Service\Utils\DateTime;
use Exception;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * @Route("/ticking")
 * Class TickingController
 * @package App\Controller
 */
class TickingController extends BaseAbstractController
{
    /**
     * @Route("", name="tick_action", methods={"POST"})
     * @param RequestManager $requestManager
     * @param UserRepository $userRepository
     * @param TickingManager $tickingManager
     * @return JsonResponse
     * @throws Exception
     */
    public function tick(
        RequestManager $requestManager,
        UserRepository $userRepository,
        TickingManager $tickingManager
    ): JsonResponse{
        $userId = $requestManager->get('user');
        $user = $this->getUser();
        if($userId){
            $user = $userRepository->find(intval($userId));
            if(!$user) throw new BadRequestException("L'utilisateur est introuvable");
        }
        $action = $requestManager->get('action');
        if(!$action) throw new BadRequestException("L'action doit être précisée");

        $now = new DateTime();
        $ticking = $tickingManager->getOrCreateTicking($user, $now);

        switch ($action){
            case 'enter':
                $ticking->setEnterDate($now);
                break;
            case 'break':
                $ticking->setBreakDate($now);
                break;
            case 'return':
                $ticking->setReturnDate($now);
                break;
            case 'exit':
                $ticking->setExitDate($now);
                break;
            default:
                throw new BadRequestException("L'action est incorrecte");
        }

        $manager = $this->getManager();
        $manager->persist($ticking);
        $manager->flush();

        return new JsonResponse([
            'time' => $now->format('H:i')
        ]);
    }

    /**
     * @Route("/my-history", name="get_my_ticking_history", methods={"GET"})
     * @param TickingManager $tickingManager
     * @return JsonResponse
     * @throws ExceptionInterface
     * @throws Exception
     */
    public function myHistory(TickingManager $tickingManager):JsonResponse
    {
        $tickings = $tickingManager->getUserTickingHistory($this->getUser());
        return new JsonResponse([
            'tickings' => $this->getSerializer()->normalizeMany($tickings, null, ['groups' => 'history'])
        ]);
    }
}

