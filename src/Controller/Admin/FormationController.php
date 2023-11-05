<?php

/**
 * @author Fullfifax
 * Date : 03/11/2023
 */

namespace App\Controller\Admin;

use App\Entity\Cohorte;
use App\Form\AddFormationFormType;
use Doctrine\ORM\EntityManagerInterface;
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
    public function addFormation(Request $request, EntityManagerInterface $em)
    {
        $cohorte = new Cohorte();
        $form = $this->createForm(AddFormationFormType::class, $cohorte);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($cohorte);
            $em->flush();
        }

        return $this->render('admin/dashboard/formation/add_formation.html.twig', [
            'form' => $form->createView()
        ]);
    }
}