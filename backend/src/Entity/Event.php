<?php

namespace App\Entity;

use App\Enum\StatusEnum;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

   #[ORM\Column(type: 'string', length: 50, enumType: StatusEnum::class)]
    private StatusEnum $status;

    /**
     * @var Collection<int, SubscribedEvent>
     */
    #[ORM\OneToMany(targetEntity: SubscribedEvent::class, mappedBy: 'eventid')]
    private Collection $subscribedEvents;

    public function __construct()
    {
        $this->subscribedEvents = new ArrayCollection();
    }

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
            $subscribedEvent->setEventid($this);
        }

        return $this;
    }

    public function removeSubscribedEvent(SubscribedEvent $subscribedEvent): static
    {
        if ($this->subscribedEvents->removeElement($subscribedEvent)) {
            // set the owning side to null (unless already changed)
            if ($subscribedEvent->getEventid() === $this) {
                $subscribedEvent->setEventid(null);
            }
        }

        return $this;
    }
    
    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function setRole(StatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }
}
