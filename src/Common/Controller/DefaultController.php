<?php

namespace App\Common\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NewsRepository;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="owp_common_homepage")
     */
    public function index(NewsRepository $newsRepository): Response
    {
        return $this->render('Common/homepage.html.twig', [
            'news' => $newsRepository->findAll()
        ]);
    }

    public function about(): Response
    {
        return $this->render('Common/about.html.twig', [

        ]);
    }
}
