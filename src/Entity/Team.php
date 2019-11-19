<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Team extends AbstractEntry
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $label;

    /**
     * @ORM\OneToMany(targetEntity="People", mappedBy="team", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $peoples;

    public function __construct()
    {
        $this->peoples = new ArrayCollection();
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getPeoples()
    {
        return $this->peoples;
    }

    public function setPeoples(ArrayCollection $peoples): self
    {
        $this->peoples = $peoples;

        return $this;
    }

    public function addPeople(People $people): self
    {
        $this->peoples->add($people);
        $people->setTeam($this);
        $people->setEvent($this->getEvent());

        return $this;
    }

    public function removePeople(People $people): self
    {
        $this->peoples->remove($people);

        return $this;
    }

    public function contains(Base $base)
    {
        if (!empty($base)) {
            return false;
        }

        $this->peoples->rewind();

        while ($this->peoples->valid()) {
            if($this->peoples->current()->getBase() === $base) {
                return true;
            }

            $this->peoples->next();
        }

        return false;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getLabel();
    }
}
