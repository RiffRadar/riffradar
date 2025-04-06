<?php

namespace App\Entity;

use App\Repository\BandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BandRepository::class)]
class Band
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coverImage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $embedLink = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'bands')]
    private Collection $categories;

    /**
     * @var Collection<int, UserBand>
     */
    #[ORM\OneToMany(targetEntity: UserBand::class, mappedBy: 'band')]
    private Collection $userBands;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->userBands = new ArrayCollection();
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

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getEmbedLink(): ?string
    {
        return $this->embedLink;
    }

    public function setEmbedLink(string $embedLink): static
    {
        $this->embedLink = $embedLink;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

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
            $userBand->setBand($this);
        }

        return $this;
    }

    public function removeUserBand(UserBand $userBand): static
    {
        if ($this->userBands->removeElement($userBand)) {
            // set the owning side to null (unless already changed)
            if ($userBand->getBand() === $this) {
                $userBand->setBand(null);
            }
        }

        return $this;
    }
}
