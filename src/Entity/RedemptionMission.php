<?php

namespace App\Entity;

use App\Repository\RedemptionMissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RedemptionMissionRepository::class)]
class RedemptionMission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    /**
     * @var Collection<int, Offense>
     */
    #[ORM\ManyToMany(targetEntity: Offense::class, inversedBy: 'redemptionMissions')]
    private Collection $Offenses;

    /**
     * @var Collection<int, Reward>
     */
    #[ORM\ManyToMany(targetEntity: Reward::class, mappedBy: 'RedemptionMission_id')]
    private Collection $rewards;

    #[ORM\Column]
    private ?int $severity_min = null;

    public function __construct()
    {
        $this->Offenses = new ArrayCollection();
        $this->rewards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Offense>
     */
    public function getOffenses(): Collection
    {
        return $this->Offenses;
    }

    public function addOffense(Offense $offense): static
    {
        if (!$this->Offenses->contains($offense)) {
            $this->Offenses->add($offense);
        }

        return $this;
    }

    public function removeOffense(Offense $offense): static
    {
        $this->Offenses->removeElement($offense);

        return $this;
    }

    /**
     * @return Collection<int, Reward>
     */
    public function getRewards(): Collection
    {
        return $this->rewards;
    }

    public function addReward(Reward $reward): static
    {
        if (!$this->rewards->contains($reward)) {
            $this->rewards->add($reward);
            $reward->addRedemptionMissionId($this);
        }

        return $this;
    }

    public function removeReward(Reward $reward): static
    {
        if ($this->rewards->removeElement($reward)) {
            $reward->removeRedemptionMissionId($this);
        }

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
