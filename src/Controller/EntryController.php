<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventRepository;
use App\Repository\EntryRepository;
use App\Entity\Entry;
use App\Entity\Event;
use App\Entity\People;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EntryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\EntryService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class EntryController extends AbstractController
{
    /**
     * @Route("/entry/quick/{id}", name="owp_entry_quick", requirements={"page"="\d+"})
     * @IsGranted("ROLE_USER")
     * @ParamConverter("event")
     */
    public function quick(Event $event, EventRepository $eventRepository, EntryService $entryService): Response
    {
        $entry = $entryService->values($event, $this->getUser());
        $entryService->save($entry);

        return $this->redirectToRoute('owp_event_show', array(
            'slug' => $event->getSlug(),
        ));
    }

    /**
     * @Route("/entry/{id}/update", name="owp_entry_update", requirements={"page"="\d+"})
     * @IsGranted("ROLE_USER")
     */
    public function update(Entry $entry, EntryService $entryService): Response
    {
        $entryService->update($entry);
        if ($this->isGranted('update', $entry)) {

        }
        else {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à modifier cette inscription.');
        }

        return $this->redirectToRoute('owp_event_show', array(
            'slug' => $entry->getEvent()->getSlug(),
        ));
    }

    /**
     * @Route("/entry/{id}/delete", name="owp_entry_delete", requirements={"page"="\d+"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Entry $entry, EntryService $entryService): Response
    {
        $entryService->delete($entry);

        return $this->redirectToRoute('owp_event_show', array(
            'slug' => $entry->getEvent()->getSlug(),
        ));
    }

    /**
     * @Route("/entry/{id}/export/{format}", name="owp_entry_export", requirements={"page"="\d+"})
     */
    public function export(Event $event, $format, EntryService $entryService): Response
    {
        return $entryService->export($event, $format);
    }
}
