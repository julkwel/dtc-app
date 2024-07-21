<?php

namespace App\Domain\Cohorte;

use App\Entity\Cohorte;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class CohorteService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createCohorte($cohorteData)
    {
        $cohorte = new Cohorte();

        $cohorte->setName($cohorteData->getName());
        $cohorte->setAlias($cohorteData->getAlias());
        $cohorte->setAmount($cohorteData->getAmount());
        $cohorte->setIsRegisterOpen(true);

        $cohorte->setStartDate($cohorteData->getStartDate());
        $cohorte->setEndDate($cohorte->getEndDate());

        // Convert DateTime to DateTimeImmutable
        $endDate = DateTimeImmutable::createFromMutable($cohorteData->getEndDate());
        $cohorte->setEndedAt($endDate);

        $this->entityManager->persist($cohorte);
        $this->entityManager->flush();
    }
}
