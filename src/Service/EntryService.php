<?php

namespace App\Service;

use App\Entity\Event;
use App\Entity\Entry;
use App\Entity\People;
use App\Form\EntryType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class EntryService {

    private $em;
    private $formFactory;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $formFactory)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }

    public function getForm(Event $event)
    {
        if ($event->getNumberPeopleByEntries() === 1) {
            //$formFactory->create();
        }
        else {
            $entry = new Entry();
            $entry->setEvent($event);
            for ($i=0; $i < $event->getNumberPeopleByEntries(); $i++) {
                $people = new People();
                $people->setPosition($i + 1);
                $entry->addPeople($people);
            }

            $form = $this->formFactory->create(EntryType::class, $entry);
        }

        return $form;
    }

    public function entries(&$form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();

            $this->em->persist($entity);
            $this->em->flush();
        }
    }
}
