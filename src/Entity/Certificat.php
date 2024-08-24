<?php

namespace App\Entity;

use App\Repository\CertificatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CertificatRepository::class)]
class Certificat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'certificats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $validity = null;

    #[ORM\ManyToOne(inversedBy: 'certificats')]
    private ?Cohorte $formation = null;

    #[ORM\Column(length: 255)]
    private ?string $mention = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sign = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getValidity(): ?\DateTimeInterface
    {
        return $this->validity;
    }

    public function setValidity(?\DateTimeInterface $validity): static
    {
        $this->validity = $validity;

        return $this;
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

    public function getMention(): ?string
    {
        return $this->mention;
    }

    public function setMention(string $mention): static
    {
        $this->mention = $mention;

        return $this;
    }

    public function getSign(): ?string
    {
        return $this->sign;
    }

    public function setSign(?string $sign): static
    {
        $this->sign = $sign;

        return $this;
    }
}
