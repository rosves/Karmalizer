<?php

namespace App\Entity;

use App\Repository\DonationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonationRepository::class)]
class Donation extends KarmaAction
{
    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(length: 255)]
    private ?string $donationTarget = null;

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDonationTarget(): ?string
    {
        return $this->donationTarget;
    }

    public function setDonationTarget(string $donationTarget): static
    {
        $this->donationTarget = $donationTarget;

        return $this;
    }
}
