<?php

namespace App\Entity;

use App\Enum\RolesEnum;
use App\Repository\UserBandRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserBandRepository::class)]
class UserBand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userBands')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userBands')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Band $band = null;

    #[ORM\Column(type: 'string', length: 50, enumType: RolesEnum::class)]
    private RolesEnum $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBand(): ?Band
    {
        return $this->band;
    }

    public function setBand(?Band $band): static
    {
        $this->band = $band;

        return $this;
    }

        public function getRole(): RolesEnum
    {
        return $this->role;
    }

    public function setRole(RolesEnum $role): static
    {
        $this->role = $role;

        return $this;
    }
}
