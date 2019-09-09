<?php

namespace App\Administration\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\EventRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use App\Form\EventType;
use Symfony\Component\HttpFoundation\Request;

class EventController extends AbstractController
{
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('Administration/Event/event.html.twig', [
            'events' => $eventRepository->findAll()
        ]);
    }

    public function add(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('owp_administration_administration_content_event');
        }

        return $this->render('Administration/Event/add.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('owp_administration_administration_content_event');
        }

        return $this->render('Administration/Event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    public function delete(Event $event): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($event);
        $entityManager->flush();

        return $this->redirectToRoute('owp_administration_administration_content_event');
    }
}
