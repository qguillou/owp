<?php

namespace App\Common\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\NewsRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\News;
use App\Form\NewsType;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends AbstractController
{
    public function show(News $news): Response
    {
        return $this->render('Common/News/news.html.twig', [
            'news' => $news,
        ]);
    }
}
