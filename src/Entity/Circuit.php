<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Owp\OwpCore\Model as OwpCommonTrait;
use App\Model\Event as OwpEventTrait;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Circuit
{
    use OwpCommonTrait\IdTrait;
    use OwpCommonTrait\LabelTrait;
    use OwpCommonTrait\AuthorTrait;

    use OwpEventTrait\EventReferenceTrait;

    /**
    * @ORM\ManyToOne(targetEntity="Event", inversedBy="circuits")
    * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
    */
    protected $event;
}
