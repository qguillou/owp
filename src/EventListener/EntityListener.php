<?php

namespace App\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\AbstractEntity;
use Doctrine\ORM\Events;

class EntityListener implements EventSubscriber
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        $class = $event->getEntityManager()->getClassMetadata(get_class($entity));

        if ($class->hasField('createBy')) {
            $entity->setCreateBy($this->tokenStorage->getToken()->getUser());
        }
        if ($class->hasField('updateBy')) {
            $entity->setUpdateBy($this->tokenStorage->getToken()->getUser());
        }
    }

    public function preUpdate(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        $class = $event->getEntityManager()->getClassMetadata(get_class($entity));

        if ($class->hasField('updateBy')) {
            $entity->setUpdateBy($this->tokenStorage->getToken()->getUser());
        }
    }
}
