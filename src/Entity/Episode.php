<?php

namespace App\Entity;

use App\Repository\EpisodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpisodeRepository::class)]
class Episode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 1000)]
    private ?string $synopsis = null;

    #[ORM\Column]
    private ?int $numberEpisode = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $duration = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $broadcastingDate = null;

    #[ORM\Column]
    private ?int $numberSeason = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'episodes')]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'episodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animation $animation = null;


    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getNumberEpisode(): ?int
    {
        return $this->numberEpisode;
    }

    public function setNumberEpisode(int $numberEpisode): static
    {
        $this->numberEpisode = $numberEpisode;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(\DateTimeInterface $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getBroadcastingDate(): ?\DateTimeInterface
    {
        return $this->broadcastingDate;
    }

    public function setBroadcastingDate(\DateTimeInterface $broadcastingDate): static
    {
        $this->broadcastingDate = $broadcastingDate;

        return $this;
    }

    public function getNumberSeason(): ?int
    {
        return $this->numberSeason;
    }

    public function setNumberSeason(int $numberSeason): static
    {
        $this->numberSeason = $numberSeason;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->users->removeElement($user);

        return $this;
    }

    public function getAnimation(): ?Animation 
    {
        return $this->animation;
    }

    public function setAnimation(?Animation $animation): static 
    {
        $this->animation = $animation;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title; 
    }


}