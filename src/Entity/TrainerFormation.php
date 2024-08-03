<?php

namespace App\Entity;

use App\Repository\TrainerFormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: TrainerFormationRepository::class)]
class TrainerFormation
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $trainer = null;

    #[ORM\Column(nullable:true)]
    private ?\DateTimeImmutable $startedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $alias = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Cohorte>
     */
    #[ORM\OneToMany(mappedBy: 'trainer', targetEntity: Cohorte::class)]
    private Collection $cohortes;

    #[ORM\Column]
    private ?bool $isEnabled = true;

    public function __construct()
    {
        $this->cohortes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Cohorte>
     */
    public function getCohortes(): Collection
    {
        return $this->cohortes;
    }

    public function addCohorte(Cohorte $cohorte): static
    {
        if (!$this->cohortes->contains($cohorte)) {
            $this->cohortes->add($cohorte);
            $cohorte->setTrainer($this);
        }

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setEnabled(bool $isEnabled): static
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }
}
