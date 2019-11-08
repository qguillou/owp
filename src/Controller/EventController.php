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

    /**
     * @Route("/api/event", name="owp_api_event")
     */
    public function api(EventRepository $eventRepository): Response
    {
        $results = [];
        $events = $eventRepository->findAll();

        foreach ($events as $event) {
            $results[] = ['date' => $event->getDateBegin()->format('Y-m-d'), 'title' => $event->getTitle()];
        }

        $events = new Response(json_encode($results));
        $events->headers->set('Content-Type', 'application/json');

        return $events;
    }
}
