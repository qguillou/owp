<?php

namespace App\Common\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NewsRepository;

class DefaultController extends AbstractController
{
    public function index(NewsRepository $newsRepository): Response
    {
        return $this->render('Common/homepage.html.twig', [
            'news' => $newsRepository->findBy(array('promote' => TRUE), array('updateAt' => 'DESC')),
        ]);
    }

    public function about(): Response
    {
        return $this->render('Common/about.html.twig', [

        ]);
    }
}
