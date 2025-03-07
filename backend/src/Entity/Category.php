<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'categories')]
    private ?self $category_id = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'category_id')]
    private Collection $categories;

    /**
     * @var Collection<int, Band>
     */
    #[ORM\ManyToMany(targetEntity: Band::class, mappedBy: 'categories')]
    private Collection $bands;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->bands = new ArrayCollection();
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

    public function getCategoryId(): ?self
    {
        return $this->category_id;
    }

    public function setCategoryId(?self $category_id): static
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(self $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setCategoryId($this);
        }

        return $this;
    }

    public function removeCategory(self $category): static
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getCategoryId() === $this) {
                $category->setCategoryId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Band>
     */
    public function getBands(): Collection
    {
        return $this->bands;
    }

    public function addBand(Band $band): static
    {
        if (!$this->bands->contains($band)) {
            $this->bands->add($band);
            $band->addCategory($this);
        }

        return $this;
    }

    public function removeBand(Band $band): static
    {
        if ($this->bands->removeElement($band)) {
            $band->removeCategory($this);
        }

        return $this;
    }
}
