<?php

namespace App\Administration\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\EventTypeRepository;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\EventType;
use App\Form\EventTypeType;
use Symfony\Component\HttpFoundation\Request;

class EventTypeController extends AbstractController
{
    public function index(EventTypeRepository $eventTypeRepository): Response
    {
        return $this->render('Administration/EventType/event_type.html.twig', [
            'event_types' => $eventTypeRepository->findAll()
        ]);
    }

    public function add(Request $request): Response
    {
        $eventTypes = new EventType();
        $form = $this->createForm(EventTypeType::class, $eventTypes);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventTypes);
            $entityManager->flush();

            return $this->redirectToRoute('owp_administration_administration_eventtype');
        }

        return $this->render('Administration/EventType/add.html.twig', [
            'event_type' => $eventTypes,
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request, EventType $eventTypes): Response
    {
        $form = $this->createForm(EventTypeType::class, $eventTypes);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('owp_administration_administration_eventtype');
        }

        return $this->render('Administration/EventType/edit.html.twig', [
            'event_type' => $eventTypes,
            'form' => $form->createView(),
        ]);
    }

    public function delete(EventType $eventTypes): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($eventTypes);
        $entityManager->flush();

        return $this->redirectToRoute('owp_administration_administration_eventtype');
    }
}
