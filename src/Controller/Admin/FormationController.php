<?php

/**
 * @author Fullfifax
 * Date : 03/11/2023
 */

namespace App\Controller\Admin;

use App\Domain\Cohorte\CohorteService;
use App\Form\AddFormationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin/dashboard/formation', name: 'admin_formation_')]
class FormationController extends AbstractController
{
    #[Route(path: '/', name: 'index')]
    public function listFormation()
    {
        return $this->render('admin/dashboard/formation/formation.html.twig');
    }

    #[Route(path: '/add', name: 'add')]
    public function addFormation(Request $request, CohorteService $cohorteService)
    {
        $form = $this->createForm(AddFormationFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cohorteData = $form->getData();

            $cohorteService->createCohorte($cohorteData);
        }

        return $this->render('admin/dashboard/formation/add_formation.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
