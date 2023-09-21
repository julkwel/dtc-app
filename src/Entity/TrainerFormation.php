<?php

namespace App\Entity;

use App\Repository\TrainerFormationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainerFormationRepository::class)]
class TrainerFormation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Cohorte $formation = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $trainer = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $alias = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormation(): ?Cohorte
    {
        return $this->formation;
    }

    public function setFormation(?Cohorte $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    public function getTrainer(): ?User
    {
        return $this->trainer;
    }

    public function setTrainer(?User $trainer): static
    {
        $this->trainer = $trainer;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeImmutable $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }
}
