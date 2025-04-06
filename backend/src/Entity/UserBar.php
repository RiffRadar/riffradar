<?php

namespace App\Entity;

use App\Enum\RolesEnum;
use App\Repository\UserBarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserBarRepository::class)]
class UserBar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userBars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userBars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bar $bar = null;

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

    public function getBar(): ?Bar
    {
        return $this->bar;
    }

    public function setBar(?Bar $bar): static
    {
        $this->bar = $bar;

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
