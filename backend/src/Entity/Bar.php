<?php

namespace App\Entity;

use App\Repository\BarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BarRepository::class)]
class Bar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coverImage = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $service = null;

    /**
     * @var Collection<int, Disponibility>
     */
    #[ORM\OneToMany(targetEntity: Disponibility::class, mappedBy: 'bar_id')]
    private Collection $disponibilities;

    /**
     * @var Collection<int, UserBar>
     */
    #[ORM\OneToMany(targetEntity: UserBar::class, mappedBy: 'bar_id')]
    private Collection $userBars;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\OneToMany(targetEntity: Event::class, mappedBy: 'barid')]
    private Collection $events;

    public function __construct()
    {
        $this->disponibilities = new ArrayCollection();
        $this->userBars = new ArrayCollection();
        $this->events = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): static
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getService(): ?array
    {
        return $this->service;
    }

    public function setService(?array $service): static
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection<int, Disponibility>
     */
    public function getDisponibilities(): Collection
    {
        return $this->disponibilities;
    }

    public function addDisponibility(Disponibility $disponibility): static
    {
        if (!$this->disponibilities->contains($disponibility)) {
            $this->disponibilities->add($disponibility);
            $disponibility->setBarId($this);
        }

        return $this;
    }

    public function removeDisponibility(Disponibility $disponibility): static
    {
        if ($this->disponibilities->removeElement($disponibility)) {
            // set the owning side to null (unless already changed)
            if ($disponibility->getBarId() === $this) {
                $disponibility->setBarId(null);
            }
        }

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
            $userBar->setBarId($this);
        }

        return $this;
    }

    public function removeUserBar(UserBar $userBar): static
    {
        if ($this->userBars->removeElement($userBar)) {
            // set the owning side to null (unless already changed)
            if ($userBar->getBarId() === $this) {
                $userBar->setBarId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setBarid($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getBarid() === $this) {
                $event->setBarid(null);
            }
        }

        return $this;
    }
}
