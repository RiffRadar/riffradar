<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bar $barid = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Band $bandid = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $time = null;

    #[ORM\Column(length: 50)]
    private ?string $enum = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBarid(): ?Bar
    {
        return $this->barid;
    }

    public function setBarid(?Bar $barid): static
    {
        $this->barid = $barid;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getEnum(): ?string
    {
        return $this->enum;
    }

    public function setEnum(string $enum): static
    {
        $this->enum = $enum;

        return $this;
    }
}
