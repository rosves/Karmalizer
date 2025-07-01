<?php

namespace App\Entity;

use App\Repository\ApologyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApologyRepository::class)]
class Apology extends KarmaAction
{

    #[ORM\Column(length: 255)]
    private ?string $message = null;

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }
}
