<?php

namespace App\Entity;

use App\Repository\CreativeRedemptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreativeRedemptionRepository::class)]
class CreativeRedemption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $mediaURL = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getMediaURL(): ?string
    {
        return $this->mediaURL;
    }

    public function setMediaURL(string $mediaURL): static
    {
        $this->mediaURL = $mediaURL;

        return $this;
    }
}
