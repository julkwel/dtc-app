<?php
/**
 * @author julienrajerison5@gmail.com
 *
 * Date : 19/09/2023
 */

namespace App\Controller\Admin;

use App\Entity\Cohorte;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin', name: 'admin_dashboard_')]
class DashboardController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/', name: 'index')]
    public function index(): Response
    {
        $formations = $this->entityManager->getRepository(Cohorte::class)->findBy([]);
        $students = $this->entityManager->getRepository(User::class)->getUserByRole();
        $trainers = $this->entityManager->getRepository(User::class)->getUserByRole(User::ROLE_TRAINER);
        $admins = $this->entityManager->getRepository(User::class)->getUserByRole(User::ROLE_ADMIN);

        return $this->render(
            'admin/dashboard/index.html.twig',
            [
                'formations' => $formations,
                'students' => $students,
                'trainers' => $trainers,
                'admins' => $admins,
            ]
        );
    }
}