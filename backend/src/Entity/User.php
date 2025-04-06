<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank]
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
    #[Assert\NotBlank]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $token = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $tokenDate = null;

    /**
     * @var Collection<int, UserBar>
     */
    #[ORM\OneToMany(targetEntity: UserBar::class, mappedBy: 'user')]
    private Collection $userBars;

    /**
     * @var Collection<int, UserBand>
     */
    #[ORM\OneToMany(targetEntity: UserBand::class, mappedBy: 'user')]
    private Collection $userBands;

    /**
     * @var Collection<int, SubscribedEvent>
     */
    #[ORM\OneToMany(targetEntity: SubscribedEvent::class, mappedBy: 'user')]
    private Collection $subscribedEvents;

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
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getTokenDate(): ?\DateTimeInterface
    {
        return $this->tokenDate;
    }

    public function setTokenDate(?\DateTimeInterface $tokenDate): static
    {
        $this->tokenDate = $tokenDate;

        return $this;
    }

    /**
     * @return Collection<int, UserBar>
     */
    public function getUserBars(): Collection
    {
        return $this->userBars;
    }

    public function addUserBar(UserBar $userBar): static
    {
        if (!$this->userBars->contains($userBar)) {
            $this->userBars->add($userBar);
            $userBar->setUser($this);
        }

        return $this;
    }

    public function removeUserBar(UserBar $userBar): static
    {
        if ($this->userBars->removeElement($userBar)) {
            // set the owning side to null (unless already changed)
            if ($userBar->getUser() === $this) {
                $userBar->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserBand>
     */
    public function getUserBands(): Collection
    {
        return $this->userBands;
    }

    public function addUserBand(UserBand $userBand): static
    {
        if (!$this->userBands->contains($userBand)) {
            $this->userBands->add($userBand);
            $userBand->setUser($this);
        }

        return $this;
    }

    public function removeUserBand(UserBand $userBand): static
    {
        if ($this->userBands->removeElement($userBand)) {
            // set the owning side to null (unless already changed)
            if ($userBand->getUser() === $this) {
                $userBand->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SubscribedEvent>
     */
    public function getSubscribedEvents(): Collection
    {
        return $this->subscribedEvents;
    }

    public function addSubscribedEvent(SubscribedEvent $subscribedEvent): static
    {
        if (!$this->subscribedEvents->contains($subscribedEvent)) {
            $this->subscribedEvents->add($subscribedEvent);
            $subscribedEvent->setUser($this);
        }

        return $this;
    }

    public function removeSubscribedEvent(SubscribedEvent $subscribedEvent): static
    {
        if ($this->subscribedEvents->removeElement($subscribedEvent)) {
            // set the owning side to null (unless already changed)
            if ($subscribedEvent->getUser() === $this) {
                $subscribedEvent->setUser(null);
            }
        }

        return $this;
    }
}
