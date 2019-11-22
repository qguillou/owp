<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Model\Common as OwpCommonTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventTypeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EventType
{
    use OwpCommonTrait\IdTrait;
    use OwpCommonTrait\LabelTrait;
    use OwpCommonTrait\AuthorTrait;
}
