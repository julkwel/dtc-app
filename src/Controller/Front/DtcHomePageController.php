<?php

namespace App\Controller\Front;

use App\Entity\Cohorte;
use App\Entity\Review;
use App\Entity\StudentFormation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'dtc_')]
class DtcHomePageController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'home_page')]
    public function index(): Response
    {
        $openFormation = $this->entityManager->getRepository(Cohorte::class)->findBy(['isRegisterOpen' => true]);
        $students = $this->entityManager->getRepository(StudentFormation::class)->findBy([]);
        $reviews = $this->entityManager->getRepository(Review::class)->findBy(['isEnabled' => true]);

        return $this->render('dtc_home_page/index.html.twig', [
            'controller_name' => '',
            'formations' => $openFormation,
            'students' => $students,
            'reviews' => $reviews,
        ]);
    }

    #[Route('/rest-password', name: 'reset_password')]
    public function resetPassword(): Response
    {
        return $this->render('dtc_home_page/_reset_pass.html.twig');
    }
}
