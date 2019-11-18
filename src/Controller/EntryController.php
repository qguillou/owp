<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventRepository;
use App\Repository\EntryRepository;
use App\Entity\Entry;
use App\Entity\People;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EntryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\EntryService;

class EntryController extends AbstractController
{
    /**
     * @Route("/entry/quick/{id}", name="owp_entry_quick", requirements={"page"="\d+"})
     * @IsGranted("ROLE_USER")
     */
    public function quick($id, EventRepository $eventRepository, EntryService $entryService): Response
    {
        $event = $eventRepository->find($id);
        $entry = $entryService->values($event, $this->getUser());
        $entryService->save($entry);

        return $this->redirectToRoute('owp_event_show', array(
            'id' => $id,
        ));
    }

    /**
     * @Route("/entry/{id}/update", name="owp_entry_update", requirements={"page"="\d+"})
     * @IsGranted("ROLE_USER")
     */
    public function update($id, EntryRepository $entryRepository, EntryService $entryService): Response
    {
        $entry = $entryRepository->find($id);
        $entryService->update($entry);
        if ($this->isGranted('update', $entry)) {

        }
        else {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cette inscription.');
        }

        return $this->redirectToRoute('owp_event_show', array(
            'id' => $entry->getEvent()->getId(),
        ));
    }

    /**
     * @Route("/entry/{id}/delete", name="owp_entry_delete", requirements={"page"="\d+"})
     * @IsGranted("ROLE_USER")
     */
    public function delete($id, EntryRepository $entryRepository, EntryService $entryService): Response
    {
        $entry = $entryRepository->find($id);
        $entryService->delete($entry);

        return $this->redirectToRoute('owp_event_show', array(
            'id' => $entry->getEvent()->getId(),
        ));
    }

    /**
     * @Route("/entry/{id}/export/{format}", name="owp_entry_export", requirements={"page"="\d+"})
     */
    public function export($id, $format, EventRepository $eventRepository, EntryService $entryService): Response
    {
        $event = $eventRepository->find($id);

        return $entryService->export($event, $format);
    }
}
