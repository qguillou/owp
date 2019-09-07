<?php

namespace App\Common\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('Common/homepage.html.twig', [

        ]);
    }

    public function about(): Response
    {
        return $this->render('Common/about.html.twig', [

        ]);
    }
}
