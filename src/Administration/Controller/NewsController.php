<?php

namespace App\Administration\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\NewsRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\News;
use App\Form\NewsType;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends AbstractController
{
    public function index(NewsRepository $newsRepository): Response
    {
        return $this->render('Administration/News/news.html.twig', [
            'news' => $newsRepository->findAll()
        ]);
    }

    public function add(Request $request): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute('owp_administration_administration_content_news');
        }

        return $this->render('Administration/News/add.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request, News $news): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('owp_administration_administration_content_news');
        }

        return $this->render('Administration/News/edit.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    public function delete(News $news): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($news);
        $entityManager->flush();

        return $this->redirectToRoute('owp_administration_administration_content_news');
    }
}
