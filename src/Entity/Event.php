<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\EventType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Event extends AbstractContent
{
    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateBegin;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateEnd;

    /**
     * @ORM\ManyToOne(targetEntity="EventType")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $eventType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $organizer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $locationTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $locationInformation;

    /**
     * @ORM\Column(type="decimal", nullable=true, precision=8, scale=6)
     */
    protected $latitude;

    /**
     * @ORM\Column(type="decimal", nullable=true, precision=8, scale=6)
     */
    protected $longitude;

    /**
     * @ORM\OneToMany(targetEntity="Circuit", cascade={"persist", "remove"}, mappedBy="event")
     */
    protected $circuits;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $allowEntries;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateEntries;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $numberPeopleByEntries;

    /**
     * @ORM\OneToMany(targetEntity="Entry", cascade={"persist", "remove"}, mappedBy="event")
     */
    protected $entries;

    /**
     * @ORM\ManyToMany(targetEntity="News")
     * @ORM\JoinTable(name="event_news",
     *      joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id")}
     * )
     */
    protected $sections;

    /**
     * @ORM\Column(name="private", type="boolean", nullable=true)
     */
    protected $private;

    public function __construct()
    {
        $this->circuits = new ArrayCollection();
        $this->sections = new ArrayCollection();
        $this->numberPeopleByEntries = 1;
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

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

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

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude): self
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


    public function getAllowEntries(): ?bool
    {
        return $this->allowEntries;
    }

    public function setAllowEntries(bool $allowEntries): self
    {
        $this->allowEntries = $allowEntries;

        return $this;
    }

    public function getDateEntries(): ?\DateTimeInterface
    {
        return $this->dateEntries;
    }

    public function setDateEntries($dateEntries): self
    {
        $this->dateEntries = $dateEntries;

        return $this;
    }

    public function getNumberPeopleByEntries(): ?int
    {
        return $this->numberPeopleByEntries;
    }

    public function setNumberPeopleByEntries($numberPeopleByEntries): self
    {
        $this->numberPeopleByEntries = $numberPeopleByEntries;

        return $this;
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function getCircuits()
    {
        return $this->circuits;
    }

    public function setCircuits($circuits): self
    {
        $this->circuits = $circuits;

        return $this;
    }

    public function addCircuits($circuit)
    {
        $circuit->setEvent($this);
        $this->circuits->add($circuit);

        return $this;
    }

    public function getSections()
    {
        return $this->sections;
    }

    public function setSections($sections): self
    {
        $this->sections = $sections;

        return $this;
    }

    public function addSections($sections)
    {
        $this->circuits->add($circuit);

        return $this;
    }

    public function isPrivate(): ?bool
    {
        return $this->private;
    }

    public function setPrivate(bool $private): self
    {
        $this->private = $private;

        return $this;
    }
}
