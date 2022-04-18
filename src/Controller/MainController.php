<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends BaseAbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function home()
    {
        return $this->render('app/app.html.twig');
    }
}
