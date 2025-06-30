<?php

namespace App\Entity;

use App\Repository\RedemptionVoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RedemptionVoteRepository::class)]
class RedemptionVote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $VoteValue = null;

    #[ORM\ManyToOne(inversedBy: 'redemptionVotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User_id = null;

    #[ORM\ManyToOne(inversedBy: 'redemptionVotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?KarmaAction $KarmaAction_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoteValue(): ?int
    {
        return $this->VoteValue;
    }

    public function setVoteValue(int $VoteValue): static
    {
        $this->VoteValue = $VoteValue;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->User_id;
    }

    public function setUserId(?User $User_id): static
    {
        $this->User_id = $User_id;

        return $this;
    }

    public function getKarmaActionId(): ?KarmaAction
    {
        return $this->KarmaAction_id;
    }

    public function setKarmaActionId(?KarmaAction $KarmaAction_id): static
    {
        $this->KarmaAction_id = $KarmaAction_id;

        return $this;
    }
}
