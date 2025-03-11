<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $token = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $tokenDate = null;

    /**
     * @var Collection<int, UserBar>
     */
    #[ORM\OneToMany(targetEntity: UserBar::class, mappedBy: 'user_id')]
    private Collection $userBars;

    /**
     * @var Collection<int, UserBand>
     */
    #[ORM\OneToMany(targetEntity: UserBand::class, mappedBy: 'userid')]
    private Collection $userBands;

    /**
     * @var Collection<int, SubscribedEvent>
     */
    #[ORM\OneToMany(targetEntity: SubscribedEvent::class, mappedBy: 'userid')]
    private Collection $subscribedEvents;

    public function __construct()
    {
        $this->userBars = new ArrayCollection();
        $this->userBands = new ArrayCollection();
        $this->subscribedEvents = new ArrayCollection();
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
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
            $userBar->setUserId($this);
        }

        return $this;
    }

    public function removeUserBar(UserBar $userBar): static
    {
        if ($this->userBars->removeElement($userBar)) {
            // set the owning side to null (unless already changed)
            if ($userBar->getUserId() === $this) {
                $userBar->setUserId(null);
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
            $userBand->setUserid($this);
        }

        return $this;
    }

    public function removeUserBand(UserBand $userBand): static
    {
        if ($this->userBands->removeElement($userBand)) {
            // set the owning side to null (unless already changed)
            if ($userBand->getUserid() === $this) {
                $userBand->setUserid(null);
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
            $subscribedEvent->setUserid($this);
        }

        return $this;
    }

    public function removeSubscribedEvent(SubscribedEvent $subscribedEvent): static
    {
        if ($this->subscribedEvents->removeElement($subscribedEvent)) {
            // set the owning side to null (unless already changed)
            if ($subscribedEvent->getUserid() === $this) {
                $subscribedEvent->setUserid(null);
            }
        }

        return $this;
    }
}
