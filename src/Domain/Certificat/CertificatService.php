<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 25/09/2024
 */

namespace App\Domain\Certificat;

use App\Entity\Certificat;
use App\Entity\StudentFormation;
use Doctrine\ORM\EntityManagerInterface;

class CertificatService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function generateCertificate(StudentFormation $studentFormation): void
    {
        $certificat = new Certificat();
        $certificat->setUser($studentFormation->getUser());
        $certificat->setFormation($studentFormation->getFormation());
        $certificat->setValidity((new \DateTime('now + 2 years')));
        $sign = sprintf('dtc-%s-ET%s', (new \DateTime('now'))->format('Y'), $studentFormation->getUser()->getId());
        $number = sprintf('%s-%s', $studentFormation->getFormation()->getId(), $studentFormation->getUser()->getId());

        $certificat->setSign($sign);
        $certificat->setNumber($number);

        $this->entityManager->persist($certificat);
        $this->entityManager->flush();

        $studentFormation->setCertificate($certificat->getId());
        $this->entityManager->flush();
    }

    public function revokeCertificate(Certificat $certificat): void
    {
        $certificat->setSign(null);
        $certificat->setNumber(null);

        $this->entityManager->flush();
    }

    public function verifyCertificate(string $number): bool
    {
        $certificate = $this->entityManager->getRepository(Certificat::class)->findOneBy(['number' => $number]);

        return $certificate && $certificate->getSign();
    }
}