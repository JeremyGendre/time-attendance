<?php


namespace App\Controller;


use App\Repository\ServiceRepository;
use App\Repository\TickingRepository;
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
        $todayService = $tickingRepository->findOneBy(['user' => $this->getUser(),'tickingDay' => new DateTime()]);
        if($todayService){
            $todayService = $this->getSerializer()->normalize($todayService, null, [
                'groups' => 'main',
                DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i',
            ]);
        }
        dd($todayService);
        return $this->render('app/app.html.twig',[
            'service' => $todayService
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     * @return Response
     */
    public function admin()
    {
        return $this->render('admin/admin.html.twig');
    }
}
