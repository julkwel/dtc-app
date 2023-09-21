<?php

namespace App\Entity;

use App\Repository\SupportFormationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\Tools\Console\Exception\FileTypeNotSupported;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupportFormationRepository::class)]
class SupportFormation
{
    public const VIDEO_TYPE = 1;
    public const PDF_TYPE = 2;
    public const IMG_TYPE = 3;
    public const OTHER_TYPE = 4;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $fileName = null;

    #[ORM\ManyToOne]
    private ?Cohorte $formation = null;

    #[ORM\Column]
    private ?int $type = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): static
    {
        $this->fileName = $fileName;

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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        if (!in_array($type, self::getAllType())) {
            throw new \App\Exception\FileTypeNotSupported("File not supported");
        }
        $this->type = $type;

        return $this;
    }

    public static function getAllType()
    {
        return [self::VIDEO_TYPE, self::PDF_TYPE, self::OTHER_TYPE, self::IMG_TYPE];
    }
}
