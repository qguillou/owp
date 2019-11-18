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
        $eventFilters = [];
        $eventFilters[] = ['name' => 'dateBegin', 'value' => date('Y-m-d'), 'operator' => '>'];

        if (!$this->isGranted('ROLE_MEMBER')) {
            $eventFilters[] = ['name' => 'private', 'value' => false, 'operator' => '='];
        }

        return $this->render('Event/list.html.twig', [
            'events' => $eventRepository->findFiltered($eventFilters),
        ]);
    }

    /**
     * @Route("/event/{id}", name="owp_event_show", requirements={"page"="\d+"})
     */
    public function show(Request $request, $id, EventRepository $eventRepository, EntryService $entryService): Response
    {
        $event = $eventRepository->find($id);

        if (!$event) {
            throw $this->createNotFoundException('L\'événement est introuvable');
        }

        if (!$this->isGranted('view', $event)) {
            throw $this->createAccessDeniedException('Vous n\'êtes par autorisé à consulter cette page.');
        }

        return $this->render('Event/show.html.twig', [
            'form' => $this->isGranted('register', $event) ? $entryService->form($request, $event)->createView() : null,
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
