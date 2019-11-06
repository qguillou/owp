<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventRepository;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="owp_event_list")
     */
    public function list(EventRepository $eventRepository): Response
    {
        return $this->render('Event/list.html.twig', [
            'events' => $eventRepository->findFutureEvent(),
        ]);
    }

    /**
     * @Route("/event/{id}", name="owp_event_show")
     */
    public function show($id, EventRepository $eventRepository): Response
    {
        return $this->render('Event/show.html.twig', [
            'event' => $eventRepository->find($id),
        ]);
    }

}
