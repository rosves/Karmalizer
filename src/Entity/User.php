<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['username'], message: 'Ce nom d’utilisateur est déjà pris.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?int $KarmaBalance = null;

    #[ORM\OneToOne(mappedBy: 'user_id', cascade: ['persist', 'remove'])]
    private ?KarmaScore $karmaScore = null;

    /**
     * @var Collection<int, Offense>
     */
    #[ORM\OneToMany(targetEntity: Offense::class, mappedBy: 'user_id')]
    private Collection $offenses;

    /**
     * @var Collection<int, RedemptionVote>
     */
    #[ORM\OneToMany(targetEntity: RedemptionVote::class, mappedBy: 'User_id')]
    private Collection $redemptionVotes;

    /**
     * @var Collection<int, Reward>
     */
    #[ORM\ManyToMany(targetEntity: Reward::class, mappedBy: 'User_id')]
    private Collection $rewards;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    /**
     * @var Collection<int, KarmaAction>
     */
    #[ORM\OneToMany(targetEntity: KarmaAction::class, mappedBy: 'user_id')]
    private Collection $karmaActions;

    public function __construct()
    {
        $this->offenses = new ArrayCollection();
        $this->redemptionVotes = new ArrayCollection();
        $this->rewards = new ArrayCollection();
        $this->karmaActions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;;
        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getKarmaBalance(): ?int
    {
        return $this->KarmaBalance;
    }

    public function setKarmaBalance(int $KarmaBalance): static
    {
        $this->KarmaBalance = $KarmaBalance;

        return $this;
    }

    public function getKarmaScore(): ?KarmaScore
    {
        return $this->karmaScore;
    }

    public function setKarmaScore(KarmaScore $karmaScore): static
    {
        // set the owning side of the relation if necessary
        if ($karmaScore->getUserId() !== $this) {
            $karmaScore->setUserId($this);
        }

        $this->karmaScore = $karmaScore;

        return $this;
    }

    /**
     * @return Collection<int, Offense>
     */
    public function getOffenses(): Collection
    {
        return $this->offenses;
    }

    public function addOffense(Offense $offense): static
    {
        if (!$this->offenses->contains($offense)) {
            $this->offenses->add($offense);
            $offense->setUserId($this);
        }

        return $this;
    }

    public function removeOffense(Offense $offense): static
    {
        if ($this->offenses->removeElement($offense)) {
            // set the owning side to null (unless already changed)
            if ($offense->getUserId() === $this) {
                $offense->setUserId(null);
            }
        }

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
            $redemptionVote->setUserId($this);
        }

        return $this;
    }

    public function removeRedemptionVote(RedemptionVote $redemptionVote): static
    {
        if ($this->redemptionVotes->removeElement($redemptionVote)) {
            // set the owning side to null (unless already changed)
            if ($redemptionVote->getUserId() === $this) {
                $redemptionVote->setUserId(null);
            }
        }

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
            $reward->addUserId($this);
        }

        return $this;
    }

    public function removeReward(Reward $reward): static
    {
        if ($this->rewards->removeElement($reward)) {
            $reward->removeUserId($this);
        }

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

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
            $karmaAction->setUserId($this);
        }

        return $this;
    }

    public function removeKarmaAction(KarmaAction $karmaAction): static
    {
        if ($this->karmaActions->removeElement($karmaAction)) {
            // set the owning side to null (unless already changed)
            if ($karmaAction->getUserId() === $this) {
                $karmaAction->setUserId(null);
            }
        }

        return $this;
    }
}
