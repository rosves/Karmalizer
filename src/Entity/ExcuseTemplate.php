<?php

namespace App\Entity;

use App\Repository\ExcuseTemplateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExcuseTemplateRepository::class)]
class ExcuseTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column]
    private ?int $severity_min = null;

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

    public function getSeverityMin(): ?int
    {
        return $this->severity_min;
    }

    public function setSeverityMin(int $severity_min): static
    {
        $this->severity_min = $severity_min;

        return $this;
    }
}
