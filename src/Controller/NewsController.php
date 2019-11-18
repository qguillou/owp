<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NewsRepository;
use App\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class NewsController extends AbstractController
{
    /**
     * @Route("/news/{slug}", name="owp_news_show")
     */
    public function show(News $news): Response
    {
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
