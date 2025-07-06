<?php

namespace App\Entity;

use App\Enum\RewardType;
use App\Repository\RewardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RewardRepository::class)]
class Reward
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(enumType: RewardType::class)]
    private ?RewardType $type = null;

    /**
     * @var Collection<int, RedemptionMission>
     */
    #[ORM\ManyToMany(targetEntity: RedemptionMission::class, inversedBy: 'rewards')]
    private Collection $RedemptionMission_id;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'rewards')]
    private Collection $User_id;

    public function __construct()
    {
        $this->RedemptionMission_id = new ArrayCollection();
        $this->User_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getType(): ?RewardType
    {
        return $this->type;
    }

    public function setType(RewardType $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, RedemptionMission>
     */
    public function getRedemptionMissionId(): Collection
    {
        return $this->RedemptionMission_id;
    }

    public function addRedemptionMissionId(RedemptionMission $redemptionMissionId): static
    {
        if (!$this->RedemptionMission_id->contains($redemptionMissionId)) {
            $this->RedemptionMission_id->add($redemptionMissionId);
        }

        return $this;
    }

    public function removeRedemptionMissionId(RedemptionMission $redemptionMissionId): static
    {
        $this->RedemptionMission_id->removeElement($redemptionMissionId);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->User_id;
    }

    public function addUserId(User $userId): static
    {
        if (!$this->User_id->contains($userId)) {
            $this->User_id->add($userId);
        }

        return $this;
    }

    public function removeUserId(User $userId): static
    {
        $this->User_id->removeElement($userId);

        return $this;
    }

    public function __toString(): string
{
    return $this->name ?? 'Récompense sans nom';
}
}
