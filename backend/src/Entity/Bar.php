<?php

namespace App\Entity;

use App\Repository\BarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\MaxDepth;


#[ORM\Entity(repositoryClass: BarRepository::class)]
class Bar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
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
     * @var Collection<int, Availability>
     */
    #[ORM\OneToMany(targetEntity: Availability::class, mappedBy: 'bar')]
    private Collection $availabilities;

    /**
     * @var Collection<int, UserBar>
     */
    #[ORM\OneToMany(targetEntity: UserBar::class, mappedBy: 'bar')]
    private Collection $userBars;

    public function __construct()
    {
        $this->availabilities = new ArrayCollection();
        $this->userBars = new ArrayCollection();
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
     * @return Collection<int, Availability>
     */
    public function getAvailabilities(): Collection
    {
        return $this->availabilities;
    }

    public function addAvailability(Availability $availability): static
    {
        if (!$this->availabilities->contains($availability)) {
            $this->availabilities->add($availability);
            $availability->setBar($this);
        }

        return $this;
    }

    public function removeAvailability(Availability $availability): static
    {
        if ($this->availabilities->removeElement($availability)) {
            // set the owning side to null (unless already changed)
            if ($availability->getBar() === $this) {
                $availability->setBar(null);
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
            $userBar->setBar($this);
        }

        return $this;
    }

    public function removeUserBar(UserBar $userBar): static
    {
        if ($this->userBars->removeElement($userBar)) {
            // set the owning side to null (unless already changed)
            if ($userBar->getBar() === $this) {
                $userBar->setBar(null);
            }
        }

        return $this;
    }
}
