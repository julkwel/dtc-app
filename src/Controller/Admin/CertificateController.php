<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 25/09/2024
 */

namespace App\Controller\Admin;

use App\Domain\Certificat\CertificatService;
use App\Entity\Certificat;
use App\Entity\StudentFormation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/certificat', name: 'dtc_certificat_')]
class CertificateController extends AbstractController
{
    public function __construct(private readonly CertificatService $certificatService)
    {
    }

    #[Route('/generate/{id}', name: 'generate')]
    public function generate(StudentFormation $studentFormation): RedirectResponse
    {
        $this->certificatService->generateCertificate($studentFormation);

        return $this->redirectToRoute('admin_formation_show_registered', ['id' => $studentFormation->getFormation()->getId()]);
    }

    #[Route('/revoke/{id}', name: 'revoke')]
    public function revokeCertificate(Certificat $certificat): RedirectResponse
    {
        $this->certificatService->revokeCertificate($certificat);

        return $this->redirectToRoute('admin_formation_show_registered', ['id' => $certificat->getFormation()->getId()]);
    }
}