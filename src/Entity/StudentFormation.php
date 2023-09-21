<?php

namespace App\Entity;

use App\Repository\StudentFormationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentFormationRepository::class)]
class StudentFormation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Cohorte $formation = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $User = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $certificate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $paidAmount = null;

    #[ORM\Column]
    private ?bool $isTotalPaid = null;

    public function __construct()
    {
        $this->isTotalPaid = false;
    }

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

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }

    public function getCertificate(): ?string
    {
        return $this->certificate;
    }

    public function setCertificate(?string $certificate): static
    {
        $this->certificate = $certificate;

        return $this;
    }

    public function getPaidAmount(): ?string
    {
        return $this->paidAmount;
    }

    public function setPaidAmount(?string $paidAmount): static
    {
        $this->paidAmount = $paidAmount;

        return $this;
    }

    public function isIsTotalPaid(): ?bool
    {
        return $this->isTotalPaid;
    }

    public function setIsTotalPaid(bool $isTotalPaid): static
    {
        $this->isTotalPaid = $isTotalPaid;

        return $this;
    }
}
