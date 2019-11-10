<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\NewsRepository;
use App\Repository\EventRepository;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="owp_homepage")
     */
    public function index(NewsRepository $newsRepository, EventRepository $eventRepository): Response
    {
        return $this->render('Common/homepage.html.twig', [
            'news' => $newsRepository->findBy(array('promote' => true), array('updateAt' => 'DESC')),
            'events' => $eventRepository->findFutureEvent(3),
        ]);
    }
}
