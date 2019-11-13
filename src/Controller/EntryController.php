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
use Symfony\Component\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class EntryController extends AbstractController
{

    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/entry/quick/{id}", name="owp_entry_quick")
     * @IsGranted("ROLE_USER")
     */
    public function quick($id, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->find($id);

        if ($this->isGranted('register', $event)) {
            $user = $this->getUser();

            $entry = new Entry();
            $people = new People();

            $entry->setEvent($event);
            $entry->addPeople($people);

            if (!empty($user->getBase())) {
                $people->setBase($user->getBase());
            }
            else {
                $people->setFirstName($user->getFirstName());
                $people->setLastName($user->getLastName());
                $this->addFlash('warning', 'Vous vous êtes inscrit en tant que non licencié. Si vous êtes licencié, veuillez renseigner votre n° de licence dans votre compte et modifier votre inscription.');
            }

            $this->getDoctrine()->getManager()->persist($entry);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('primary', 'Vous êtes maintenant inscrit à cet événement.');
        }
        else {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à vous inscrire à cet événement.');
        }

        return $this->redirectToRoute('owp_event_show', array(
            'id' => $id,
        ));
    }

    /**
     * @Route("/entry/{id}/update", name="owp_entry_update")
     * @IsGranted("ROLE_USER")
     */
    public function update($id, EntryRepository $entryRepository): Response
    {
        $entry = $entryRepository->find($id);

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
     * @Route("/entry/{id}/delete", name="owp_entry_delete")
     * @IsGranted("ROLE_USER")
     */
    public function delete($id, EntryRepository $entryRepository): Response
    {
        $entry = $entryRepository->find($id);

        if ($this->isGranted('delete', $entry)) {
            $this->getDoctrine()->getManager()->remove($entry);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('primary', 'L\'inscription a bien été supprimée.');
        }
        else {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à supprimer cette inscription.');
        }

        return $this->redirectToRoute('owp_event_show', array(
            'id' => $entry->getEvent()->getId(),
        ));
    }
}
