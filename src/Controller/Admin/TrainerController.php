<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 02/08/2024
 */

namespace App\Controller\Admin;

use App\Entity\TrainerFormation;
use App\Form\TrainerFormationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/trainer', name: 'admin_trainer_')]
class TrainerController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'list')]
    public function listTrainer(): Response
    {
        $trainers = $this->entityManager->getRepository(TrainerFormation::class)->findBy(['isEnabled' => true]);

        return $this->render('admin/trainer/Index.html.twig', ['trainers' => $trainers]);
    }

    #[Route('/manage/{id?}', name: 'manage')]
    public function manageTrainer(Request $request, TrainerFormation $trainer = null): RedirectResponse|Response
    {
        $trainer = $trainer ?? new TrainerFormation();
        $form = $this->createForm(TrainerFormationType::class, $trainer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$trainer->getId()) {
                $this->entityManager->persist($trainer);
            }
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_trainer_list');
        }

        return $this->render('admin/trainer/edit_trainer.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/change/statut/{id}', name: 'change_statut')]
    public function changeState(TrainerFormation $trainerFormation): RedirectResponse
    {
        $trainerFormation->setEnabled(!$trainerFormation->isEnabled());
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_trainer_list');
    }
}