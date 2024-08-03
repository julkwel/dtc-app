<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 02/08/2024
 */

namespace App\Controller\Admin;

use App\Entity\TrainerFormation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/admin/trainer', name: 'admin_trainer_')]
class TrainerController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'list')]
    public function listTrainer(): Response
    {
        $trainers = $this->entityManager->getRepository(TrainerFormation::class)->findBy(['isEnabled' => true]);

        return $this->render('admin/trainer/Index.html.twig', ['trainers' => $trainers]);
    }
}