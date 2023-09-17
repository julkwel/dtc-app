<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Cohorte $cohorte = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $amountPaid = null;

    #[ORM\Column]
    private ?bool $isTotalyPaid = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalPresent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCohorte(): ?Cohorte
    {
        return $this->cohorte;
    }

    public function setCohorte(?Cohorte $cohorte): static
    {
        $this->cohorte = $cohorte;

        return $this;
    }

    public function getAmountPaid(): ?string
    {
        return $this->amountPaid;
    }

    public function setAmountPaid(?string $amountPaid): static
    {
        $this->amountPaid = $amountPaid;

        return $this;
    }

    public function isIsTotalyPaid(): ?bool
    {
        return $this->isTotalyPaid;
    }

    public function setIsTotalyPaid(bool $isTotalyPaid): static
    {
        $this->isTotalyPaid = $isTotalyPaid;

        return $this;
    }

    public function getTotalPresent(): ?int
    {
        return $this->totalPresent;
    }

    public function setTotalPresent(?int $totalPresent): static
    {
        $this->totalPresent = $totalPresent;

        return $this;
    }
}
