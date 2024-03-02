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
    private ?string $categoryName = null;

    #[ORM\ManyToMany(targetEntity: Animation::class, mappedBy: 'category')]
    private Collection $animations;

    public function __construct()
    {
        $this->animations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): static
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * @return Collection<int, Animation>
     */
    public function getAnimations(): Collection
    {
        return $this->animations;
    }

    public function addAnimation(Animation $animation): static
    {
        if (!$this->animations->contains($animation)) {
            $this->animations->add($animation);
            $animation->addCategory($this);
        }

        return $this;
    }

    public function removeAnimation(Animation $animation): static
    {
        if ($this->animations->removeElement($animation)) {
            $animation->removeCategory($this);
        }

        return $this;
    }
}
