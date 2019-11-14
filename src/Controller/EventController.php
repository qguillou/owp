<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventRepository;
use App\Entity\Entry;
use App\Entity\People;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EntryType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Service\EntryService;

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
    public function show(Request $request, $id, EventRepository $eventRepository, EntryService $entryService): Response
    {
        $event = $eventRepository->find($id);

        $form = $entryService->getForm($event);
        $form->handleRequest($request);
        $entryService->entries($form);

        return $this->render('Event/show.html.twig', [
            'form' => $form->createView(),
            'event' => $event
        ]);
    }

    /**
     * @Route("/api/event", name="owp_api_event")
     */
    public function api(EventRepository $eventRepository): JsonResponse
    {
        $results = [];
        $events = $eventRepository->findAll();

        foreach ($events as $event) {
            $results[] = ['date' => $event->getDateBegin()->format('Y-m-d'), 'title' => $event->getTitle()];
        }

        return new JsonResponse($results);
    }
}
