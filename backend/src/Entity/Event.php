<?php

namespace App\Entity;

use App\Enum\StatusEnum;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\MaxDepth;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bar $bar = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Band $band = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateTime = null;

   #[ORM\Column(type: 'string', length: 50, enumType: StatusEnum::class)]
    private StatusEnum $status;

    /**
     * @var Collection<int, SubscribedEvent>
     */
    #[ORM\OneToMany(targetEntity: SubscribedEvent::class, mappedBy: 'event')]
    private Collection $subscribedEvents;

    public function __construct()
    {
        $this->subscribedEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBand(): ?Band
    {
        return $this->band;
    }

    public function setBand(?Band $band): static
    {
        $this->band = $band;

        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): static
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function setStatus(StatusEnum $status): static
    {
        $this->status = $status;

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
            $subscribedEvent->setEvent($this);
        }

        return $this;
    }

    public function removeSubscribedEvent(SubscribedEvent $subscribedEvent): static
    {
        if ($this->subscribedEvents->removeElement($subscribedEvent)) {
            // set the owning side to null (unless already changed)
            if ($subscribedEvent->getEvent() === $this) {
                $subscribedEvent->setEvent(null);
            }
        }

        return $this;
    }

    public function setRole(StatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }
}
