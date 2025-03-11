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
    private ?User $userid = null;

    #[ORM\ManyToOne(inversedBy: 'userBands')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Band $bandid = null;

    #[ORM\Column(type: 'string', length: 50, enumType: RolesEnum::class)]
    private RolesEnum $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserid(): ?User
    {
        return $this->userid;
    }

    public function setUserid(?User $userid): static
    {
        $this->userid = $userid;

        return $this;
    }

    public function getBandid(): ?Band
    {
        return $this->bandid;
    }

    public function setBandid(?Band $bandid): static
    {
        $this->bandid = $bandid;

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
