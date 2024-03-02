<?php

namespace App\Entity;

use App\Repository\AnimationStudioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimationStudioRepository::class)]
class AnimationStudio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $studioName = null;

    #[ORM\OneToMany(targetEntity: Animation::class, mappedBy: 'AnimationStudio')]
    private Collection $animations;

    public function __construct()
    {
        $this->animations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudioName(): ?string
    {
        return $this->studioName;
    }

    public function setStudioName(string $studioName): static
    {
        $this->studioName = $studioName;

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
            $animation->setAnimationStudio($this);
        }

        return $this;
    }

    public function removeAnimation(Animation $animation): static
    {
        if ($this->animations->removeElement($animation)) {
            // set the owning side to null (unless already changed)
            if ($animation->getAnimationStudio() === $this) {
                $animation->setAnimationStudio(null);
            }
        }

        return $this;
    }
}
