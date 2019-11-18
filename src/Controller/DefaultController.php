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
        $newsFilters = $eventFilters = [];
        $newsFilters['promote'] = true;
        $eventFilters[] = ['name' => 'dateBegin', 'value' => date('Y-m-d'), 'operator' => '>'];

        if (!$this->isGranted('ROLE_MEMBER')) {
            $newsFilters['private'] = false;
            $eventFilters[] = ['name' => 'private', 'value' => false, 'operator' => '='];
        }

        return $this->render('Homepage/homepage.html.twig', [
            'news' => $newsRepository->findBy($newsFilters, array('updateAt' => 'DESC')),
            'events' => $eventRepository->findFiltered($eventFilters, 4),
        ]);
    }
}
