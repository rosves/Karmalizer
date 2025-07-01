<?php

namespace App\Entity;

use App\Enum\PlatformType;
use App\Repository\OffenseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffenseRepository::class)]
class Offense
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_offense = null;

    #[ORM\ManyToOne(inversedBy: 'offenses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    /**
     * @var Collection<int, KarmaAction>
     */
    #[ORM\OneToMany(targetEntity: KarmaAction::class, mappedBy: 'Offense_id')]
    private Collection $karmaActions;

    /**
     * @var Collection<int, RedemptionMission>
     */
    #[ORM\ManyToMany(targetEntity: RedemptionMission::class, mappedBy: 'Offenses')]
    private Collection $redemptionMissions;

    #[ORM\Column]
    private ?int $severity = null;

    #[ORM\Column(enumType: PlatformType::class)]
    private ?PlatformType $platform = null;

    public function __construct()
    {
        $this->karmaActions = new ArrayCollection();
        $this->redemptionMissions = new ArrayCollection();
        $this->date_offense = new \DateTimeImmutable();
    }

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

    public function getDateOffense(): ?\DateTimeImmutable
    {
        return $this->date_offense;
    }

    public function setDateOffense(\DateTimeImmutable $date_offense): static
    {
        $this->date_offense = $date_offense;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection<int, KarmaAction>
     */
    public function getKarmaActions(): Collection
    {
        return $this->karmaActions;
    }

    public function addKarmaAction(KarmaAction $karmaAction): static
    {
        if (!$this->karmaActions->contains($karmaAction)) {
            $this->karmaActions->add($karmaAction);
            $karmaAction->setOffenseId($this);
        }

        return $this;
    }

    public function removeKarmaAction(KarmaAction $karmaAction): static
    {
        if ($this->karmaActions->removeElement($karmaAction)) {
            // set the owning side to null (unless already changed)
            if ($karmaAction->getOffenseId() === $this) {
                $karmaAction->setOffenseId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RedemptionMission>
     */
    public function getRedemptionMissions(): Collection
    {
        return $this->redemptionMissions;
    }

    public function addRedemptionMission(RedemptionMission $redemptionMission): static
    {
        if (!$this->redemptionMissions->contains($redemptionMission)) {
            $this->redemptionMissions->add($redemptionMission);
            $redemptionMission->addOffense($this);
        }

        return $this;
    }

    public function removeRedemptionMission(RedemptionMission $redemptionMission): static
    {
        if ($this->redemptionMissions->removeElement($redemptionMission)) {
            $redemptionMission->removeOffense($this);
        }

        return $this;
    }

    public function getSeverity(): ?int
    {
        return $this->severity;
    }

    public function setSeverity(int $severity): static
    {
        $this->severity = $severity;

        return $this;
    }

    public function getPlatform(): ?PlatformType
    {
        return $this->platform;
    }

    public function setPlatform(PlatformType $platform): static
    {
        $this->platform = $platform;

        return $this;
    }
}
