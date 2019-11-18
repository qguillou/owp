<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class News extends AbstractContent
{
    /**
     * @ORM\Column(name="promote", type="boolean")
     */
    protected $promote;

    /**
     * @ORM\Column(name="private", type="boolean", nullable=true)
     */
    protected $private;

    public function __construct()
    {
        $this->setPromote(true);
    }

    public function isPromote(): ?bool
    {
        return $this->promote;
    }

    public function setPromote(bool $promote): self
    {
        $this->promote = $promote;

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
