<?php

namespace App\Entity;

use App\Enum\StatusType;
use App\Repository\KarmaActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;

#[ORM\Entity(repositoryClass: KarmaActionRepository::class)]
#[InheritanceType('JOINED')]
#[DiscriminatorColumn(name: 'discr', type: 'string')]
#[DiscriminatorMap([
    'apology' => Apology::class,
    'donation' => Donation::class,
    'good_deed' => Goodeed::class,
    'creative_redemption' => CreativeRedemption::class,
])]
class KarmaAction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'karmaActions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offense $Offense_id = null;

    /**
     * @var Collection<int, RedemptionVote>
     */
    #[ORM\OneToMany(targetEntity: RedemptionVote::class, mappedBy: 'KarmaAction_id')]
    private Collection $redemptionVotes;

    #[ORM\Column(enumType: StatusType::class)]
    private ?StatusType $Type = null;

    public function __construct()
    {
        $this->redemptionVotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOffenseId(): ?Offense
    {
        return $this->Offense_id;
    }

    public function setOffenseId(?Offense $Offense_id): static
    {
        $this->Offense_id = $Offense_id;

        return $this;
    }

    /**
     * @return Collection<int, RedemptionVote>
     */
    public function getRedemptionVotes(): Collection
    {
        return $this->redemptionVotes;
    }

    public function addRedemptionVote(RedemptionVote $redemptionVote): static
    {
        if (!$this->redemptionVotes->contains($redemptionVote)) {
            $this->redemptionVotes->add($redemptionVote);
            $redemptionVote->setKarmaActionId($this);
        }

        return $this;
    }

    public function removeRedemptionVote(RedemptionVote $redemptionVote): static
    {
        if ($this->redemptionVotes->removeElement($redemptionVote)) {
            // set the owning side to null (unless already changed)
            if ($redemptionVote->getKarmaActionId() === $this) {
                $redemptionVote->setKarmaActionId(null);
            }
        }

        return $this;
    }

    public function getType(): ?StatusType
    {
        return $this->Type;
    }

    public function setType(StatusType $Type): static
    {
        $this->Type = $Type;

        return $this;
    }
}
