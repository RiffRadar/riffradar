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
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'userBars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bar $bar_id = null;

    #[ORM\Column(type: 'string', length: 50, enumType: RolesEnum::class)]
    private RolesEnum $role;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getBarId(): ?Bar
    {
        return $this->bar_id;
    }

    public function setBarId(?Bar $bar_id): static
    {
        $this->bar_id = $bar_id;

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
