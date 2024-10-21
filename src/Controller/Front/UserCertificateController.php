<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 26/09/2024
 */

namespace App\Controller\Front;

use App\Domain\Certificat\CertificatService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/certificate', name: 'certificate_')]
class UserCertificateController extends AbstractController
{
    public function __construct(private readonly CertificatService $certificatService)
    {
    }

    #[Route('/certificate/{number}', name: 'verify')]
    public function verifyCertificate(string $number): Response
    {
        return $this->render('dtc_home_page/verify_certificate.html.twig', ['isValid' => $this->certificatService->verifyCertificate($number)]);
    }

    #[Route('/my-certificates', name: 'mine')]
    public function myCertificates(): Response
    {
        $user = $this->getUser();

        return $this->render('middle/student_profile/my_certificate.html.twig', ['certificates' => [], 'user' => $user]);
    }
}