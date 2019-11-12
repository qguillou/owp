<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventTypeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EventType extends AbstractToolkit
{
}
