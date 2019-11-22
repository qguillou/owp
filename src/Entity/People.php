<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Common as OwpCommonTrait;
use App\Model\Event as OwpEventTrait;
use App\Model\User as OwpUserTrait;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class People
{
    use OwpCommonTrait\IdTrait;
    use OwpCommonTrait\AuthorTrait;

    use OwpEventTrait\EventReferenceTrait;

    use OwpUserTrait\UserNameTrait;

    /**
    * @ORM\ManyToOne(targetEntity="Event", inversedBy="entries")
    */
    protected $event;

    /**
     * @ORM\ManyToOne(targetEntity="Base")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $base;

    /**
     * @ORM\ManyToOne(targetEntity="Team", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $team;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $club;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $comment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $position;

    public function getBase(): ?Base
    {
        return $this->base;
    }

    public function setBase(Base $base): self
    {
        $this->base = $base;
        $this->setFirstName($base->getFirstName());
        $this->setLastName($base->getLastName());
        $this->setClub($base->getClub());

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getClub(): ?string
    {
        return $this->club;
    }

    public function setClub($club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment($comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) (!empty($this->getBase())) ? $this->getBase()->__toString() : $this->getFirstName() . ' ' . $this->getLastName();
    }
}
