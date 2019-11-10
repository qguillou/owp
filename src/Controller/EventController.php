<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventRepository;
use App\Entity\Entry;
use App\Entity\People;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EntryType;

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
    public function show(Request $request, $id, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->find($id);

        $entry = new Entry();
        $entry->setEvent($event);

        $people = new People();
        $people->setEntry($entry);
        $entry->addPeople($people);

        $form = $this->createForm(EntryType::class, $entry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entry = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entry);
            $entityManager->flush();
        }

        return $this->render('Event/show.html.twig', [
            'event' => $event,
            'form' => $form->createView()
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
