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

    /**
     * @Route("/admin", name="admin")
     * @return Response
     */
    public function admin()
    {
        return $this->render('admin/admin.html.twig');
    }
}
