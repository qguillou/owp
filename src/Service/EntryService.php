<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Entry;
use App\Entity\People;
use App\Entity\User;
use App\Form\EntryType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Twig\Environment;
use Knp\Snappy\Pdf;

class EntryService {

    const EXPORT_PDF = 'pdf';

    private $em;
    private $formFactory;
    private $session;
    private $security;
    private $twig;
    private $pdf;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $formFactory, SessionInterface $session, Security $security, Environment $twig, Pdf $pdf)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->session = $session;
        $this->security = $security;
        $this->twig = $twig;
        $this->pdf = $pdf;
    }

    public function form(Request $request, Event $event)
    {
        /*if ($event->getNumberPeopleByEntries() === 1) {
            //$formFactory->create();
        }
        else {*/
            $form = $this->formFactory->create(EntryType::class, $this->values($event));
        //}

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();

            $this->save($entity);
        }

        return $form;
    }

    public function update()
    {
        $this->session->getFlashBag()->add('danger', 'Vous n\'êtes pas autorisé à modifier cette inscription.');
    }

    public function delete(Entry $entry)
    {
        if ($this->security->isGranted('delete', $entry)) {
            $this->em->remove($entry);
            $this->em->flush();

            $this->session->getFlashBag()->add('primary', 'L\'inscription a bien été supprimée.');
        }
        else {
            $this->session->getFlashBag()->add('danger', 'Vous n\'êtes pas autorisé à supprimer cette inscription.');
        }
    }

    public function export(Event $event, $format)
    {
        switch($format)
        {
            case self::EXPORT_PDF:
                return $this->exportPDF($event);
        }
    }

    private function save(Entry $entry)
    {
        if ($this->security->isGranted('register', $entry->getEvent())) {
            $this->em->persist($entry);
            $this->em->flush();

            $this->session->getFlashBag()->add('primary', 'Vous êtes maintenant inscrit à cet événement.');
        }
        else {
            $this->session->getFlashBag()->add('danger', 'Vous n\'êtes pas autorisé à vous inscrire à cet événement.');
        }
    }

    private function values(Event $event, User $user = null): Entry
    {
        $entry = new Entry();
        $entry->setEvent($event);

        for ($i = 0; $i < $event->getNumberPeopleByEntries(); $i++) {
            $people = new People();
            $people->setPosition($i + 1);
            $entry->addPeople($people);

            if (!empty($user) && !empty($user->getBase())) {
                $people->setBase($user->getBase());
            }
            elseif (!empty($user)) {
                $people->setFirstName($user->getFirstName());
                $people->setLastName($user->getLastName());

                $this->session->getFlashBag()->add('warning', 'Vous vous êtes inscrit en tant que non licencié. Si vous êtes licencié, veuillez renseigner votre n° de licence dans votre compte et modifier votre inscription.');
            }
        }

        return $entry;
    }

    private function exportPDF(Event $event)
    {
        $html = $this->twig->render('Entry/export_pdf.html.twig', array(
            'event'  => $event
        ));
        
        return new PdfResponse(
            $this->pdf->getOutputFromHtml($html),
            'file.pdf'
        );
    }
}
