<?php


namespace App\Controller;


use App\Service\Ticking\TickingManager;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class MainController extends BaseAbstractController
{
    /**
     * @Route("/", name="home")
     * @param TickingManager $tickingManager
     * @return Response
     * @throws ExceptionInterface
     * @throws Exception
     */
    public function home(TickingManager $tickingManager)
    {
        $todayTicking = $tickingManager->getOrCreateTodayTicking($this->getUser(), true);
        if($todayTicking){
            $todayTicking = $this->getSerializer()->normalize($todayTicking, null, ['groups' => 'main']);
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
