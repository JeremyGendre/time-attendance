<?php


namespace App\Controller;

use App\Entity\Ticking;
use App\Repository\TickingRepository;
use App\Repository\UserRepository;
use App\Service\Request\RequestManager;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param TickingRepository $tickingRepository
     * @return JsonResponse
     * @throws Exception
     */
    public function tick(
        RequestManager $requestManager,
        UserRepository $userRepository,
        TickingRepository $tickingRepository
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
        $ticking = $tickingRepository->findOneBy(['user' => $user,'tickingDay' => $now]);
        if(!$ticking) {
            $ticking = new Ticking();
            $ticking->setUser($user)->setTickingDay($now);
        }

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
}

