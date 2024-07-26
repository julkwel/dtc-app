<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 24/07/2024
 */

namespace App\Controller\Middle;

use App\Entity\Cohorte;
use App\Entity\StudentFormation;
use App\Repository\CohorteRepository;
use App\Repository\StudentFormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CohorteRegistrationController extends AbstractController
{
    public function __construct(private StudentFormationRepository $studentFormationRepository, private CohorteRepository $cohorteRepository)
    {
    }

    #[Route('/register_cohorte/{id}', name: 'register_cohorte')]
    public function register(Cohorte $cohorte)
    {
        return $this->render(
            'middle/cohorte/register_to_cohorte.html.twig',
            [
                'cohorte' => $cohorte,
                'user' => $this->getUser(),
                'formations' => $this->cohorteRepository->getEnabledFormations(),
                'userIsRegistered' => $this->studentFormationRepository->findOneBy(['user' => $this->getUser(), 'formation' => $cohorte]),
            ]
        );
    }

    #[Route('/register_cohorte_confirmation/{id}', name: 'register_confirmation')]
    public function registerConfirmation(Cohorte $cohorte): RedirectResponse
    {
        try {
            $this->studentFormationRepository->saveNewStudentFormation($this->getUser(), $cohorte);
            $this->addFlash('success', 'Merci pour votre inscription, nous vous contacterons plus tard');
        } catch (Exception $exception) {
            $this->addFlash('error', $exception->getMessage());
        }

        return $this->redirectToRoute('dtc_home_page');
    }
}