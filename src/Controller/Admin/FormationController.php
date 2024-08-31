<?php

/**
 * @author Fullfifax
 * Date : 03/11/2023
 */

namespace App\Controller\Admin;

use App\Domain\Cohorte\CohorteService;
use App\Entity\Cohorte;
use App\Entity\StudentFormation;
use App\Entity\User;
use App\Form\AddFormationFormType;
use App\Repository\CohorteRepository;
use App\Repository\StudentFormationRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/formation', name: 'admin_formation_')]
class FormationController extends AbstractController
{
    public function __construct(private readonly CohorteRepository $cohorteRepository, private readonly StudentFormationRepository $studentFormationRepository)
    {
    }

    #[Route(path: '/', name: 'list')]
    public function listFormation(): Response
    {
        return $this->render(
            'admin/dashboard/formation/formation.html.twig',
            [
                'formations' => $this->cohorteRepository->findBy([]),
            ]
        );
    }

    /**
     * @throws \Exception
     */
    #[Route(path: '/add', name: 'add')]
    public function addFormation(Request $request, CohorteService $cohorteService): Response
    {
        $form = $this->createForm(AddFormationFormType::class, new Cohorte());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cohorteData = $form->getData();
            $cohorteService->createCohorte($form, $cohorteData);

            return $this->redirectToRoute('admin_formation_list');
        }

        return $this->render(
            'admin/dashboard/formation/add_formation.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @throws \Exception
     */
    #[Route(path: '/edit/{id}', name: 'edit')]
    public function editFormation(Request $request, Cohorte $cohorte, CohorteService $cohorteService): Response
    {
        $form = $this->createForm(AddFormationFormType::class, $cohorte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cohorteData = $form->getData();
            $cohorteService->createCohorte($form, $cohorteData);

            return $this->redirectToRoute('admin_formation_list');
        }

        return $this->render(
            'admin/dashboard/formation/add_formation.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route(path: '/edit_status/{id}', name: 'edit_status')]
    public function editFormationStatus(Cohorte $cohorte, CohorteService $cohorteService): Response
    {
        $cohorteService->switchStatus($cohorte);

        return $this->redirectToRoute('admin_formation_list');
    }

    #[Route(path: '/registered/{id}', name: 'show_registered')]
    public function showRegistered(Cohorte $cohorte)
    {
        $registered = $this->studentFormationRepository->findBy(['formation' => $cohorte]);

        return $this->render(
            'admin/dashboard/formation/registered.html.twig',
            [
                'lists' => $registered,
                'formation' => $cohorte,
            ]
        );
    }

    #[Route('/switch_student_status/{id}', name: 'switch_student_formation')]
    public function switchUserIsConfirmed(StudentFormation $studentFormation): RedirectResponse
    {
        $this->studentFormationRepository->switchUserStatus($studentFormation);

        return $this->redirectToRoute('admin_formation_show_registered', ['id' => $studentFormation->getFormation()->getId()]);
    }

    #[Route('/affect_student/{id}/{cohorte?}', name: 'affect_student')]
    public function affectUserWithFormation(CohorteService $cohorteService, User $user, Cohorte $cohorte = null)
    {
        $formations = $this->cohorteRepository->getEnabledFormations();

        if ($cohorte) {
            $cohorteService->affectStudent($user, $cohorte);

            return $this->redirectToRoute('admin_formation_list');
        }

        return $this->render('admin/dashboard/formation/affectation.html.twig',
            [
                'lists' => $formations,
                'student' => $user,
            ]
        );
    }

    #[Route('/remove_affectation/{id}', name: 'remove_affectation')]
    public function removeUserFromFormation(CohorteService $cohorteService, StudentFormation $studentFormation): RedirectResponse
    {
        $cohorteService->removeUserAffectation($studentFormation);

        return $this->redirectToRoute('admin_formation_list');
    }
}
