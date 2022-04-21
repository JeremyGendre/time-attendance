<?php


namespace App\Controller;


use App\Repository\ServiceRepository;
use App\Repository\TickingRepository;
use App\Service\Serializer\TimeSerializerHelper;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

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
            $todayTicking = $this->getSerializer()->normalize($todayTicking, null, [
                'groups' => 'main',
                DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i',
            ]);
            $todayTicking = TimeSerializerHelper::normalizeTimeAttributes($todayTicking);
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
