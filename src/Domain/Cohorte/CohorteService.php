<?php

namespace App\Domain\Cohorte;

use App\Entity\Cohorte;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class CohorteService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function createCohorte(Cohorte $cohorteData): void
    {
        $cohorteData->setIsRegisterOpen(true);
        if (!$cohorteData->getId()) {
            $this->entityManager->persist($cohorteData);
        }
        $this->entityManager->flush();
    }

    public function switchStatus(Cohorte $cohorte): void
    {
        $cohorte->setIsRegisterOpen(!$cohorte->isIsRegisterOpen());
        $this->entityManager->flush();
    }
}
