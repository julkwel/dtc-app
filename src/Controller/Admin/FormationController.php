<?php

/**
 * @author Fullfifax
 * Date : 03/11/2023
 */

namespace App\Controller\Admin;

use App\Domain\Cohorte\CohorteService;
use App\Entity\Cohorte;
use App\Form\AddFormationFormType;
use App\Repository\CohorteRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/formation', name: 'admin_formation_')]
class FormationController extends AbstractController
{
    public function __construct(private readonly CohorteRepository $cohorteRepository)
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

    #[Route(path: '/add', name: 'add')]
    public function addFormation(Request $request, CohorteService $cohorteService): Response
    {
        $form = $this->createForm(AddFormationFormType::class, new Cohorte());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cohorteData = $form->getData();
            $cohorteService->createCohorte($cohorteData);

            return $this->redirectToRoute('admin_formation_list');
        }

        return $this->render(
            'admin/dashboard/formation/add_formation.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route(path: '/edit/{id}', name: 'edit')]
    public function editFormation(Request $request, Cohorte $cohorte, CohorteService $cohorteService): Response
    {
        $form = $this->createForm(AddFormationFormType::class, $cohorte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cohorteData = $form->getData();
            $cohorteService->createCohorte($cohorteData);

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
}