<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Circuit extends AbstractToolkit
{
    /**
    * @ORM\ManyToOne(targetEntity="Event", inversedBy="circuits")
    * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
    */
    protected $event;

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
