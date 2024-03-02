<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToMany(targetEntity: Animation::class, mappedBy: 'type')]
    private Collection $animations;

    public function __construct()
    {
        $this->animations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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
            $animation->setType($this);
        }

        return $this;
    }

    public function removeAnimation(Animation $animation): static
    {
        if ($this->animations->removeElement($animation)) {
            // set the owning side to null (unless already changed)
            if ($animation->getType() === $this) {
                $animation->setType(null);
            }
        }

        return $this;
    }
}
