<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/front', name: 'app_front')]
    public function index(): Response
    {
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /*#[Route('/ftransport', name: 'app_transport_f')]
    public function transport_front(): Response
    {
        return $this->render('templates/front/transport/indexf.html.twig', [
            'controller_name' => '',
        ]);
    }
    /*#[Route('/ftransport', name: 'app_transport_f')]
    public function transport(): Response
    {
        return $this->render('front/transport.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }*/
}
