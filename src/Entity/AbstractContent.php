<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

abstract class AbstractContent extends AbstractEntity
{
    use ORMBehaviors\Sluggable\Sluggable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(type="string", length=512)
     */
    protected $slug;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        $this->generateSlug();

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSluggableFields()
    {
        return [ 'id', 'title' ];
    }

    public function generateSlugValue($values)
    {
        return implode('-', $values);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getTitle();
    }
}
