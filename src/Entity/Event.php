<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\EventType;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Model\Common as OwpCommonTrait;
use App\Model\Event as OwpEventTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Event
{
    use OwpCommonTrait\IdTrait;
    use OwpCommonTrait\TitleTrait;
    use OwpCommonTrait\ContentTrait;
    use OwpCommonTrait\AuthorTrait;
    use OwpCommonTrait\PrivateTrait;

    use OwpEventTrait\EventLocationTrait;
    use OwpEventTrait\EventEntryTrait;

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
     * @ORM\OneToMany(targetEntity="Circuit", cascade={"persist", "remove"}, mappedBy="event")
     */
    protected $circuits;

    /**
     * @ORM\ManyToMany(targetEntity="News")
     * @ORM\JoinTable(name="event_news",
     *      joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id")}
     * )
     */
    protected $sections;


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
}
