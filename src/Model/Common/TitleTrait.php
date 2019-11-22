<?php

namespace App\Model\Common;

Trait TitleTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

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

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getTitle();
    }
}
