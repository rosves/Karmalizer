<?php

namespace App\Entity;

use App\Repository\GoodeedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GoodeedRepository::class)]
class Goodeed extends KarmaAction
{

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
