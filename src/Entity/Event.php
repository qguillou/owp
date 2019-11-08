<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\EventType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Event extends AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateBegin;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @ORM\ManyToOne(targetEntity="EventType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $eventType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $organizer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $locationTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $locationInformation;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity="Circuit", cascade={"persist", "remove"}, mappedBy="event")
     */
    private $circuits;

    /**
     * @ORM\OneToMany(targetEntity="Entry", cascade={"persist", "remove"}, mappedBy="event")
     */
    private $entries;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getOrganizer(): ?string
    {
        return $this->organizer;
    }

    public function setOrganizer(string $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getLocationTitle(): ?string
    {
        return $this->locationTitle;
    }

    public function setLocationTitle(string $locationTitle): self
    {
        $this->locationTitle = $locationTitle;

        return $this;
    }

    public function getLocationInformation(): ?string
    {
        return $this->locationInformation;
    }

    public function setLocationInformation($locationInformation): self
    {
        $this->locationInformation = $locationInformation;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLinkEvents()
    {
        return $this->linkEvents;
    }

    public function setLinkEvents($linkEvents): self
    {
        $this->linkEvents = $linkEvents;

        return $this;
    }

    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->dateBegin;
    }

    public function setDateBegin(\DateTime $dateBegin): self
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd($dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getEventType(): ?EventType
    {
        return $this->eventType;
    }

    public function setEventType(EventType $eventType): self
    {
        $this->eventType = $eventType;

        return $this;
    }

    public function getCircuits()
    {
        return $this->circuits;
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function setCircuits($circuits): self
    {
        $this->circuits = $circuits;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getTitle();
    }
}
