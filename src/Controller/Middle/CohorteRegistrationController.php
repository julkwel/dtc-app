<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 24/07/2024
 */

namespace App\Controller\Middle;

use App\Entity\Cohorte;
use App\Entity\StudentFormation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CohorteRegistrationController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/register_cohorte/{id}', name: 'register_cohorte')]
    public function register(Cohorte $cohorte)
    {
        return $this->render('middle/cohorte/register_to_cohorte.html.twig', ['cohorte' => $cohorte, 'user' => $this->getUser()]);
    }

    #[Route('/register_cohorte_confirmation/{id}', name: 'register_confirmation')]
    public function registerConfirmation(Request $request, Cohorte $cohorte)
    {
        $userFormation = new StudentFormation();
        $userFormation->setFormation($cohorte);
        $userFormation->setUser($this->getUser());

        $this->entityManager->persist($userFormation);
        $this->entityManager->flush();

        return $this->redirectToRoute('dtc_home_page');
    }
}