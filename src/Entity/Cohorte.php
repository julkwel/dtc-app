<?php

namespace App\Entity;

use App\Repository\CohorteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CohorteRepository::class)]
class Cohorte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $alias = null;

    #[ORM\Column(length: 255)]
    private ?string $amount = null;

    #[ORM\Column]
    private ?bool $isRegisterOpen;

    #[ORM\Column]
    private ?bool $isEnded;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $endedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cover = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, StudentFormation>
     */
    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: StudentFormation::class)]
    private Collection $studentFormations;

    public function __construct()
    {
        $this->isRegisterOpen = false;
        $this->isEnded = false;
        $this->studentFormations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function isIsRegisterOpen(): ?bool
    {
        return $this->isRegisterOpen;
    }

    public function setIsRegisterOpen(bool $isRegisterOpen): static
    {
        $this->isRegisterOpen = $isRegisterOpen;

        return $this;
    }

    public function isIsEnded(): ?bool
    {
        return $this->isEnded;
    }

    public function setIsEnded(bool $isEnded): static
    {
        $this->isEnded = $isEnded;

        return $this;
    }

    public function getEndedAt(): ?\DateTimeImmutable
    {
        return $this->endedAt;
    }

    public function setEndedAt(?\DateTimeImmutable $endedAt): static
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

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
     * @return Collection<int, StudentFormation>
     */
    public function getStudentFormations(): Collection
    {
        return $this->studentFormations;
    }

    public function addStudentFormation(StudentFormation $studentFormation): static
    {
        if (!$this->studentFormations->contains($studentFormation)) {
            $this->studentFormations->add($studentFormation);
            $studentFormation->setFormation($this);
        }

        return $this;
    }

    public function removeStudentFormation(StudentFormation $studentFormation): static
    {
        if ($this->studentFormations->removeElement($studentFormation)) {
            // set the owning side to null (unless already changed)
            if ($studentFormation->getFormation() === $this) {
                $studentFormation->setFormation(null);
            }
        }

        return $this;
    }
}
