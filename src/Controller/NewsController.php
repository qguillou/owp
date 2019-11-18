<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NewsRepository;

class NewsController extends AbstractController
{
    /**
     * @Route("/news/{id}", name="owp_news_show", requirements={"page"="\d+"})
     */
    public function show($id, NewsRepository $newsRepository): Response
    {
        $news = $newsRepository->find($id);

        if (!$news) {
            throw $this->createNotFoundException('L\'actualité est introuvable');
        }

        if (!$this->isGranted('view', $news)) {
            throw $this->createAccessDeniedException('Vous n\'êtes par autorisé à consulter cette page.');
        }

        return $this->render('News/show.html.twig', [
            'news' => $news,
        ]);
    }
}
