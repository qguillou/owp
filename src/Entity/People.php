<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class People extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Base")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $base;

    /**
     * @ORM\ManyToOne(targetEntity="Entry", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $entry;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $lastName;

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

        return $this;
    }

    public function getEntry(): ?Entry
    {
        return $this->entry;
    }

    public function setEntry(Entry $entry): self
    {
        $this->entry = $entry;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;

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
