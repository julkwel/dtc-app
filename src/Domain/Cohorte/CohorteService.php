<?php

namespace App\Domain\Cohorte;

use App\Domain\Files\FileUploadService;
use App\Entity\Cohorte;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CohorteService
{
    public function __construct(private readonly EntityManagerInterface $entityManager, private FileUploadService $fileUploadService)
    {
    }

    /**
     * @throws \Exception
     */
    public function createCohorte(FormInterface $form, Cohorte $cohorteData): void
    {
        $file = $form->get('cover')->getData();
        if ($file instanceof UploadedFile) {
            $fileName = $this->fileUploadService->uploadFile($file);
            $cohorteData->setCover($fileName);
        }

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
