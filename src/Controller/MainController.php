<?php


namespace App\Controller;


use App\Repository\TickingRepository;
use App\Service\Ticking\TickingHelper;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class MainController extends BaseAbstractController
{
    /**
     * @Route("/", name="home")
     * @param TickingRepository $tickingRepository
     * @return Response
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function home(TickingRepository $tickingRepository)
    {
        $todayTicking = $tickingRepository->findOneBy(['user' => $this->getUser(),'tickingDay' => new DateTime()]);
        if($todayTicking){
            $todayTicking = TickingHelper::normalizeTicking($todayTicking, $this->getSerializer());
        }

        return $this->render('app/app.html.twig',[
            'todayTicking' => $todayTicking
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     * @return Response
     */
    public function admin(): Response
    {
        return $this->render('admin/admin.html.twig');
    }

    /**
     * @Route("/my-history", name="my_ticking_history")
     * @return Response
     */
    public function tickingHistory(): Response
    {
        return $this->render('app/myHistory.html.twig');
    }
}
