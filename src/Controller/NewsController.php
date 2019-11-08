<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NewsRepository;

class NewsController extends AbstractController
{
    /**
     * @Route("/news/{id}", name="owp_news_show")
     */
    public function show($id, NewsRepository $newsRepository): Response
    {
        return $this->render('News/show.html.twig', [
            'news' => $newsRepository->find($id),
        ]);
    }
}
