<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Model\Common as OwpCommonTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Menu
{
    use OwpCommonTrait\IdTrait;
    use OwpCommonTrait\LabelTrait;
    use OwpCommonTrait\AuthorTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $link;

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
